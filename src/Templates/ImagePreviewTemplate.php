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

namespace HiepVq\Upload\Templates;

use Illuminate\Contracts\View\View;

class ImagePreviewTemplate extends AbstractTextFormatterTemplate
{
    /**
     * @var string
     */
    protected $tag = 'image-preview';

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return $this->trans('hiepvq-upload.admin.templates.image-preview');
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return $this->trans('hiepvq-upload.admin.templates.image-preview_description');
    }

    public function template(): View
    {
        return $this->getView('hiepvq-upload.templates::image-preview');
    }

    /**
     * {@inheritdoc}
     */
    public function bbcode(): string
    {
        return '[upl-image-preview url={URL}]';
    }
}
