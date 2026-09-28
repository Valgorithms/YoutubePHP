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
 * Banning people from a live chat, and lifting bans.
 *
 * Reach it as `$youtube->liveChatBans`. Every method takes the parameters Google
 * documents, by the same names: use named arguments for the optional ones.
 *
 * @link https://developers.google.com/youtube/v3/live/docs/liveChatBans
 *
 * @since 1.0.0
 */
final class LiveChatBansApi extends AbstractApi
{
    /**
     * Deletes a chat ban.
     *
     * Costs 50 units of quota.
     *
     * @param string $id
     *
     * @return PromiseInterface<null>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveChatBans/delete
     *
     * @since 1.0.0
     */
    public function delete(
        string $id,
    ): PromiseInterface {
        return $this->call(
            'liveChatBans.delete',
            'DELETE',
            'youtube/v3/liveChat/bans',
            query: [
                'id' => $id,
            ],
        );
    }

    /**
     * Inserts a new resource into this collection.
     *
     * Costs 50 units of quota.
     *
     * @param list<string>|string $part The *part* parameter serves two purposes in this operation. It
     *     identifies the properties that the write operation will set as well as the properties that the API
     *     response returns. Set the parameter value to snippet.
     * @param \YouTube\Parts\LiveChatBan|array<string, mixed> $body The LiveChatBan to send.
     *
     * @return PromiseInterface<\YouTube\Parts\LiveChatBan>
     *
     * @link https://developers.google.com/youtube/v3/live/docs/liveChatBans/insert
     *
     * @since 1.0.0
     */
    public function insert(
        array|string $part,
        array|\JsonSerializable $body,
    ): PromiseInterface {
        return $this->call(
            'liveChatBans.insert',
            'POST',
            'youtube/v3/liveChat/bans',
            query: [
                'part' => $part,
            ],
            body: $body,
            returns: 'LiveChatBan',
        );
    }
}
