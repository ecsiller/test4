<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Photos;

use App\Application\Actions\Action;
use GuzzleHttp\Exception\ServerException;
use Tests\Application\Actions\AbstractIntegrationTest;

class PhotosActionTest extends AbstractIntegrationTest
{
    private const TEST_FILE_PATH = '/var/www/slim/tests/files/image008.jpg';
    private const TEST_CSV_FILE_PATH = '/var/www/slim/tests/files/properties.csv';
    private const TEST_FILE_UPLOADED_PATH = '/var/www/slim/images/2/image008.jpeg';

    public function testSuccessFileUploadAction()
    {
        $request = $this->client->request(
            'POST',
            '/user/gallery',
            [
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen(self::TEST_FILE_PATH, 'r'),
                    ]
                ],
                'headers' => [
                    'Api-Token' => '8c3ef9f1b633e6558d5b'
                ]
            ]
        );

        $response = json_decode($request->getBody()->getContents(), true);
        self::assertFileExists(self::TEST_FILE_UPLOADED_PATH);
        self::assertEquals(Action::HTTP_CREATED, $this->getArrayValue($response, 'statusCode'));
        self::assertEquals('image008', $this->getArrayValue($response, 'data.0'));
        unlink(self::TEST_FILE_UPLOADED_PATH);
    }

    public function testFailWrongFormatFileUploadAction()
    {
        $this->expectException(ServerException::class);
        $this->expectExceptionCode(500);
        $this->client->request(
            'POST',
            '/user/gallery',
            [
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => fopen(self::TEST_CSV_FILE_PATH, 'r'),
                    ]
                ],
                'headers' => [
                    'Api-Token' => '8c3ef9f1b633e6558d5b'
                ]
            ]
        );
    }
}
