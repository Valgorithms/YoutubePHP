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
 * A *i18nRegion* resource identifies a region where YouTube is available.
 *
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube uses to uniquely identify the i18n region.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#i18nRegion".
 * @property \YouTube\Parts\I18nRegionSnippet|null $snippet The snippet object contains basic details about the
 *     i18n region, such as region code and human-readable name.
 *
 * @link https://developers.google.com/youtube/v3/docs/i18nRegions
 *
 * @since 1.0.0
 */
class I18nRegion extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'snippet' => 'I18nRegionSnippet',
    ];
}
