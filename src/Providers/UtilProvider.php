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
use HiepVq\Upload\Helpers\Util;
use HiepVq\Upload\Templates;
use Illuminate\Contracts\Container\Container;

class UtilProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->container->singleton(Util::class, function (Container $container) {
            $util = new Util();

            $util->addRenderTemplate($container->make(Templates\FileTemplate::class));
            $util->addRenderTemplate($container->make(Templates\ImageTemplate::class));
            $util->addRenderTemplate($container->make(Templates\ImagePreviewTemplate::class));
            $util->addRenderTemplate($container->make(Templates\JustUrlTemplate::class));
            $util->addRenderTemplate($container->make(Templates\MarkdownImageTemplate::class));
            $util->addRenderTemplate($container->make(Templates\BbcodeImageTemplate::class));
            $util->addRenderTemplate($container->make(Templates\TextPreviewTemplate::class));

            return $util;
        });
    }
}
