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

use Flarum\Api\Serializer\UserSerializer;
use Flarum\User\User;

class AddUserAttributes
{
    public function __invoke(UserSerializer $serializer, User $user, array $attributes): array
    {
        $attributes['hiepvq-upload-uploadCountCurrent'] = $user->hiepvqfiles_current_count;
        $attributes['hiepvq-upload-uploadCountAll'] = $user->hiepvqfiles_count;

        return $attributes;
    }
}
