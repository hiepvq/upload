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

namespace Hiepvq\Upload;

use Blomstra\Gdpr\Extend\UserData;
use Flarum\Api\Controller\ListDiscussionsController;
use Flarum\Api\Controller\ListPostsController;
use Flarum\Api\Controller\ShowForumController;
use Flarum\Api\Controller\ShowUserController;
use Flarum\Api\Serializer\CurrentUserSerializer;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Api\Serializer\UserSerializer;
use Flarum\Extend;
use Flarum\Post\Event\Posted;
use Flarum\Post\Event\Revised;
use Flarum\Settings\Event\Deserializing;
use Flarum\User\User;
use Hiepvq\Upload\Events\File\WillBeUploaded;
use Hiepvq\Upload\Exceptions\ExceptionHandler;
use Hiepvq\Upload\Exceptions\InvalidUploadException;
use Hiepvq\Upload\Extend\SvgSanitizer;
use Hiepvq\Upload\Extenders\LoadFilesRelationship;
use Hiepvq\Upload\Helpers\Util;

return [
    (new Extend\Frontend('admin'))
        ->css(__DIR__.'/resources/less/admin.less')
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Frontend('forum'))
        ->css(__DIR__.'/resources/less/forum.less')
        ->js(__DIR__.'/js/dist/forum.js'),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\View())
        ->namespace('hiepvq-upload.templates', __DIR__.'/resources/templates'),

    (new Extend\Routes('api'))
        ->get('/hiepvq/uploads', 'hiepvq-upload.list', Api\Controllers\ListUploadsController::class)
        ->post('/hiepvq/upload', 'hiepvq-upload.upload', Api\Controllers\UploadController::class)
        ->post('/hiepvq/watermark', 'hiepvq-upload.watermark', Api\Controllers\WatermarkUploadController::class)
        ->delete('/hiepvq/watermark', 'hiepvq-upload.watermark.delete', Api\Controllers\WatermarkDeleteController::class)
        ->get('/hiepvq/download/{uuid}/{post}/{csrf}', 'hiepvq-upload.download', Api\Controllers\DownloadController::class)
        ->get('/hiepvq/download/{uuid}', 'hiepvq-upload.download.uuid', Api\Controllers\DownloadController::class)
        ->post('/hiepvq/upload/inspect-mime', 'hiepvq-upload.inspect-mime', Api\Controllers\InspectMimeController::class)
        ->patch('/hiepvq/upload/hide', 'hiepvq-upload.hide', Api\Controllers\HideUploadFromMediaManagerController::class)
        ->get('/hiepvq/upload/shared-files', 'hiepvq-upload.shared-files.index', Api\Controllers\ListSharedUploadsController::class)
        ->delete('/hiepvq/upload/delete/{uuid}', 'hiepvq-upload.delete', Api\Controllers\DeleteFileController::class),

    // Disabled pending https://github.com/FriendsOfFlarum/upload/issues/374
    // (new Extend\Console())
    //     ->command(Console\MapFilesCommand::class),

    (new Extend\Csrf())
        ->exemptRoute('hiepvq-upload.download'),

    (new Extend\Model(User::class))
        ->cast('hiepvqfiles_current_count', 'int')
        ->cast('hiepvqfiles_count', 'int')
        ->hasMany('hiepvqfiles', File::class, 'actor_id')
        ->relationship('hiepvqfilesCurrent', function (User $model) {
            return $model->hiepvqfiles()->where('hidden', false);
        }),

    (new Extend\ApiController(ShowUserController::class))
        ->prepareDataForSerialization([LoadFilesRelationship::class, 'countRelations']),
    (new Extend\ApiController(ShowForumController::class))
        ->prepareDataForSerialization([LoadFilesRelationship::class, 'countRelations']),
    (new Extend\ApiController(ListDiscussionsController::class))
        ->prepareDataForSerialization([LoadFilesRelationship::class, 'countRelations']),
    (new Extend\ApiController(ListPostsController::class))
        ->prepareDataForSerialization([LoadFilesRelationship::class, 'countRelations']),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attributes(Extenders\AddForumAttributes::class),

    (new Extend\Event())
        ->listen(Deserializing::class, Listeners\AddAvailableOptionsInAdmin::class)
        ->listen(Posted::class, Listeners\LinkImageToPostOnSave::class)
        ->listen(Revised::class, Listeners\LinkImageToPostOnSave::class)
        ->listen(WillBeUploaded::class, Listeners\AddImageProcessor::class),

    (new Extend\Filesystem())
        ->disk('private-shared', Extenders\PrivateSharedDiskConfig::class),

    (new Extend\ServiceProvider())
        ->register(Providers\UtilProvider::class)
        ->register(Providers\StorageServiceProvider::class)
        ->register(Providers\DownloadProvider::class)
        ->register(Providers\SanitizerProvider::class),

    (new Extend\ApiSerializer(CurrentUserSerializer::class))
        ->attributes(Extenders\AddCurrentUserAttributes::class),

    (new Extend\ApiSerializer(UserSerializer::class))
        ->attributes(Extenders\AddUserAttributes::class),

    (new Extend\Formatter())
        ->render(Formatter\TextPreview\FormatTextPreview::class),

    (new SvgSanitizer())
        ->allowTag('animate'),

    (new Extend\ErrorHandling())
        ->handler(InvalidUploadException::class, ExceptionHandler::class),

    (new Extend\Settings())
        ->default('hiepvq-upload.maxFileSize', Util::DEFAULT_MAX_FILE_SIZE),

    new Extenders\AddPostDownloadTags(),
    new Extenders\CreateStorageFolder('tmp'),

    (new Extend\Policy())
        ->modelPolicy(File::class, Access\FilePolicy::class),

    (new Extend\Conditional())
        ->whenExtensionEnabled('blomstra-gdpr', fn () => [
            (new UserData())
                ->addType(Data\Uploads::class),
        ]),
];
