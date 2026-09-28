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
 * Details about a resource which is being promoted.
 *
 * @property string|null $adTag The URL the client should fetch to request a promoted item.
 * @property string|null $clickTrackingUrl The URL the client should ping to indicate that the user clicked
 *     through on this promoted item.
 * @property string|null $creativeViewUrl The URL the client should ping to indicate that the user was shown this
 *     promoted item.
 * @property string|null $ctaType The type of call-to-action, a message to the user indicating action that can be
 *     taken. One of the `CTA_TYPE_*` constants.
 * @property string|null $customCtaButtonText The custom call-to-action button text. If specified, it will
 *     override the default button text for the cta_type.
 * @property string|null $descriptionText The text description to accompany the promoted item.
 * @property string|null $destinationUrl The URL the client should direct the user to, if the user chooses to
 *     visit the advertiser's website.
 * @property list<string>|null $forecastingUrl The list of forecasting URLs. The client should ping all of these
 *     URLs when a promoted item is not available, to indicate that a promoted item could have been shown.
 * @property list<string>|null $impressionUrl The list of impression URLs. The client should ping all of these
 *     URLs to indicate that the user was shown this promoted item.
 * @property string|null $videoId The ID that YouTube uses to uniquely identify the promoted video.
 *
 * @since 1.0.0
 */
class ActivityContentDetailsPromotedItem extends Part
{
    /** A `ctaType` of `ctaTypeUnspecified`. */
    public const CTA_TYPE_CTA_TYPE_UNSPECIFIED = 'ctaTypeUnspecified';

    /** A `ctaType` of `visitAdvertiserSite`. */
    public const CTA_TYPE_VISIT_ADVERTISER_SITE = 'visitAdvertiserSite';
}
