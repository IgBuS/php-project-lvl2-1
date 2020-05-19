<?php

use PHPUnit\Framework\TestCase;
use Differ\Parsers;
use Differ\AstBuilder;
use Differ\Render;

class RenderTest extends TestCase
{
    public function testRender()
    {
        $correctPrettyDiff = <<<EOT
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
        $correctPlainDiff = <<<EOT
Property 'common.setting2' was removed
Property 'common.setting6' was removed
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: 'complex value'
Property 'group1.baz' was changed. From 'bas' to 'bars'
Property 'group2' was removed
Property 'group3' was added with value: 'complex value'
EOT;

        $firstJsonFile = Parsers\jsonParser(__DIR__ . '/fixtures/before.json');
        $secondJsonFile = Parsers\jsonParser(__DIR__ . '/fixtures/after.json');
        $jsonAst = AstBuilder\astBuilder($firstJsonFile, $secondJsonFile);
        $jsonPrettyDiff = Render\render($jsonAst);
        $jsonPlainDiff = Render\render($jsonAst, 'plain');
        $this->assertEquals($correctPrettyDiff, $jsonPrettyDiff);
        $this->assertEquals($correctPlainDiff, $jsonPlainDiff);

        $firstYamlFile = Parsers\yamlParser(__DIR__ . '/fixtures/before.yaml');
        $secondYamlFile = Parsers\yamlParser(__DIR__ . '/fixtures/after.yaml');
        $yamlAst = AstBuilder\astBuilder($firstYamlFile, $secondYamlFile);
        $yamlPrettyDiff = Render\render($yamlAst);
        $yamlPlainDiff = Render\render($yamlAst, 'plain');
        $this->assertEquals($correctPrettyDiff, $yamlPrettyDiff);
        $this->assertEquals($correctPlainDiff, $yamlPlainDiff);
    }
}