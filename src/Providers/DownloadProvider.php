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

namespace Hiepvq\Upload\Providers;

use Flarum\Foundation\AbstractServiceProvider;
use Hiepvq\Upload\Commands\DownloadHandler;
use Hiepvq\Upload\Downloader\DefaultDownloader;
use Hiepvq\Upload\Helpers\Util;
use Hiepvq\Upload\Templates\BbcodeImageTemplate;
use Hiepvq\Upload\Templates\FileTemplate;
use Hiepvq\Upload\Templates\ImagePreviewTemplate;
use Hiepvq\Upload\Templates\ImageTemplate;
use Hiepvq\Upload\Templates\JustUrlTemplate;
use Hiepvq\Upload\Templates\MarkdownImageTemplate;
use Hiepvq\Upload\Templates\TextPreviewTemplate;

class DownloadProvider extends AbstractServiceProvider
{
    public function register()
    {
        DownloadHandler::addDownloader(
            $this->container->make(DefaultDownloader::class)
        );

        /** @var Util $util */
        $util = $this->container->make(Util::class);

        $util->addRenderTemplate($this->container->make(FileTemplate::class));
        $util->addRenderTemplate($this->container->make(ImageTemplate::class));
        $util->addRenderTemplate($this->container->make(ImagePreviewTemplate::class));
        $util->addRenderTemplate($this->container->make(JustUrlTemplate::class));
        $util->addRenderTemplate($this->container->make(MarkdownImageTemplate::class));
        $util->addRenderTemplate($this->container->make(BbcodeImageTemplate::class));
        $util->addRenderTemplate($this->container->make(TextPreviewTemplate::class));
    }
}
