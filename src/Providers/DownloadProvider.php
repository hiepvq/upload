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

namespace HiepVq\Upload\Providers;

use Flarum\Foundation\AbstractServiceProvider;
use HiepVq\Upload\Commands\DownloadHandler;
use HiepVq\Upload\Downloader\DefaultDownloader;

class DownloadProvider extends AbstractServiceProvider
{
    public function register()
    {
        DownloadHandler::addDownloader(
            $this->container->make(DefaultDownloader::class)
        );
    }
}
