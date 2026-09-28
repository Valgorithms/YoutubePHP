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
 * An *i18nLanguage* resource identifies a UI language currently supported by YouTube.
 *
 * @property string|null $etag Etag of this resource.
 * @property string|null $id The ID that YouTube uses to uniquely identify the i18n language.
 * @property string|null $kind Identifies what kind of resource this is. Value: the fixed string
 *     "youtube#i18nLanguage".
 * @property \YouTube\Parts\I18nLanguageSnippet|null $snippet The snippet object contains basic details about the
 *     i18n language, such as language code and human-readable name.
 *
 * @link https://developers.google.com/youtube/v3/docs/i18nLanguages
 *
 * @since 1.0.0
 */
class I18nLanguage extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'snippet' => 'I18nLanguageSnippet',
    ];
}
