<?php

namespace password_wallet;

use PHPUnit\Framework\TestCase;
require __DIR__ . "\..\php\DB_Statics.php"; //dołączenie klasy DB_Statics którą testujemy

class BDTest extends TestCase
{
    /**
     * @dataProvider ReturnDecryptPasswordProvider
     */
    public function testReturnDecryptPassword(string $input_password, string $input_session_password, bool $expected){
        $this->assertFalse($expected, returnDecryptPassword($input_password, $input_session_password));
    }

    public function ReturnDecryptPasswordProvider(): array {
        return [
            [
                "F6tYCnkWCqCG7NDz9bqbLw==", //input password
                "test2", //input session password
                 false //expected
            ]
        ];
    }


    /**
     * @dataProvider HashPasswordProvider
     */
    public function testHashPassword(string $input_salt, string $input_password, string $input_pepper, string $expected): void
    {
        $this->assertSame($expected, hashPassword($input_password.$input_salt.$input_pepper));
    }

    public function HashPasswordProvider(): array
    {
        return [
            [
                "21393807795f9ecce161", //salt
                "test", //password
                "6883589765f7e08e226dff0x01019947", //pepper
                "795d08f0f8b31407e0e5f21a684aac039d5bf8589892f51bd8e1b75b5ac1157d2078fcbdb94d626b079eb066564a2573d6df24673aa6fe08e04fa0c67d765fdf" //expected
            ]
        ];
    }

    /**
     * @dataProvider HMACPasswordProvider
     */
    public function testHMACPassword(string $input_salt, string $input_password, string $input_pepper, string $expected): void
    {
        $this->assertSame($expected, HMACPassword($input_password,$input_salt.$input_pepper));
    }

    public function HMACPasswordProvider(): array
    {
        return [
            [
                "8317323075f9ecd1edcc", //salt
                "test", //password
                "6883589765f7e08e226dff0x01019947", //pepper
                "c360d7cc0454b121bc4bd276b844090316ff7281aff1c4dc45265d643145d64180029647303513e0b44a4535f5d563e276f6ec104b77f7e0a3cf2edb1c0e901e" //expected
            ],
        ];
    }

    /**
     * @dataProvider Login_ResultProvider
     */
    public function testLogin_Result(bool $statement, int $user_id, string $ip, string $expected):void {
        $this->assertSame($expected, login_result($statement, $user_id, $ip));
    }

    public function Login_ResultProvider(): array
    {
        return [
            [
                false, //statement
                40, //user_id
                "::1", //ip
                'INSERT INTO `logs` (`id_log`, `id_user`, `time`, `result`, `ip`) VALUES (NULL, "40", "'.date('Y-m-d H:i:s').'", "failed", "::1");', //excepted query
            ],
            [
                true, //statement
                40, //user_id
                "::1", //ip
                'INSERT INTO `logs` (`id_log`, `id_user`, `time`, `result`, `ip`) VALUES (NULL, "40", "'.date('Y-m-d H:i:s').'", "successful", "::1");', //excepted query
            ]
        ];
    }


    /**
     * @dataProvider properTimeProvider
     */
    public function testproperTime(string $time_of_last_login, string $current_time, int $log_counter, bool $expected):void {
        $this->assertSame($expected, properTime($time_of_last_login, $current_time, $log_counter));
    }

    public function properTimeProvider(): array
    {
        return [
            [
                "2020-11-24 12:14:43", //$time_of_last_login
                "2020-11-24 12:14:44", //$current_time
                1, //$log_counter
                true //expected
            ],
            [
                "2020-11-24 12:14:43", //$time_of_last_login
                "2020-11-24 12:14:49", //$current_time
                2, //$log_counter
                true //expected
            ],
            [
                "2020-11-24 12:14:43", //$time_of_last_login
                "2020-11-24 12:14:54", //$current_time
                3, //$log_counter
                true //expected
            ],
            [
                "2020-11-24 12:14:43", //$time_of_last_login
                "2020-11-24 12:16:44", //$current_time
                4, //$log_counter
                true //expected
            ],
            [
                "2020-11-24 12:14:43", //$time_of_last_login
                "2020-11-24 12:14:44", //$current_time
                2, //$log_counter
                false //expected
            ],
            [
                "2020-11-24 12:14:43", //$time_of_last_login
                "2020-11-24 12:14:52", //$current_time
                3, //$log_counter
                false //expected
            ],
            [
                "2020-11-24 12:14:43", //$time_of_last_login
                "2020-11-24 12:16:42", //$current_time
                4, //$log_counter
                false //expected
            ]
        ];
    }

}
