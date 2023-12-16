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

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        if (!$schema->hasColumn('hiepvq_upload_files', 'hide_from_media_manager')) {
            $schema->table('hiepvq_upload_files', function (Blueprint $table) {
                $table->boolean('hide_from_media_manager')->default(false);
            });
        }
    },
    'down' => function (Builder $schema) {
        $schema->table('hiepvq_upload_files', function (Blueprint $table) {
            $table->dropColumn('hide_from_media_manager');
        });
    },
];
