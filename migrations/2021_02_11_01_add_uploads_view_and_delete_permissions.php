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

use Flarum\Database\Migration;
use Flarum\Group\Group;

return Migration::addPermissions([
    'hiepvq-upload.viewUserUploads'   => Group::MODERATOR_ID,
    'hiepvq-upload.deleteUserUploads' => Group::MODERATOR_ID,
]);
