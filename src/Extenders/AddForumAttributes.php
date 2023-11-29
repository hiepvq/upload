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

class AddForumAttributes
{
    private $settings;

    /**
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param ForumSerializer $serializer
     */
    public function __invoke(ForumSerializer $serializer)
    {
        $attributes['hiepvq-upload.canUpload'] = $serializer->getActor()->can('hiepvq-upload.upload');
        $attributes['hiepvq-upload.canDownload'] = $serializer->getActor()->can('hiepvq-upload.download');
        $attributes['hiepvq-upload.composerButtonVisiblity'] = $this->settings->get('hiepvq-upload.composerButtonVisiblity', 'both');

        $serializer->getActor()->load('hiepvqfiles');
        $serializer->getActor()->load('hiepvqfilesCurrent');

        return $attributes;
    }
}
