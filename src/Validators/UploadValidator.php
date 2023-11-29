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

namespace Hiepvq\Upload\Validators;

use Flarum\Foundation\AbstractValidator;
use Flarum\Settings\SettingsRepositoryInterface;
use Hiepvq\Upload\Helpers\Util;
use Symfony\Contracts\Translation\TranslatorInterface;

class UploadValidator extends AbstractValidator
{
    protected function getRules(): array
    {
        return [
            'file' => [
                'required',
                'max:'.$this->maxFilesize(),
            ],
        ];
    }

    protected function getMessages()
    {
        /** @var TranslatorInterface $translator */
        $translator = resolve('translator');

        return [
            'max' => $translator->trans('hiepvq-upload.forum.validation.max_size', [
                'max' => $this->maxFilesize(),
            ]),
        ];
    }

    protected function maxFilesize(): int
    {
        /** @var SettingsRepositoryInterface $settings */
        $settings = resolve(SettingsRepositoryInterface::class);

        return $settings->get('hiepvq-upload.maxFileSize', Util::DEFAULT_MAX_FILE_SIZE);
    }
}
