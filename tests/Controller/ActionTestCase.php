<?php

namespace App\Tests\Controller;

use App\Test\Schema;
use Helmich\JsonAssert\JsonAssertions;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class ActionTestCase extends WebTestCase
{
    use JsonAssertions;

    protected function assertActionResponse(
        callable $makeRequest,
        int $statusCode,
        Schema $schema = null,
        array $constraints = []
    ): void {
        $client = static::createClient();

        $makeRequest($client);

        self::assertResponseStatusCodeSame($statusCode);
        self::assertResponseFormatSame('json');

        $json = $client->getResponse()->getContent();

        if ($schema !== null) {
            self::assertJsonDocumentMatchesSchema($json, json_decode(json_encode($schema), true));
        }

        if (!empty($constraints)) {
            self::assertJsonDocumentMatches($json, $constraints);
        }
    }
}
