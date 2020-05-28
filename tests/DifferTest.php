<?php

namespace Differ\tests\DifferTest;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;
use function Differ\Render\render;

class DifferTest extends TestCase
{
    protected $correctJson;
    protected $correctPretty;
    protected $correctPlain;

    protected $jsonAst;
    protected $yamlAst;

    protected function setUp(): void
    {
        $this->correctJson = file_get_contents(__DIR__ . "/fixtures/correct/correct_json");
        $this->correctPretty = file_get_contents(__DIR__ . "/fixtures/correct/correct_pretty");
        $this->correctPlain = file_get_contents(__DIR__ . "/fixtures/correct/correct_plain");

        $this->jsonAst = genDiff(__DIR__ . "/fixtures/before.json", __DIR__ . "/fixtures/after.json");
        $this->yamlAst = genDiff(__DIR__ . "/fixtures/before.yaml", __DIR__ . "/fixtures/after.yaml");
    }

    public function testPlainDiff()
    {
        $jsonDiff = render($this->jsonAst, 'plain');
        $yamlDiff = render($this->yamlAst, 'plain');

        $this->assertEquals($this->correctPlain, $jsonDiff);
        $this->assertEquals($this->correctPlain, $yamlDiff);
    }

    public function testPrettyDiff()
    {
        $jsonDiff = render($this->jsonAst);
        $yamlDiff = render($this->yamlAst);

        $this->assertEquals($this->correctPretty, $jsonDiff);
        $this->assertEquals($this->correctPretty, $yamlDiff);
    }

    public function testJsonDiff()
    {
        $jsonDiff = render($this->jsonAst, 'json');
        $yamlDiff = render($this->yamlAst, 'json');

        $this->assertEquals($this->correctJson, $jsonDiff);
        $this->assertEquals($this->correctJson, $yamlDiff);
    }
}
