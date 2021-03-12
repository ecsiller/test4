<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Login;

use App\Application\Actions\Action;
use GuzzleHttp\Exception\ClientException;
use Tests\Application\Actions\AbstractIntegrationTest;

class LoginActionTest extends AbstractIntegrationTest
{
    public function testSuccessLoginAction()
    {
        $request = $this->client->post(
            '/login',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode(
                    [
                        'email' => 'samson_ms_kuphal@swaniawski.net',
                        'password' => 'nZctwDPGwH',
                    ]
                )
            ]
        );

        $response = json_decode($request->getBody()->getContents(), true);
        self::assertEquals(Action::HTTP_CREATED, $this->getArrayValue($response, 'statusCode'));
        self::assertTrue(array_key_exists('token', $this->getArrayValue($response, 'data.0')));
    }

    public function testFailLoginAction()
    {
        $request = $this->client->post(
            '/login',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode(
                    [
                        'email' => 'fake',
                        'password' => 'nZctwDPGwH',
                    ]
                )
            ]
        );

        $response = json_decode($request->getBody()->getContents(), true);
        self::assertEquals(Action::HTTP_OK, $this->getArrayValue($response, 'statusCode'));
        self::assertEquals('Invalid credentials please try again', $this->getArrayValue($response, 'data.0'));
    }

    public function testMissingParametersLoginAction()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionCode(400);
        $this->client->post(
            '/login',
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode(
                    [
                        'password' => 'nZctwDPGwH',
                    ]
                )
            ]
        );
    }
}
