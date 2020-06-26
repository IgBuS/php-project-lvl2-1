<?php

namespace Differ\tests\DifferTest;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    /**
     * @param $format
     * @param $firstFile
     * @param $secondFile
     * @param $correctDiff
     *
     * @throws \Exception
     * @dataProvider providerDiffData
     */

    public function testGenDiff($format, $firstFile, $secondFile, $correctDiff)
    {
        $answer = file_get_contents($this->getFilePath($correctDiff));

        $this->assertEquals($answer, genDiff($this->getFilePath($firstFile), $this->getFilePath($secondFile), $format));
    }

    public function providerDiffData()
    {
        return [
            'prettyJsonDiff' => [
                'pretty',
                'before.json',
                'after.json',
                'correct/correct_pretty'
            ],
            'plainJsonDiff' => [
                'plain',
                'before.json',
                'after.json',
                'correct/correct_plain'
            ],
            'jsonJsonDiff' => [
                'json',
                'before.json',
                'after.json',
                'correct/correct_json'
            ],
            'prettyYamlDiff' => [
                'pretty',
                'before.yaml',
                'after.yaml',
                'correct/correct_pretty'
            ],
            'plainYamlDiff' => [
                'plain',
                'before.yaml',
                'after.yaml',
                'correct/correct_plain'
            ],
            'jsonYamlDiff' => [
                'json',
                'before.yaml',
                'after.yaml',
                'correct/correct_json'
            ]
        ];
    }

    private function getFilePath($filePath)
    {
        $dir = __DIR__;

        return "{$dir}/fixtures/{$filePath}";
    }
}
