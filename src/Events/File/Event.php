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

namespace HiepVq\Upload\Events\File;

use Flarum\User\User;
use HiepVq\Upload\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class Event
{
    public function __construct(
        public User $actor,
        public File $file,
        public UploadedFile $uploadedFile,
        public string $mime
    ) {
    }
}
