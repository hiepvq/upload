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

use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        // Re-use the tables from the Flagrow version if they exist
        if ($schema->hasTable('flagrow_files') && !$schema->hasTable('hiepvq_upload_files')) {
            $schema->rename('flagrow_files', 'hiepvq_upload_files');
        }

        if ($schema->hasTable('flagrow_file_downloads') && !$schema->hasTable('hiepvq_upload_downloads')) {
            $schema->rename('flagrow_file_downloads', 'hiepvq_upload_downloads');
        }
    },
    'down' => function (Builder $schema) {
        // Not doing anything but `down` has to be defined
    },
];
