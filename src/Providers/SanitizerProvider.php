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

use enshrined\svgSanitize\Sanitizer;
use Flarum\Foundation\AbstractServiceProvider;
use HiepVq\Upload\Sanitizer\SvgAllowedAttrs;
use HiepVq\Upload\Sanitizer\SvgAllowedTags;

class SanitizerProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->container->singleton(Sanitizer::class, function (): Sanitizer {
            $sanitizer = new Sanitizer();
            $sanitizer->setAllowedAttrs(new SvgAllowedAttrs());
            $sanitizer->setAllowedTags(new SvgAllowedTags());
            $sanitizer->removeRemoteReferences(true);

            return $sanitizer;
        });

        $this->container->singleton('hiepvq.upload.sanitizer.svg_allowed_attrs', function (): array {
            return [];
        });

        $this->container->singleton('hiepvq.upload.sanitizer.svg_disallowed_attrs', function (): array {
            return [];
        });

        $this->container->singleton('hiepvq.upload.sanitizer.svg_allowed_tags', function (): array {
            return [];
        });

        $this->container->singleton('hiepvq.upload.sanitizer.svg_disallowed_tags', function (): array {
            return [];
        });
    }
}
