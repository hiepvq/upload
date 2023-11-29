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

namespace Hiepvq\Upload\Events\File;

use Hiepvq\Upload\Download;
use Hiepvq\Upload\File;

class WillBeDownloaded
{
    public function __construct(
        public File $file,
        public &$response,
        public ?Download $download = null
    ) {
    }
}
