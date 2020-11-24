<?php


use PHPUnit\Framework\TestCase;
require __DIR__ . "\..\php\commonFunction.php";

class commonFunctionTest extends TestCase
{
    /**
     * @dataProvider nonerrorProvider
     */
    public function testNonerror(array $input, bool $expected): void
    {
        $this->assertSame($expected, nonerror($input));
    }

    public function nonerrorProvider(): array
    {
        return [
            [
                [
                    "login" => "",
                    "password" => "",
                    "repeatPassword" => "",
                    "hashType" => "",
                ],
                true
            ],
            [
                [
                    "login" => "sample_error",
                    "password" => "sample_error",
                    "repeatPassword" => "sample_error",
                    "hashType" => "sample_error",
                ],
                false
            ]
        ];
    }

    /**
     * @dataProvider inputProvider
     */
    public function testTest_input(String $input, String $expected): void
    {
        $this->assertSame($expected, test_input($input));
    }

    public function inputProvider(): array
    {

        return [
            [//test trim
                "\t\tThese are a few words :) ...  ",
                "These are a few words :) ..."
            ],
            [
                "\x09Example string\x0A",
                "Example string"
            ],
            [ //test stripslashes
                "Is your name O\'reilly?",
                "Is your name O'reilly?"
            ],
            [
                "<a href='test'>Test</a>",
                "&lt;a href='test'&gt;Test&lt;/a&gt;"
            ]
        ];
    }


}
