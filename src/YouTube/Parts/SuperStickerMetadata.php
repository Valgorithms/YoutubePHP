<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Parts;

/**
 * This file is generated from spec/discovery.json (YouTube Data API v3, revision 20260924) by
 * tools/generate.php. Do not edit it by hand - run `composer spec:build` instead.
 *
 * @property string|null $altText Internationalized alt text that describes the sticker image and any animation
 *     associated with it.
 * @property string|null $altTextLanguage Specifies the localization language in which the alt text is returned.
 * @property string|null $stickerId Unique identifier of the Super Sticker. This is a shorter form of the
 *     alt_text that includes pack name and a recognizable characteristic of the sticker.
 *
 * @since 1.0.0
 */
class SuperStickerMetadata extends Part
{
}
