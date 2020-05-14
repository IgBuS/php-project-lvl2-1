<?php

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff() {
        $correctDiff = <<<EOT
{
      host: hexlet.io
    + timeout: 20
    - timeout: 50
    - proxy: 123.234.53.22
    + verbose: true
}
EOT;

        $firstFile = json_decode(file_get_contents(__DIR__ . '/fixtures/before.json'), true);
        $secondFile = json_decode(file_get_contents(__DIR__ . '/fixtures/after.json'), true);
        $this->assertEquals($correctDiff, genDiff($firstFile, $secondFile));
    }
}
