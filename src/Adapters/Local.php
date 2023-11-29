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

namespace Hiepvq\Upload\Adapters;

use Flarum\Foundation\Paths;
use Flarum\Http\UrlGenerator;
use Flarum\Settings\SettingsRepositoryInterface;
use Hiepvq\Upload\Contracts\UploadAdapter;
use Hiepvq\Upload\File;
use League\Flysystem\Adapter\Local as AdapterLocal;

class Local extends Flysystem implements UploadAdapter
{
    /**
     * @var AdapterLocal
     */
    protected $adapter;

    protected function generateUrl(File $file)
    {
        $publicPath = resolve(Paths::class)->public;

        $searches = [];
        $replaces = [];

        if (is_link($filesDir = $publicPath.DIRECTORY_SEPARATOR.'assets/files')) {
            $searches[] = realpath($filesDir);
            $replaces[] = 'assets/files';
        }

        if (is_link($assetsDir = $publicPath.DIRECTORY_SEPARATOR.'assets')) {
            $searches[] = realpath($assetsDir);
            $replaces[] = 'assets';
        }

        $searches = array_merge($searches, [$publicPath, DIRECTORY_SEPARATOR]);
        $replaces = array_merge($replaces, ['', '/']);

        $file->url = str_replace(
            $searches,
            $replaces,
            $this->adapter->applyPathPrefix($this->meta['path'])
        );

        /** @var SettingsRepositoryInterface $settings */
        $settings = resolve(SettingsRepositoryInterface::class);
        /** @var UrlGenerator $generator */
        $generator = resolve(UrlGenerator::class);

        if ($settings->get('hiepvq-upload.cdnUrl')) {
            $file->url = $settings->get('hiepvq-upload.cdnUrl').$file->url;
        } else {
            $file->url = $generator->to('forum')->path(ltrim($file->url, '/'));
        }
    }
}
