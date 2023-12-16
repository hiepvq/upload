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

namespace Hiepvq\Upload\Commands;

use Flarum\User\User;
use Hiepvq\Upload\File;

class DeleteFile
{
    public function __construct(
        public File $file,
        public User $actor
    ) {
    }
}
