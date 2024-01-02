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

function setAwsMimeTypeAdapterDelimiter(Builder $schema, string $old = '_', string $new = '-')
{
    $mimeConfiguration = $schema
        ->getConnection()
        ->table('settings')
        ->where('key', 'hiepvq-upload.mimeTypes')
        ->value('value');

    $mimeConfiguration = json_decode($mimeConfiguration ?? '[]', true);

    foreach ($mimeConfiguration as $mime => &$config) {
        if ($config['adapter'] === "aws{$old}s3") {
            $config['adapter'] = "aws{$new}s3";
        }
    }

    $schema
        ->getConnection()
        ->table('settings')
        ->where('key', 'hiepvq-upload.mimeTypes')
        ->update(['value' => json_encode($mimeConfiguration)]);
}

return [
    'up' => function (Builder $schema) {
        setAwsMimeTypeAdapterDelimiter($schema, '_', '-');
    },
    'down' => function (Builder $schema) {
        setAwsMimeTypeAdapterDelimiter($schema, '-', '_');
    },
];
