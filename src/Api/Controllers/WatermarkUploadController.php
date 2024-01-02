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

namespace HiepVq\Upload\Api\Controllers;

use Flarum\Api\Controller\ShowForumController;
use Flarum\Foundation\Paths;
use Flarum\Http\RequestUtil;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Tobscure\JsonApi\Document;

class WatermarkUploadController extends ShowForumController
{
    /**
     * @var Cloud
     */
    protected $assetsDir;

    public function __construct(
        protected SettingsRepositoryInterface $settings,
        protected Paths $paths,
        Factory $factory
    ) {
        $this->assetsDir = $factory->disk('flarum-assets');
    }

    public function data(ServerRequestInterface $request, Document $document)
    {
        RequestUtil::getActor($request)->assertAdmin();

        /**
         * @var UploadedFileInterface $file
         */
        $file = Arr::get($request->getUploadedFiles(), 'hiepvq-watermark');

        $tmpFile = @tempnam($this->paths->storage.'/tmp', 'hiepvq-watermark');

        $file->moveTo($tmpFile);

        $uploadName = 'hiepvq-upload-watermark-'.Str::lower(Str::random(8)).'-'.$file->getClientFilename();

        $this->assetsDir->put($uploadName, file_get_contents($tmpFile));

        $this->settings->set('hiepvq-watermark_path', $uploadName);

        unlink($tmpFile);

        return parent::data($request, $document);
    }
}
