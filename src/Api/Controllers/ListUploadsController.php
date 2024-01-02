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

namespace Hiepvq\Upload\Api\Controllers;

use Flarum\Api\Controller\AbstractListController;
use Flarum\Http\RequestUtil;
use Flarum\Http\UrlGenerator;
use Hiepvq\Upload\Api\Serializers\FileSerializer;
use Hiepvq\Upload\File;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListUploadsController extends AbstractListController
{
    public $serializer = FileSerializer::class;

    public $sortFields = ['id'];

    public function __construct(
        protected UrlGenerator $url
    ) {
    }

    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = RequestUtil::getActor($request);
        $params = $request->getQueryParams();

        // User is signed in
        $actor->assertRegistered();

        $filterByUserId = Arr::get($params, 'filter.user', $actor->id);

        // Can this user load other their files?
        if (intval($filterByUserId) !== $actor->id) {
            $actor->assertCan('hiepvq-upload.viewUserUploads');
        }

        // Params
        $limit = $this->extractLimit($request);
        $offset = $this->extractOffset($request);

        $query = File::filesFor($filterByUserId, $actor);

        $results = $query
            ->skip($offset)
            ->take($limit + 1)
            ->orderBy('id', 'desc')
            ->get();

        // Check for more results
        $hasMoreResults = $limit > 0 && $results->count() > $limit;

        // Pop
        if ($hasMoreResults) {
            $results->pop();
        }

        // Add pagination to the request
        $document->addPaginationLinks(
            $this->url->to('api')->route('hiepvq-upload.list'),
            $params,
            $offset,
            $limit,
            $hasMoreResults ? null : 0
        );

        return $results;
    }
}
