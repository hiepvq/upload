<?php

/*
 * This file is part of hiepvq/upload.
 *
 * Copyright (c) FriendsOfFlarum.
 * Copyright (c) Flagrow.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiepvq\Upload\Commands;

use Flarum\Foundation\Application;
use Flarum\Foundation\ValidationException;
use Flarum\Http\UrlGenerator;
use Hiepvq\Upload\Events;
use Hiepvq\Upload\File;
use Hiepvq\Upload\Helpers\Util;
use Hiepvq\Upload\Repositories\FileRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Psr\Http\Message\UploadedFileInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UploadHandler
{
    /**
     * @var Cloud
     */
    protected $privateSharedDir;

    public function __construct(
        protected Application $app,
        protected Dispatcher $events,
        protected Util $util,
        protected FileRepository $files,
        protected TranslatorInterface $translator,
        protected UrlGenerator $url,
        Factory $factory
    ) {
        $this->privateSharedDir = $factory->disk('private-shared');
    }

    /**
     * @param Upload $command
     *
     * @throws \Flarum\User\Exception\PermissionDeniedException
     *
     * @return \Illuminate\Support\Collection
     */
    public function handle(Upload $command): Collection
    {
        if ($command->shared) {
            $command->actor->assertCan('hiepvq-upload.upload-shared-files');
        } else {
            $command->actor->assertCan('hiepvq-upload.upload');
        }

        $savedFiles = $command->files->map(function (UploadedFileInterface $file) use ($command) {
            $privateShared = $command->shared && $command->hideFromMediaManager;

            $upload = $this->files->moveUploadedFileToTemp($file);

            try {

                $mime = $this->files->determineMime($upload);

                $this->files->sanitizeSvg($upload, $mime);

                $mimeConfiguration = $this->util->getMimeConfiguration($mime);
                $adapter = $this->util->getAdapter(Arr::get($mimeConfiguration, 'adapter'));
                $template = $this->util->getTemplate(Arr::get($mimeConfiguration, 'template', 'file'));

                $this->events->dispatch(
                    new Events\Adapter\Identified($command->actor, $upload, $adapter)
                );

                if (!$privateShared) {
                    if (!$adapter) {
                        throw new ValidationException(['upload' => $this->translator->trans('hiepvq-upload.api.upload_errors.forbidden_type')]);
                    }

                    if (!$adapter->forMime($mime)) {
                        throw new ValidationException(['upload' => $this->translator->trans('hiepvq-upload.api.upload_errors.unsupported_type', ['mime' => $mime])]);
                    }
                }

                $file = $this->files->createFileFromUpload(
                    $upload,
                    $command->actor,
                    $mime,
                    $command->hideFromMediaManager,
                    $command->shared
                );

                $this->events->dispatch(
                    new Events\File\WillBeUploaded($command->actor, $file, $upload, $mime)
                );

                $response = null;

                if ($privateShared) {
                    $success = $this->privateSharedDir->put(
                        $file->path = $this->files->generateFilenameFor($file),
                        $this->files->readUpload($upload)
                    );

                    if ($success) {
                        $file->upload_method = 'private-shared';
                        $file->url = $this->url->to('api')->route('hiepvq-upload.download.uuid', [
                            'uuid' => $file->uuid,
                        ]);

                        $response = $file;
                    }
                } else {
                    $response = $adapter->upload(
                        $file,
                        $upload,
                        $this->files->readUpload($upload, $adapter)
                    );
                }

                $this->files->removeFromTemp($upload);

                if (!($response instanceof File)) {
                    return false;
                }

                $file = $response;

                if (!$privateShared) {
                    $file->upload_method = Str::lower(Str::afterLast($adapter::class, '\\'));
                }

                $file->tag = $template;

                $this->events->dispatch(
                    new Events\File\WillBeSaved($command->actor, $file, $upload, $mime)
                );

                if ($file->isDirty() || !$file->exists) {
                    $file->save();
                }

                $this->events->dispatch(
                    new Events\File\WasSaved($command->actor, $file, $upload, $mime)
                );
            } catch (\Exception $e) {
                if (isset($upload)) {
                    $this->files->removeFromTemp($upload);
                }

                throw $e;
            }

            return $file;
        });

        return $savedFiles->filter();
    }
}
