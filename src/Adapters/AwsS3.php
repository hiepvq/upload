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

namespace HiepVq\Upload\Adapters;

use Flarum\Settings\SettingsRepositoryInterface;
use HiepVq\Upload\Contracts\UploadAdapter;
use HiepVq\Upload\File;
use Illuminate\Support\Arr;
use League\Flysystem\AdapterInterface;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Config;

class AwsS3 extends Flysystem implements UploadAdapter
{
    protected AdapterInterface $adapter;

    protected function getConfig(): Config
    {
        /** @var SettingsRepositoryInterface $settings */
        $settings = resolve(SettingsRepositoryInterface::class);

        $config = new Config();
        if ($acl = $settings->get('hiepvq-upload.awsS3ACL')) {
            $config->set('ACL', $acl);
        }

        return $config;
    }

    protected function generateUrl(File $file): void
    {
        /** @var SettingsRepositoryInterface $settings */
        $settings = resolve(SettingsRepositoryInterface::class);

        $cdnUrl = (string) $settings->get('hiepvq-upload.cdnUrl');

        if (!$cdnUrl) {
            // Ensure that $this->adapter is an instance of AwsS3Adapter
            if ($this->adapter instanceof AwsS3Adapter) {
                $region = $this->adapter->getClient()->getRegion();
                $bucket = $this->adapter->getBucket();

                $cdnUrl = sprintf('https://%s.s3.%s.amazonaws.com', $bucket, $region ?: 'us-east-1');
            } else {
                throw new \RuntimeException('Expected adapter to be an instance of AwsS3Adapter, got '.$this->adapter::class);
            }
        }

        $file->url = sprintf('%s/%s', $cdnUrl, Arr::get($this->meta, 'path', $file->path));
    }
}
