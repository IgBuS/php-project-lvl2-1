<?php

use PHPUnit\Framework\TestCase;
use Differ\Parsers;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    protected $firsJsonData;
    protected $secondJsonData;
    protected $firstYamlData;
    protected $secondYamlData;

    protected $correctJson;
    protected $correctPretty;
    protected $correctPlain;

    protected function setUp(): void
    {
        $this->firsJsonData = Parsers\jsonParser(__DIR__ . "/fixtures/before.json");
        $this->secondJsonData = Parsers\jsonParser(__DIR__ . "/fixtures/after.json");
        $this->firstYamlData = Parsers\yamlParser(__DIR__ . "/fixtures/before.yaml");
        $this->secondYamlData = Parsers\yamlParser(__DIR__ . "/fixtures/after.yaml");

        $this->correctJson = file_get_contents(__DIR__ . "/fixtures/correct/correct_json");
        $this->correctPretty = file_get_contents(__DIR__ . "/fixtures/correct/correct_pretty");
        $this->correctPlain = file_get_contents(__DIR__ . "/fixtures/correct/correct_plain");
    }

    public function testPlainDiff()
    {
        $this->assertEquals($this->correctPlain, genDiff($this->firsJsonData, $this->secondJsonData, 'plain'));
        $this->assertEquals($this->correctPlain, genDiff($this->firstYamlData, $this->secondYamlData, 'plain'));
    }

    public function testPrettyDiff()
    {
        $this->assertEquals($this->correctPretty, genDiff($this->firsJsonData, $this->secondJsonData, 'pretty'));
        $this->assertEquals($this->correctPretty, genDiff($this->firstYamlData, $this->secondYamlData, 'pretty'));
    }

    public function testJsonDiff()
    {
        $this->assertEquals($this->correctJson, genDiff($this->firsJsonData, $this->secondJsonData, 'json'));
        $this->assertEquals($this->correctJson, genDiff($this->firstYamlData, $this->secondYamlData, 'json'));
    }
}