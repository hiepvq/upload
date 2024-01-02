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

namespace HiepVq\Upload\Api\Controllers;

use Flarum\Api\Controller\AbstractShowController;
use Flarum\Database\AbstractModel;
use Flarum\Foundation\ValidationException;
use Flarum\Http\RequestUtil;
use HiepVq\Upload\Api\Serializers\FileSerializer;
use HiepVq\Upload\Api\Serializers\SharedFileSerializer;
use HiepVq\Upload\File;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class HideUploadFromMediaManagerController extends AbstractShowController
{
    public $serializer = FileSerializer::class;

    public function data(ServerRequestInterface $request, Document $document): AbstractModel
    {
        $actor = RequestUtil::getActor($request);
        $actor->assertRegistered();

        $uuid = Arr::get($request->getParsedBody(), 'uuid');

        if (empty($uuid)) {
            throw new ValidationException(['uuid' => 'UUID cannot be empty.']);
        }

        $fileUpload = File::byUuid($uuid)->firstOrFail();

        $actor->assertCan('hide', $fileUpload);

        if ($fileUpload->shared) {
            $this->serializer = SharedFileSerializer::class;
        }

        // Toggle the hidden state
        $fileUpload->hidden = !$fileUpload->hidden;
        $fileUpload->save();

        return $fileUpload;
    }
}
