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
 * @property string|null $etag Etag of this resource.
 * @property string|null $eventId Serialized EventId of the request which produced this response.
 * @property \Discord\Helpers\Collection<\YouTube\Parts\I18nLanguage>|null $items A list of supported i18n
 *     languages. In this map, the i18n language ID is the map key, and its value is the corresponding i18nLanguage
 *     resource.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#i18nLanguageListResponse".
 * @property string|null $visitorId The visitorId identifies the visitor.
 *
 * @link https://developers.google.com/youtube/v3/docs/i18nLanguages/list
 *
 * @since 1.0.0
 */
class I18nLanguageListResponse extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'items' => 'Array of I18nLanguage',
    ];
}
