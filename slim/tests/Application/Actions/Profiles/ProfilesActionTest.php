<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Profiles;

use App\Application\Actions\Action;
use Tests\Application\Actions\AbstractIntegrationTest;

class ProfilesActionTest extends AbstractIntegrationTest
{
    private const EXPECTED_PROFILES_PATH = '/var/www/slim/tests/files/expectedProfilesResponse.json';
    private const EXPECTED_PROFILES_AFTER_SWIPE_PATH = '/var/www/slim/tests/files/expectedProfilesAfterSwipeResponse.json';

    public function testProfilesAction()
    {
        $request = $this->client->post(
            '/profiles',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Api-Token' => '900c065938c7a4885bf1'
                ],
                'body' => json_encode([])
            ]
        );

        $response = json_decode($request->getBody()->getContents(), true);
        $fileContent = preg_replace('/\s+/', '', file_get_contents(self::EXPECTED_PROFILES_PATH));
        $responseContent = preg_replace('/\s+/', '', (string)$request->getBody());

        self::assertEquals(Action::HTTP_OK, $this->getArrayValue($response, 'statusCode'));
        self::assertTrue(array_key_exists('users', $this->getArrayValue($response, 'data')));
        self::assertEquals($fileContent, $responseContent);
    }

    public function testProfilesDoesNotIncludeSwipedAction()
    {
        $this->client->post(
            '/swipe',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Api-Token' => '900c065938c7a4885bf1'
                ],
                'body' => json_encode(
                    [
                        'referral_id' => 6,
                        'like' => 'NO'
                    ]
                )
            ]
        );

        $request = $this->client->post(
            '/profiles',
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Api-Token' => '900c065938c7a4885bf1'
                ],
                'body' => json_encode([])
            ]
        );

        $response = json_decode($request->getBody()->getContents(), true);
        $fileContent = preg_replace('/\s+/', '', file_get_contents(self::EXPECTED_PROFILES_AFTER_SWIPE_PATH));
        $responseContent = preg_replace('/\s+/', '', (string)$request->getBody());

        self::assertEquals(Action::HTTP_OK, $this->getArrayValue($response, 'statusCode'));
        self::assertTrue(array_key_exists('users', $this->getArrayValue($response, 'data')));
        self::assertEquals($fileContent, $responseContent);
    }
}
