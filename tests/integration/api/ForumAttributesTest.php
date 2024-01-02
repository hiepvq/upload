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

namespace HiepVq\Upload\Tests\integration\api;

use Flarum\Testing\integration\TestCase;

class ForumAttributesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->extension('hiepvq-upload');
    }

    /**
     * @test
     */
    public function upload_attributes_are_added_to_forum()
    {
        $response = $this->send(
            $this->request(
                'GET',
                '/api'
            )
        );

        $this->assertEquals(200, $response->getStatusCode());

        $json = json_decode($response->getBody()->getContents(), true);

        $this->assertArrayHasKey('hiepvq-upload.canUpload', $json['data']['attributes']);
        $this->assertArrayHasKey('hiepvq-upload.canDownload', $json['data']['attributes']);
        $this->assertArrayHasKey('hiepvq-upload.composerButtonVisiblity', $json['data']['attributes']);
    }

    /**
     * @test
     */
    public function forum_frontend_is_alive()
    {
        $response = $this->send(
            $this->request(
                'GET',
                '/'
            )
        );

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertStringContainsString('<h1>All Discussions</h1>', $response->getBody()->getContents());
    }
}
