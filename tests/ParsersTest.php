<?php

use PHPUnit\Framework\TestCase;
use Differ\Parsers;

class ParsersTest extends TestCase
{
    public $correctData;

    public function setUp(): void
    {
        $this->correctData = [
            'common' => [
                'setting1' => 'Value 1',
                'setting2' => '200',
                'setting3' => true,
                'setting6' => [
                    'key' => 'value'
                ]
            ],
            'group1' => [
                'baz' => 'bas',
                'foo' => 'bar'
            ],
            'group2' => [
                'abc' => '12345'
            ]
        ];
    }

    public function testJsonParser()
    {
        $parsedData = Parsers\jsonParser(__DIR__ . '/fixtures/before.json');
        $this->assertEquals($this->correctData, $parsedData);
    }

    public function testYamlParser()
    {
        $parsedData = Parsers\yamlParser(__DIR__ . '/fixtures/before.yaml');
        $this->assertEquals($this->correctData, $parsedData);
    }
}
