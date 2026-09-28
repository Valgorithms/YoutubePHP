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
 * Branding properties for images associated with the channel.
 *
 * @property \YouTube\Parts\LocalizedProperty|null $backgroundImageUrl Deprecated. The URL for the background
 *     image shown on the video watch page. The image should be 1200px by 615px, with a maximum file size of 128k.
 * @property string|null $bannerExternalUrl This is generated when a ChannelBanner.Insert request has succeeded
 *     for the given channel.
 * @property string|null $bannerImageUrl Deprecated. Banner image. Desktop size (1060x175).
 * @property string|null $bannerMobileExtraHdImageUrl Deprecated. Banner image. Mobile size high resolution
 *     (1440x395).
 * @property string|null $bannerMobileHdImageUrl Deprecated. Banner image. Mobile size high resolution
 *     (1280x360).
 * @property string|null $bannerMobileImageUrl Deprecated. Banner image. Mobile size (640x175).
 * @property string|null $bannerMobileLowImageUrl Deprecated. Banner image. Mobile size low resolution (320x88).
 * @property string|null $bannerMobileMediumHdImageUrl Deprecated. Banner image. Mobile size medium/high
 *     resolution (960x263).
 * @property string|null $bannerTabletExtraHdImageUrl Deprecated. Banner image. Tablet size extra high resolution
 *     (2560x424).
 * @property string|null $bannerTabletHdImageUrl Deprecated. Banner image. Tablet size high resolution
 *     (2276x377).
 * @property string|null $bannerTabletImageUrl Deprecated. Banner image. Tablet size (1707x283).
 * @property string|null $bannerTabletLowImageUrl Deprecated. Banner image. Tablet size low resolution
 *     (1138x188).
 * @property string|null $bannerTvHighImageUrl Deprecated. Banner image. TV size high resolution (1920x1080).
 * @property string|null $bannerTvImageUrl Deprecated. Banner image. TV size extra high resolution (2120x1192).
 * @property string|null $bannerTvLowImageUrl Deprecated. Banner image. TV size low resolution (854x480).
 * @property string|null $bannerTvMediumImageUrl Deprecated. Banner image. TV size medium resolution (1280x720).
 * @property \YouTube\Parts\LocalizedProperty|null $largeBrandedBannerImageImapScript Deprecated. The image map
 *     script for the large banner image.
 * @property \YouTube\Parts\LocalizedProperty|null $largeBrandedBannerImageUrl Deprecated. The URL for the 854px
 *     by 70px image that appears below the video player in the expanded video view of the video watch page.
 * @property \YouTube\Parts\LocalizedProperty|null $smallBrandedBannerImageImapScript Deprecated. The image map
 *     script for the small banner image.
 * @property \YouTube\Parts\LocalizedProperty|null $smallBrandedBannerImageUrl Deprecated. The URL for the 640px
 *     by 70px banner image that appears below the video player in the default view of the video watch page. The URL
 *     for the image that appears above the top-left corner of the video player. This is a 25-pixel-high image with a
 *     flexible width that cannot exceed 170 pixels.
 * @property string|null $trackingImageUrl Deprecated. The URL for a 1px by 1px tracking pixel that can be used
 *     to collect statistics for views of the channel or video pages.
 * @property string|null $watchIconImageUrl Deprecated.
 *
 * @since 1.0.0
 */
class ImageSettings extends Part
{
    /** @var array<string, string> */
    protected array $casts = [
        'backgroundImageUrl' => 'LocalizedProperty',
        'largeBrandedBannerImageImapScript' => 'LocalizedProperty',
        'largeBrandedBannerImageUrl' => 'LocalizedProperty',
        'smallBrandedBannerImageImapScript' => 'LocalizedProperty',
        'smallBrandedBannerImageUrl' => 'LocalizedProperty',
    ];
}
