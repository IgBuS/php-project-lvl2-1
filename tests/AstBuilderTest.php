<?php

use PHPUnit\Framework\TestCase;
use Differ\Parsers;
use Differ\AstBuilder;

class AstBuilderTest extends TestCase
{
    public function testAstBuilder()
    {
        $correctAst = [
            [
                'name' => 'common',
                'children' => [
                    [
                        'name' => 'setting1',
                        'value' => 'Value 1',
                        'status' => 'unchanged'
                    ],
                    [
                        'name' => 'setting2',
                        'value' => 200,
                        'status' => 'deleted'
                    ],
                    [
                        'name' => 'setting3',
                        'value' => 1,
                        'status' => 'unchanged'
                    ],
                    [
                        'name' => 'setting6',
                        'value' => [
                            'key' => 'value'
                        ],
                        'status' => 'deleted'
                    ],
                    [
                        'name' => 'setting4',
                        'value' => 'blah blah',
                        'status' => 'added'
                    ],
                    [
                        'name' => 'setting5',
                        'value' => [
                            'key5' => 'value5'
                        ],
                        'status' => 'added'
                    ],
                ],
                'status' => 'array'
            ],
            [
                'name' => 'group1',
                'children' => [
                    [
                        'name' => 'baz',
                        'prevValue' => 'bas',
                        'curValue' => 'bars',
                        'status' => 'changed'
                    ],
                    [
                        'name' => 'foo',
                        'value' => 'bar',
                        'status' => 'unchanged'
                    ],
                ],
                'status' => 'array'
            ],
            [
                'name' => 'group2',
                'value' => [
                    'abc' => '12345'
                ],
                'status' => 'deleted'
            ],
            [
                'name' => 'group3',
                'value' => [
                    'fee' => '100500'
                ],
                'status' => 'added'
            ]
        ];

        $firstJsonFile = Parsers\jsonParser(__DIR__ . '/fixtures/before.json');
        $secondJsonFile = Parsers\jsonParser(__DIR__ . '/fixtures/after.json');
        $jsonAst = AstBuilder\astBuilder($firstJsonFile, $secondJsonFile);
        $this->assertEquals($correctAst, $jsonAst);
    }
}