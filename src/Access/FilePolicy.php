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

namespace Hiepvq\Upload\Access;

use Flarum\User\Access\AbstractPolicy;
use Flarum\User\User;
use Hiepvq\Upload\File;

class FilePolicy extends AbstractPolicy
{
    public function viewInfo(User $actor, File $file)
    {
        // for now..
        return $this->deny();
    }

    public function hide(User $actor, File $file)
    {
        if (($file->actor?->id === $actor->id || $actor->hasPermission('hiepvq-upload.deleteUserUploads')) && $file->actor !== null) {
            return $this->allow();
        }
    }

    public function delete(User $actor, File $file)
    {
        if ($actor->can('hiepvq-upload.deleteUserUploads') && $file->actor !== null) {
            return $this->allow();
        }
    }
}
