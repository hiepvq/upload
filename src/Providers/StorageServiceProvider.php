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
use Hiepvq\Upload\Adapters\Manager;

class StorageServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->container->singleton(Manager::class);
    }
}
