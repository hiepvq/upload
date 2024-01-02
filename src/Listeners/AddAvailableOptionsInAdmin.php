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

namespace HiepVq\Upload\Listeners;

use Flarum\Settings\Event\Deserializing;
use HiepVq\Upload\Helpers\Util;

class AddAvailableOptionsInAdmin
{
    public function __construct(
        protected Util $util
    ) {
    }

    public function handle(Deserializing $event): void
    {
        $event->settings['hiepvq-upload.availableUploadMethods'] = $this->util->getAvailableUploadMethods()->toArray();
        $event->settings['hiepvq-upload.availableTemplates'] = $this->util->getAvailableTemplates()->toArray();
        $event->settings['hiepvq-upload.php_ini.post_max_size'] = ini_get('post_max_size');
        $event->settings['hiepvq-upload.php_ini.upload_max_filesize'] = ini_get('upload_max_filesize');
    }
}
