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

namespace HiepVq\Upload\Sanitizer;

use enshrined\svgSanitize\data\AllowedAttributes;

class SvgAllowedAttrs extends AllowedAttributes
{
    public static function getAttributes(): array
    {
        return array_diff(
            array_merge(parent::getAttributes(), resolve('hiepvq.upload.sanitizer.svg_allowed_attrs')),
            resolve('hiepvq.upload.sanitizer.svg_disallowed_attrs')
        );
    }
}
