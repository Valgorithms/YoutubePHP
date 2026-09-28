<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Api;

use React\Promise\PromiseInterface;

/**
 * This file is generated from spec/discovery.json (YouTube Data API v3, revision 20260924) by
 * tools/generate.php. Do not edit it by hand - run `composer spec:build` instead.
 *
 * Whether a video may be used to train AI models.
 *
 * Reach it as `$youtube->videoTrainability`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @since 1.0.0
 */
final class VideoTrainabilityApi extends AbstractApi
{
    /**
     * Returns the trainability status of a video.
     *
     * Costs 1 unit of quota, by estimate: Google does not publish it, so it is counted as a read.
     *
     * @param string|null $id The ID of the video to retrieve.
     *
     * @return PromiseInterface<\YouTube\Parts\VideoTrainability>
     *
     * @since 1.0.0
     */
    public function get(
        ?string $id = null,
    ): PromiseInterface {
        return $this->call(
            'videoTrainability.get',
            'GET',
            'youtube/v3/videoTrainability',
            query: [
                'id' => $id,
            ],
            returns: 'VideoTrainability',
        );
    }
}
