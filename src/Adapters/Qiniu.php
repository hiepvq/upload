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

namespace Hiepvq\Upload\Adapters;

use Flarum\Foundation\ValidationException;
use Flarum\Settings\SettingsRepositoryInterface;
use Hiepvq\Upload\Contracts\UploadAdapter;
use Hiepvq\Upload\File;

class Qiniu extends Flysystem implements UploadAdapter
{
    protected function generateUrl(File $file): void
    {
        /** @var SettingsRepositoryInterface $settings */
        $settings = resolve(SettingsRepositoryInterface::class);

        $path = $file->getAttribute('path');
        if ($cdnUrl = $settings->get('hiepvq-upload.cdnUrl')) {
            $file->url = sprintf('%s/%s', $cdnUrl, $path);
        } else {
            throw new ValidationException(['upload' => 'QiNiu cloud CDN address is not configured.']);
        }
    }
}
