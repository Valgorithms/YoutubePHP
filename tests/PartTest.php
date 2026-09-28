<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Tests;

use Carbon\CarbonImmutable;
use Discord\Helpers\Collection;
use PHPUnit\Framework\TestCase;
use YouTube\Factory\Factory;
use YouTube\Parts\ChannelContentDetailsRelatedPlaylists;
use YouTube\Parts\LiveChatMessage;
use YouTube\Parts\LiveChatMessageListResponse;
use YouTube\Parts\LiveChatMessageSnippet;
use YouTube\Parts\LiveChatSuperChatDetails;
use YouTube\Parts\Video;
use YouTube\Parts\VideoLocalization;

/**
 * Payloads becoming parts: nested objects, lists, maps and timestamps, and
 * back to the same JSON.
 */
final class PartTest extends TestCase
{
    /** A page of chat as YouTube sends it. */
    private const PAGE = [
        'kind' => 'youtube#liveChatMessageListResponse',
        'pollingIntervalMillis' => 3000,
        'nextPageToken' => 'GO_ON',
        'items' => [
            [
                'kind' => 'youtube#liveChatMessage',
                'id' => 'm1',
                'snippet' => [
                    'type' => 'superChatEvent',
                    'liveChatId' => 'chat',
                    'publishedAt' => '2026-09-27T19:00:00.123456+00:00',
                    'hasDisplayContent' => true,
                    'displayMessage' => '$5.00 from Viewer: great stream',
                    'superChatDetails' => [
                        'amountMicros' => '5000000',
                        'currency' => 'USD',
                        'amountDisplayString' => '$5.00',
                        'userComment' => 'great stream',
                        'tier' => 2,
                    ],
                ],
                'authorDetails' => [
                    'channelId' => 'UCviewer',
                    'displayName' => 'Viewer',
                    'isChatSponsor' => false,
                ],
            ],
        ],
    ];

    public function testAPageHydratesAllTheWayDown(): void
    {
        $page = Factory::standalone()->create('LiveChatMessageListResponse', self::PAGE);

        $this->assertInstanceOf(LiveChatMessageListResponse::class, $page);
        $this->assertSame(3000, $page->pollingIntervalMillis);
        $this->assertInstanceOf(Collection::class, $page->items);

        $message = $page->items->first();
        $this->assertInstanceOf(LiveChatMessage::class, $message);
        $this->assertInstanceOf(LiveChatMessageSnippet::class, $message->snippet);
        $this->assertSame(LiveChatMessageSnippet::TYPE_SUPER_CHAT_EVENT, $message->snippet->type);
        $this->assertInstanceOf(LiveChatSuperChatDetails::class, $message->snippet->superChatDetails);
        $this->assertSame('5000000', $message->snippet->superChatDetails->amountMicros, 'a 64-bit number stays a string');
        $this->assertSame('Viewer', $message->authorDetails->displayName);
    }

    public function testATimestampReadsBackAsCarbon(): void
    {
        $snippet = new LiveChatMessageSnippet(null, self::PAGE['items'][0]['snippet']);

        $this->assertInstanceOf(CarbonImmutable::class, $snippet->publishedAt);
        $this->assertSame('2026-09-27T19:00:00+00:00', $snippet->publishedAt->toIso8601String());
        $this->assertSame('2026-09-27T19:00:00.123456+00:00', $snippet->getRawAttribute('publishedAt'), 'kept as YouTube sent it');
    }

    public function testItSerialisesBackToWhatArrived(): void
    {
        $page = Factory::standalone()->create('LiveChatMessageListResponse', self::PAGE);

        $this->assertSame(self::PAGE, json_decode(json_encode($page), true));
    }

    public function testAMapKeepsItsKeys(): void
    {
        $video = new Video(null, ['localizations' => ['fr' => ['title' => 'Bonjour'], 'de' => ['title' => 'Hallo']]]);

        $this->assertSame(['fr', 'de'], array_keys($video->localizations));
        $this->assertInstanceOf(VideoLocalization::class, $video->localizations['fr']);
        $this->assertSame('Hallo', $video->localizations['de']->title);
    }

    public function testAnInlineObjectBecomesAPartOfItsOwn(): void
    {
        $details = Factory::standalone()->create('ChannelContentDetails', ['relatedPlaylists' => ['uploads' => 'UU1']]);

        $this->assertInstanceOf(ChannelContentDetailsRelatedPlaylists::class, $details->relatedPlaylists);
        $this->assertSame('UU1', $details->relatedPlaylists->uploads);
    }

    public function testAFieldGoogleAddedLaterStillReadsBack(): void
    {
        $message = new LiveChatMessage(null, ['id' => 'm1', 'brandNewField' => ['x' => 1]]);

        $this->assertSame(['x' => 1], $message->brandNewField);
    }

    public function testAPartCanBeBuiltToSend(): void
    {
        $message = new LiveChatMessage();
        $message->snippet = [
            'liveChatId' => 'chat',
            'type' => LiveChatMessageSnippet::TYPE_TEXT_MESSAGE_EVENT,
            'textMessageDetails' => ['messageText' => 'hello'],
        ];

        $this->assertInstanceOf(LiveChatMessageSnippet::class, $message->snippet);
        $this->assertSame('{"snippet":{"liveChatId":"chat","type":"textMessageEvent","textMessageDetails":{"messageText":"hello"}}}', (string) $message);
    }

    public function testAPartWithoutAClientSaysSoWhenAskedForOne(): void
    {
        $this->expectException(\LogicException::class);

        (new LiveChatMessage())->getYouTube();
    }
}
