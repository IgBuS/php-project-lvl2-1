<?php

use PHPUnit\Framework\TestCase;
use Differ\Parsers;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testJsonParser() {
        $correctJsonData = [
            'host' => 'hexlet.io',
            'timeout' => 50,
            'proxy' => '123.234.53.22'
        ];

        $parsedData = Parsers\jsonParser(__DIR__ . '/fixtures/before.json');
        $this->assertEquals($correctJsonData, $parsedData);
    }

    public function testYamlParser()
    {
        $correctYamlData = [
            'host' => 'hexlet.io',
            'timeout' => 50,
            'proxy' => '123.234.53.22'
        ];

        $parsedData = Parsers\yamlParser(__DIR__ . '/fixtures/before.yaml');
        $this->assertEquals($correctYamlData, $parsedData);
    }

    public function testDifferFormats()
    {
        $correctDiff = <<<EOT
{
      host: hexlet.io
    + timeout: 20
    - timeout: 50
    - proxy: 123.234.53.22
    + verbose: true
}
EOT;

        $firstJsonFile = Parsers\jsonParser(__DIR__ . '/fixtures/before.json');
        $secondJsonFile = Parsers\jsonParser(__DIR__ . '/fixtures/after.json');
        $this->assertEquals($correctDiff, genDiff($firstJsonFile, $secondJsonFile));

        $firstYamlFile = Parsers\yamlParser(__DIR__ . '/fixtures/before.yaml');
        $secondYamlFile = Parsers\yamlParser(__DIR__ . '/fixtures/after.yaml');
        $this->assertEquals($correctDiff, genDiff($firstYamlFile, $secondYamlFile));
    }
}
