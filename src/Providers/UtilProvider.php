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

namespace Hiepvq\Upload\Providers;

use Flarum\Foundation\AbstractServiceProvider;
use Hiepvq\Upload\Helpers\Util;

class UtilProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->container->singleton(Util::class);
    }
}
