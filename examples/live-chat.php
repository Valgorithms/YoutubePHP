<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

/**
 * Prints the signed-in channel's live chat while it streams, and says when it
 * goes live and when it ends.
 *
 *     php examples/live-chat.php
 *
 * Add `!ping` to answer that in the chat itself; posting costs 50 units of
 * quota, so it is off unless asked for.
 */

use YouTube\LiveChat\BroadcastWatcher;
use YouTube\LiveChat\ChatReader;
use YouTube\Parts\LiveBroadcast;
use YouTube\Parts\LiveChatMessage;
use YouTube\YouTube;

require __DIR__ . '/bootstrap.php';

$answerPing = in_array('!ping', $argv, true);
$youtube = youtube();
$watcher = new BroadcastWatcher($youtube);

/** @var array<string, ChatReader> $readers By live chat id. */
$readers = [];

$watcher->on('broadcast.live', static function (LiveBroadcast $broadcast) use ($youtube, $watcher, &$readers, $answerPing): void {
    $chatId = (string) $broadcast->snippet->liveChatId;
    printf("Live: %s\n", $broadcast->snippet->title);

    $reader = new ChatReader($youtube, $chatId);
    $readers[$chatId] = $reader;

    $reader->on('chat.message', static function (LiveChatMessage $message) use ($youtube, $chatId, $answerPing): void {
        printf("%s: %s\n", $message->authorDetails->displayName, $message->snippet->displayMessage);

        if ($answerPing && trim((string) $message->snippet->displayMessage) === '!ping') {
            $youtube->liveChatMessages->insert('snippet', [
                'snippet' => [
                    'liveChatId' => $chatId,
                    'type' => 'textMessageEvent',
                    'textMessageDetails' => ['messageText' => 'pong'],
                ],
            ]);
        }
    });
    $reader->on('chat.superchat', static function (LiveChatMessage $message): void {
        printf("💰 %s: %s\n", $message->authorDetails->displayName, $message->snippet->displayMessage);
    });
    $reader->on('chat.member', static function (LiveChatMessage $message): void {
        printf("⭐ %s\n", $message->snippet->displayMessage);
    });
    $reader->on('chat.reconnecting', static function (int $attempt, float $delay): void {
        printf("(chat dropped - trying again in %.0fs)\n", $delay);
    });
    $reader->on('chat.ended', static function () use ($watcher, $broadcast): void {
        $watcher->ended((string) $broadcast->id);
    });

    $reader->start();
});

$watcher->on('broadcast.ended', static function (LiveBroadcast $broadcast) use (&$readers): void {
    printf("Ended: %s\n", $broadcast->snippet->title);

    $chatId = (string) $broadcast->snippet->liveChatId;
    ($readers[$chatId] ?? null)?->stop();
    unset($readers[$chatId]);
});

$youtube->on('ready', static function (YouTube $youtube) use ($watcher): void {
    printf("Signed in as %s. Waiting for the channel to go live...\n", $youtube->getChannel()?->snippet?->title);
    $watcher->start();
});

$youtube->on('quota.exhausted', static function (string $bucket, \Carbon\CarbonImmutable $resets): void {
    printf("The %s quota is spent until %s.\n", $bucket, $resets->toDayDateTimeString());
});

$youtube->run();
