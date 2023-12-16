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

use Flarum\Api\Serializer\CurrentUserSerializer;
use Flarum\User\User;

class AddCurrentUserAttributes
{
    public function __invoke(CurrentUserSerializer $serializer, User $user, array $attributes): array
    {
        $actor = $serializer->getActor();

        if ($viewOthers = $actor->hasPermission('hiepvq-upload.viewUserUploads')) {
            $attributes['hiepvq-upload-viewOthersMediaLibrary'] = $viewOthers;
        }

        if ($deleteOthers = $actor->hasPermission('hiepvq-upload.deleteUserUploads')) {
            $attributes['hiepvq-upload-deleteOthersMediaLibrary'] = $deleteOthers;
        }

        if ($uploadShared = $actor->hasPermission('hiepvq-upload.upload-shared-files')) {
            $attributes['hiepvq-upload-uploadSharedFiles'] = $uploadShared;
        }

        if ($accessShared = $actor->hasPermission('hiepvq-upload.access-shared-files')) {
            $attributes['hiepvq-upload-accessSharedFiles'] = $accessShared;
        }

        return $attributes;
    }
}
