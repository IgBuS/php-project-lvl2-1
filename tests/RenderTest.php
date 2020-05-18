<?php

use PHPUnit\Framework\TestCase;
use Differ\Parsers;
use Differ\AstBuilder;
use Differ\Render;

class RenderTest extends TestCase
{
    public function testRender()
    {
        $correctDiff = <<<EOT
{
    common: {
        setting1: Value 1
      - setting2: 200
        setting3: true
      - setting6: {
            key: value
        }
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
    }
    group1: {
      + baz: bars
      - baz: bas
        foo: bar
    }
  - group2: {
        abc: 12345
    }
  + group3: {
        fee: 100500
    }
}
EOT;

        $firstJsonFile = Parsers\jsonParser(__DIR__ . '/fixtures/before.json');
        $secondJsonFile = Parsers\jsonParser(__DIR__ . '/fixtures/after.json');
        $jsonAst = AstBuilder\astBuilder($firstJsonFile, $secondJsonFile);
        $jsonDiff = Render\render($jsonAst);
        $this->assertEquals($correctDiff, $jsonDiff);

        $firstYamlFile = Parsers\yamlParser(__DIR__ . '/fixtures/before.yaml');
        $secondYamlFile = Parsers\yamlParser(__DIR__ . '/fixtures/after.yaml');
        $yamlAst = AstBuilder\astBuilder($firstYamlFile, $secondYamlFile);
        $yamlDiff = Render\render($yamlAst);
        $this->assertEquals($correctDiff, $yamlDiff);
    }



    public function testValueType()
    {
        $bool = true;
        $array = [];
        $int = 10;

        $this->assertEquals('true', Render\valueType($bool));
        $this->assertEquals("{\n\n    }", Render\valueType($array));
        $this->assertEquals(10, Render\valueType($int));
    }

    public function testArrayRender()
    {
        $userArray = [
            'key' => 'value',
            'key2' => 'value2'
        ];

        $correctOutput = "{\n        key: value\n        key2: value2\n    }";

        $this->assertEquals($correctOutput, Render\arrayRender($userArray));
    }
}