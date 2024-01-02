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

namespace Hiepvq\Upload\Tests\integration\api;

use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;

class UserAttributes extends TestCase
{
    use RetrievesAuthorizedUsers;

    public function setUp(): void
    {
        parent::setUp();

        $this->extension('hiepvq-upload');

        $this->prepareDatabase([
            'users' => [
                $this->normalUser(),
            ],
            'hiepvq_upload_files' => [
                ['id' => 1, 'base_name' => 'test_file.abc', 'path' => 'path/test_file.abc', 'url' => 'http://localhost/test_file.abc', 'type' => 'test/file', 'size' => 123, 'upload_method' => 'local', 'actor_id' => 2, 'shared' => false],
            ],
        ]);
    }

    /**
     * @test
     */
    public function upload_counts_are_included_when_logged_in()
    {
        $response = $this->send(
            $this->request(
                'GET',
                '/api/users/2',
                [
                    'authenticatedAs' => 2,
                ]
            )
        );

        $this->assertEquals(200, $response->getStatusCode());

        $json = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(1, $json['data']['attributes']['hiepvq-upload-uploadCountCurrent']);
        $this->assertEquals(1, $json['data']['attributes']['hiepvq-upload-uploadCountAll']);
    }

    /**
     * @test
     */
    public function upload_counts_are_included_when_logged_out()
    {
        $response = $this->send(
            $this->request(
                'GET',
                '/api/users/2'
            )
        );

        $this->assertEquals(200, $response->getStatusCode());

        $json = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(1, $json['data']['attributes']['hiepvq-upload-uploadCountCurrent']);
        $this->assertEquals(1, $json['data']['attributes']['hiepvq-upload-uploadCountAll']);
    }

    /**
     * @test
     */
    public function user_with_permissions_have_extra_attributes()
    {
        $response = $this->send(
            $this->request(
                'GET',
                '/api/users/1',
                [
                    'authenticatedAs' => 1,
                ]
            )
        );

        $this->assertEquals(200, $response->getStatusCode());

        $json = json_decode($response->getBody()->getContents(), true);

        $this->assertArrayHasKey('hiepvq-upload-viewOthersMediaLibrary', $json['data']['attributes']);
        $this->assertArrayHasKey('hiepvq-upload-deleteOthersMediaLibrary', $json['data']['attributes']);
    }

    /**
     * @test
     */
    public function user_without_permissions_dont_have_extra_attributes()
    {
        $response = $this->send(
            $this->request(
                'GET',
                '/api/users/2',
                [
                    'authenticatedAs' => 2,
                ]
            )
        );

        $this->assertEquals(200, $response->getStatusCode());

        $json = json_decode($response->getBody()->getContents(), true);

        $this->assertArrayNotHasKey('hiepvq-upload-viewOthersMediaLibrary', $json['data']['attributes']);
        $this->assertArrayNotHasKey('hiepvq-upload-deleteOthersMediaLibrary', $json['data']['attributes']);
    }

    /**
     * @test
     */
    public function current_user_does_not_have_upload_shared_file_permission_attribute_when_no_permission()
    {
        $response = $this->send(
            $this->request(
                'GET',
                '/api/users/2',
                [
                    'authenticatedAs' => 2,
                ]
            )
        );

        $this->assertEquals(200, $response->getStatusCode());

        $json = json_decode($response->getBody()->getContents(), true);

        $this->assertArrayNotHasKey('hiepvq-upload-uploadSharedFiles', $json['data']['attributes']);
    }

    /**
     * @test
     */
    public function current_user_has_upload_shared_file_permission_attribute_when_has_permission()
    {
        $response = $this->send(
            $this->request(
                'GET',
                '/api/users/1',
                [
                    'authenticatedAs' => 1,
                ]
            )
        );

        $this->assertEquals(200, $response->getStatusCode());

        $json = json_decode($response->getBody()->getContents(), true);

        $this->assertTrue($json['data']['attributes']['hiepvq-upload-uploadSharedFiles']);
    }
}
