<?php

namespace OpenTokTest\Validators;

use OpenTok\Exception\InvalidArgumentException;
use OpenTok\Util\Validators;
use PHPUnit\Framework\TestCase;

class ValidatorsTest extends TestCase
{
    public function testWillValidateStringApiKey(): void
    {
        $this->expectNotToPerformAssertions();
        $apiKey = '47347801';
        Validators::validateApiKey($apiKey);
    }

    public function testWillValidateIntegerApiKey(): void
    {
        $this->expectNotToPerformAssertions();
        $apiKey = 47347801;
        Validators::validateApiKey($apiKey);
    }

    public function testWillInvalidateApiKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $apiKey = [47347801];
        Validators::validateApiKey($apiKey);
    }

    public function testWillValidateApiSecret(): void
    {
        $this->expectNotToPerformAssertions();
        $secret = 'cdff574f0b071230be098e279d16931116c43fcf';
        Validators::validateApiSecret($secret);
    }

    public function testWillInvalidateApiSecret(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $secret = 3252556;
        Validators::validateApiSecret($secret);
    }

    public function testWillValidateApiUrl(): void
    {
        $this->expectNotToPerformAssertions();
        $apiUrl = 'https://api.opentok.com';
        Validators::validateApiUrl($apiUrl);
    }

    public function testWillInvalidateApiUrl(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $apiUrl = 'dave@opentok.com';
        Validators::validateApiUrl($apiUrl);
    }

    public function testWillPassCorrectForceMutePayload(): void
    {
        $this->expectNotToPerformAssertions();

        $options = [
            'excludedStreams' => [
                'streamId1',
                'streamId2'
            ],
            'active' => true
        ];

        Validators::validateForceMuteAllOptions($options);
    }

    public function testIsAssocWithValidArray(): void
    {
        $haystack = [
            'one' => '1',
            'two' => '2',
            'three' => '3',
            'four' => '4'
        ];

        $this->assertTrue(Validators::isAssoc($haystack));
    }

    public function testIsAssocWithInvalidArray(): void
    {
        $haystack = [
            'one',
            'two',
            'three',
            'four'
        ];

        $this->assertFalse(Validators::isAssoc($haystack));
    }

    public function testWillFailWhenStreamIdsAreNotCorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $options = [
            'excludedStreams' => [
                3536,
                'streamId2'
            ],
            'active' => true
        ];

        Validators::validateForceMuteAllOptions($options);
    }

    public function testWillFailWhenActiveIsNotBool(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $options = [
            'excludedStreams' => [
                'streamId1',
                'streamId2'
            ],
            'active' => 'true'
        ];

        Validators::validateForceMuteAllOptions($options);
    }

    public function testWillFailWhenStreamIdsIsNotArray(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $options = [
            'excludedStreams' => 'streamIdOne',
            'active' => false
        ];

        Validators::validateForceMuteAllOptions($options);
    }

    public function testWillValidateWebsocketConfiguration(): void
    {
        $this->expectNotToPerformAssertions();
        $websocketConfig = [
            'uri' => 'ws://valid-websocket',
            'streams' => [
                '525503c7-913e-43a1-84b4-31b2e9fe668b',
                '14026813-4f50-4a5a-9b72-fea25430916d'
            ]
        ];
        Validators::validateWebsocketOptions($websocketConfig);
    }

    public function testWillThrowExceptionOnInvalidWebsocketConfiguration(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $websocketConfig = [
            'streams' => [
                '525503c7-913e-43a1-84b4-31b2e9fe668b',
                '14026813-4f50-4a5a-9b72-fea25430916d'
            ]
        ];
        Validators::validateWebsocketOptions($websocketConfig);
     }

    /**
     * @dataProvider resolutionProvider
     */
    public function testValidResolutions($resolution, $isValid): void
    {
        if (!$isValid) {
            $this->expectException(InvalidArgumentException::class);
        } else {
            $this->expectNotToPerformAssertions();
        }

        Validators::validateResolution($resolution);
    }

    public function resolutionProvider(): array
    {
        return [
            ['640x480', true],
            ['1280x720', true],
            ['1920x1080', true],
            ['480x640', true],
            ['720x1280', true],
            ['1080x1920', true],
            ['1080X1920', true],
            ['923x245', false]
        ];
    }
}
