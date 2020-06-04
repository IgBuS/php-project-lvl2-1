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

    protected function setUp(): void
    {
        $this->correctJson = file_get_contents($this->getFilePath('correct/correct_json'));
        $this->correctPretty = file_get_contents($this->getFilePath('correct/correct_pretty'));
        $this->correctPlain = file_get_contents($this->getFilePath('correct/correct_plain'));
    }

    public function getFilePath($path)
    {
        $pathToDir = __DIR__;

        return "{$pathToDir}/fixtures/{$path}";
    }

    public function testPlainDiff()
    {
        $jsonDiff = genDiff($this->getFilePath('before.json'), $this->getFilePath('after.json'), 'plain');
        $yamlDiff = genDiff($this->getFilePath('before.yaml'), $this->getFilePath('after.yaml'), 'plain');

        $this->assertEquals($this->correctPlain, $jsonDiff);
        $this->assertEquals($this->correctPlain, $yamlDiff);
    }

    public function testPrettyDiff()
    {
        $jsonDiff = genDiff($this->getFilePath('before.json'), $this->getFilePath('after.json'), 'pretty');
        $yamlDiff = genDiff($this->getFilePath('before.yaml'), $this->getFilePath('after.yaml'), 'pretty');

        $this->assertEquals($this->correctPretty, $jsonDiff);
        $this->assertEquals($this->correctPretty, $yamlDiff);
    }

    public function testJsonDiff()
    {
        $jsonDiff = genDiff($this->getFilePath('before.json'), $this->getFilePath('after.json'), 'json');
        $yamlDiff = genDiff($this->getFilePath('before.yaml'), $this->getFilePath('after.yaml'), 'json');

        $this->assertEquals($this->correctJson, $jsonDiff);
        $this->assertEquals($this->correctJson, $yamlDiff);
    }
}
