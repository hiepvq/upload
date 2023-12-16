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

namespace Hiepvq\Upload\Extenders;

use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Contracts\Filesystem\Factory;

class AddForumAttributes
{
    /**
     * @var Cloud
     */
    protected $assetsDir;

    public function __construct(
        protected SettingsRepositoryInterface $settings,
        Factory $factory
    ) {
        $this->assetsDir = $factory->disk('flarum-assets');
    }

    public function __invoke(ForumSerializer $serializer): array
    {
        $attributes['hiepvq-upload.canUpload'] = $serializer->getActor()->can('hiepvq-upload.upload');
        $attributes['hiepvq-upload.canDownload'] = $serializer->getActor()->can('hiepvq-upload.download');
        $attributes['hiepvq-upload.composerButtonVisiblity'] = $this->settings->get('hiepvq-upload.composerButtonVisiblity', 'both');

        if ($watermark = $this->settings->get('hiepvq-watermark_path')) {
            $attributes['hiepvq-watermarkUrl'] = $this->assetsDir->url($watermark);
        }

        $serializer->getActor()->load('hiepvqfiles');
        $serializer->getActor()->load('hiepvqfilesCurrent');

        return $attributes;
    }
}
