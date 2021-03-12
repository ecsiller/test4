<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Swipe;

use App\Application\Actions\Action;
use App\Application\Actions\Swipe\UserSwipeAction;
use Tests\Application\Actions\AbstractIntegrationTest;

class SwipeActionTest extends AbstractIntegrationTest
{
    public function testSwipeNoMatchAction()
    {
        $request = $this->client->post(
            '/swipe',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Api-Token' => 'eae64280134150eaaca7'
                ],
                'body' => json_encode(
                    [
                        'referral_id' => 22,
                        'like' => 'YES'
                    ]
                )
            ]
        );
        $response = json_decode($request->getBody()->getContents(), true);

        self::assertEquals(Action::HTTP_OK, $this->getArrayValue($response, 'statusCode'));
        self::assertEquals(UserSwipeAction::NO_MATCH_RESPONSE, $this->getArrayValue($response, 'data.0'));
        self::assertTrue(array_key_exists('data', $response));
    }

    public function testSwipeMatchAction()
    {
        $request = $this->client->post(
            '/swipe',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Api-Token' => '432e5c7ccf060f92a6b7'
                ],
                'body' => json_encode(
                    [
                        'referral_id' => 21,
                        'like' => 'YES'
                    ]
                )
            ]
        );
        $response = json_decode($request->getBody()->getContents(), true);

        self::assertEquals(Action::HTTP_OK, $this->getArrayValue($response, 'statusCode'));
        self::assertEquals(UserSwipeAction::MATCH_RESPONSE, $this->getArrayValue($response, 'data.0'));
        self::assertTrue(array_key_exists('data', $response));
    }
}
