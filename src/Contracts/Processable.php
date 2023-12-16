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

namespace Hiepvq\Upload\Contracts;

use Hiepvq\Upload\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface Processable
{
    public function process(File $file, UploadedFile $upload, string $mime): void;
}
