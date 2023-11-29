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

namespace Hiepvq\Upload\Templates;

use Hiepvq\Upload\Contracts\TextFormatterTemplate;
use Hiepvq\Upload\File;

abstract class AbstractTextFormatterTemplate extends AbstractTemplate implements TextFormatterTemplate
{
    public function preview(File $file): string
    {
        $bbcode = $this->bbcode();

        return preg_replace_callback_array([
            '/\](?<find>.*)\[/' => function ($m) use ($file) {
                return str_replace($m['find'], $file->base_name, $m[0]);
            },
            '/size=(?<find>{.*?})/' => function ($m) use ($file) {
                return str_replace($m['find'], $file->humanSize, $m[0]);
            },
            '/uuid=(?<find>{.*?})/' => function ($m) use ($file) {
                return str_replace($m['find'], $file->uuid, $m[0]);
            },
            '/path=(?<find>{.*?})/' => function ($m) use ($file) {
                return str_replace($m['find'], $file->path, $m[0]);
            },
            '/url=(?<find>{.*?})/' => function ($m) use ($file) {
                return str_replace($m['find'], $file->url, $m[0]);
            },
        ], $bbcode);
    }
}
