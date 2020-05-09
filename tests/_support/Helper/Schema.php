<?php
namespace App\Tests\Helper;

use Codeception\Module;
use Exception;
use JsonSchema\Constraints\Factory;
use JsonSchema\SchemaStorage;
use JsonSchema\Validator;

class Schema extends Module
{
    private const SCHEMA_ID     = 'file://acme';
    public const PRODUCT        = 'product';
    public const BAD_REQUEST    = 'invalid_request';
    const PAGE                  = 'page';

    /** @var object | array */
    private $schema;

    public function _beforeSuite($settings = [])
    {
        $json = @file_get_contents(__DIR__ . '/../../_data/schema.json');

        if ($json === false) {
            throw new Exception('Schema does not exists or unreadable');
        }

        $this->schema = json_decode($json);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->fail('Schema is not a valid JSON file:' . json_last_error_msg());
        }

        parent::_beforeSuite($settings);
    }

    public function seeResponseSchemaMatches(string $definition): void
    {
        /** @var Module\REST $rest */
        $rest = $this->getModule('REST');
        $json = json_decode($rest->grabResponse());

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->fail('Response is not a valid JSON:' . json_last_error_msg());
        }

        $storage = new SchemaStorage();

        $storage->addSchema(self::SCHEMA_ID, $this->schema);

        $validator = new Validator(new Factory($storage));
        $validator->validate($json, ['$ref' => sprintf("%s#/definitions/%s", self::SCHEMA_ID, $definition)]);

        $errors = $validator->getErrors();

        if (!empty($errors)) {

            $callback = function($error) {
                return sprintf('%s: %s', $error['property'], $error['message']);
            };

            $this->fail(join(PHP_EOL, array_map($callback, $errors)));
        }
    }
}
