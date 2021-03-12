<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\Action;
use Tests\Application\Actions\AbstractIntegrationTest;

class UserActionTest extends AbstractIntegrationTest
{
    public function testNewUserAction()
    {
        $usersFixtureCount = 22;
        $this->assertTableRowCount($usersFixtureCount, 'users');
        $request = $this->client->post(
            '/user/create',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode([])
            ]
        );

        $response = json_decode($request->getBody()->getContents(), true);
        $data = $this->getArrayValue($response, 'data');

        self::assertEquals(Action::HTTP_CREATED, $this->getArrayValue($response, 'statusCode'));
        self::assertTrue(array_key_exists('id', $data));
        self::assertTrue(array_key_exists('email', $data));
        self::assertTrue(array_key_exists('password', $data));
        self::assertTrue(array_key_exists('name', $data));
        self::assertTrue(array_key_exists('gender', $data));
        self::assertTrue(array_key_exists('age', $data));
        $this->assertTableRowCount(++$usersFixtureCount, 'users');
    }
}
