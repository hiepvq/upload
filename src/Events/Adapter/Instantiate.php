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

namespace HiepVq\Upload\Events\Adapter;

use HiepVq\Upload\Helpers\Util;

class Instantiate
{
    public function __construct(
        public string $adapter,
        public Util $util
    ) {
    }
}
