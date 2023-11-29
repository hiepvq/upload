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

namespace Hiepvq\Upload\Events\Adapter;

use Hiepvq\Upload\Helpers\Util;

class Instantiate
{
    /** @var string */
    public $adapter;
    /** @var Util */
    public $util;

    public function __construct(string $adapter, Util $util)
    {
        $this->adapter = $adapter;
        $this->util = $util;
    }
}
