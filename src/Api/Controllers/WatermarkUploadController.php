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

namespace Hiepvq\Upload\Api\Controllers;

use Flarum\Api\Controller\ShowForumController;
use Flarum\Foundation\Paths;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class WatermarkUploadController extends ShowForumController
{
    protected $settings;
    protected $paths;

    public function __construct(SettingsRepositoryInterface $settings, Paths $paths)
    {
        $this->settings = $settings;
        $this->paths = $paths;
    }

    public function data(ServerRequestInterface $request, Document $document)
    {
        $request->getAttribute('actor')->assertAdmin();

        $file = Arr::get($request->getUploadedFiles(), 'hiepvq/watermark');

        $tmpFile = tempnam($this->paths->storage.'/tmp', 'hiepvq-watermark');

        $file->moveTo($tmpFile);

        $mount = new MountManager([
            'source' => new Filesystem(new Local(pathinfo($tmpFile, PATHINFO_DIRNAME))),
            'target' => new Filesystem(new Local($this->paths->storage)),
        ]);

        if (($path = $this->settings->get('hiepvq-upload.watermark')) && $mount->has($file = "target://$path")) {
            $mount->delete($file);
        }

        $uploadName = 'hiepvq-upload-watermark-'.Str::lower(Str::random(8));

        $mount->move('source://'.pathinfo($tmpFile, PATHINFO_BASENAME), "target://$uploadName");

        $this->settings->set('hiepvq-upload.watermark', $uploadName);

        return parent::data($request, $document);
    }
}
