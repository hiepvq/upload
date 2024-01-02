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

namespace Hiepvq\Upload\Templates;

use Illuminate\Contracts\View\View;

class ImageTemplate extends AbstractTextFormatterTemplate
{
    /**
     * @var string
     */
    protected $tag = 'image';

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return $this->trans('hiepvq-upload.admin.templates.image');
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return $this->trans('hiepvq-upload.admin.templates.image_description');
    }

    public function template(): View
    {
        return $this->getView('hiepvq-upload.templates::image');
    }

    /**
     * {@inheritdoc}
     */
    public function bbcode(): string
    {
        return '[upl-image uuid={IDENTIFIER} size={SIMPLETEXT2} url={URL}]{SIMPLETEXT1}[/upl-image]';
    }
}
