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

use Hiepvq\Upload\File;

class MarkdownImageTemplate extends AbstractTemplate
{
    /**
     * @var string
     */
    protected $tag = 'markdown-image';

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return $this->trans('hiepvq-upload.admin.templates.markdown-image');
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return $this->trans('hiepvq-upload.admin.templates.markdown-image_description');
    }

    /**
     * {@inheritdoc}
     */
    public function preview(File $file): string
    {
        return '![Image description]('.$file->url.')';
    }
}
