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
 * Pings that the app shall fire (authenticated by biscotti cookie). Each ping has a context, in which
 * the app must fire the ping, and a url identifying the ping.
 *
 * @property string|null $context Defines the context of the ping. One of the `CONTEXT_*` constants.
 * @property string|null $conversionUrl The url (without the schema) that the player shall send the ping to. It's
 *     at caller's descretion to decide which schema to use (http vs https) Example of a returned url:
 *     //googleads.g.doubleclick.net/pagead/ viewthroughconversion/962985656/?data=path%3DtHe_path%3Btype%3D
 *     cview%3Butuid%3DGISQtTNGYqaYl4sKxoVvKA&labe=default The caller must append biscotti authentication (ms param
 *     in case of mobile, for example) to this ping.
 *
 * @since 1.0.0
 */
class ChannelConversionPing extends Part
{
    /** A `context` of `subscribe`. */
    public const CONTEXT_SUBSCRIBE = 'subscribe';

    /** A `context` of `unsubscribe`. */
    public const CONTEXT_UNSUBSCRIBE = 'unsubscribe';

    /** A `context` of `cview`. */
    public const CONTEXT_CVIEW = 'cview';
}
