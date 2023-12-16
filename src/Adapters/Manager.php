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

use Aws\S3\S3Client;
use Flarum\Foundation\Paths;
use Flarum\Foundation\ValidationException;
use Flarum\Settings\SettingsRepositoryInterface;
use Hiepvq\Upload\Adapters;
use Hiepvq\Upload\Contracts\UploadAdapter;
use Hiepvq\Upload\Events\Adapter\Collecting;
use Hiepvq\Upload\Events\Adapter\Instantiate;
use Hiepvq\Upload\Helpers\Util;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use League\Flysystem\Adapter as FlyAdapters;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Overtrue\Flysystem\Qiniu\QiniuAdapter;
use Qiniu\Http\Client as QiniuClient;

class Manager
{
    public function __construct(
        protected Dispatcher $events,
        protected Paths $paths,
        protected Util $util,
        protected SettingsRepositoryInterface $settings
    ) {
    }

    public function adapters(): Collection
    {
        $adapters = Collection::make([
            'aws-s3' => class_exists(S3Client::class),
            'imgur'  => true,
            'qiniu'  => class_exists(QiniuClient::class),
            'local'  => true,
        ]);

        $this->events->dispatch(new Collecting($adapters));

        return $adapters;
    }

    public function instantiate(string $adapter): UploadAdapter
    {
        $configured = $this->adapters()
            // Drops adapters that cannot be instantiated due to missing packages.
            ->filter(function ($available) {
                return $available;
            })
            ->get($adapter);

        if (!$configured) {
            throw new ValidationException(['upload' => "No adapter configured for $adapter"]);
        }

        $method = Str::camel($adapter);

        $driver = $this->events->until(new Instantiate($adapter, $this->util));

        if (!$driver && !method_exists($this, $method)) {
            throw new ValidationException(['upload' => "Cannot instantiate adapter $adapter"]);
        }

        return $driver ?? $this->{$method}($this->util);
    }

    /**
     * @param Util $util
     *
     * @return Adapters\AwsS3
     */
    protected function awsS3(Util $util)
    {
        $s3Config = [
            'region'                  => empty($this->settings->get('hiepvq-upload.awsS3Region')) ? null : $this->settings->get('hiepvq-upload.awsS3Region'),
            'version'                 => 'latest',
            'endpoint'                => empty($this->settings->get('hiepvq-upload.awsS3Endpoint')) ? null : $this->settings->get('hiepvq-upload.awsS3Endpoint'),
            'use_path_style_endpoint' => empty($this->settings->get('hiepvq-upload.awsS3UsePathStyleEndpoint')) ? null : (bool) $this->settings->get('hiepvq-upload.awsS3UsePathStyleEndpoint'),
        ];

        // Only explicitly provide credentials if available.
        // Otherwise S3Client will attempt to use instance profile.
        if ($this->settings->get('hiepvq-upload.awsS3Key') && $this->settings->get('hiepvq-upload.awsS3Secret')) {
            $s3Config['credentials'] = [
                'key'    => $this->settings->get('hiepvq-upload.awsS3Key'),
                'secret' => $this->settings->get('hiepvq-upload.awsS3Secret'),
            ];
        }

        return new Adapters\AwsS3(
            new AwsS3Adapter(
                new S3Client($s3Config),
                $this->settings->get('hiepvq-upload.awsS3Bucket')
            ),
        );
    }

    /**
     * @param Util $util
     *
     * @return Adapters\Imgur|null
     */
    protected function imgur(Util $util)
    {
        if (!$this->settings->get('hiepvq-upload.imgurClientId')) {
            return null;
        }

        return new Adapters\Imgur(
            new Guzzle([
                'base_uri' => 'https://api.imgur.com/3/',
                'headers'  => [
                    'Authorization' => 'Client-ID '.$this->settings->get('hiepvq-upload.imgurClientId'),
                ],
            ])
        );
    }

    /**
     * @param Util $util
     *
     * @return Adapters\Local
     */
    protected function local(Util $util)
    {
        return new Adapters\Local(
            new FlyAdapters\Local($this->paths->public.'/assets/files'),
        );
    }

    /**
     * @param Util $util
     *
     * @return Adapters\Qiniu|null
     */
    protected function qiniu(Util $util)
    {
        if (!$this->settings->get('hiepvq-upload.qiniuKey')) {
            return null;
        }

        $client = new QiniuAdapter(
            $this->settings->get('hiepvq-upload.qiniuKey'),
            $this->settings->get('hiepvq-upload.qiniuSecret'),
            $this->settings->get('hiepvq-upload.qiniuBucket'),
            $this->settings->get('hiepvq-upload.cdnUrl')
        );

        return new Adapters\Qiniu($client);
    }
}
