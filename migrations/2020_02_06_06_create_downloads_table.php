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
        if ($schema->hasTable('hiepvq_upload_downloads')) {
            return;
        }

        $schema->create('hiepvq_upload_downloads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('file_id');
            $table->unsignedInteger('discussion_id')->nullable();
            $table->unsignedInteger('post_id')->nullable();
            $table->unsignedInteger('actor_id')->nullable();
            $table->timestamp('downloaded_at');

            $table->foreign('file_id')
                ->references('id')
                ->on('hiepvq_upload_files')
                ->onDelete('cascade');

            $table->foreign('discussion_id')
                ->references('id')
                ->on('discussions')
                ->onDelete('set null');

            $table->foreign('actor_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    },
    'down' => function (Builder $schema) {
        $schema->dropIfExists('hiepvq_upload_downloads');
    },
];
