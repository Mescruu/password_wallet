<?php

//file with constants and db create function.
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'password_wallet');


define('pepper', '6883589765f7e08e226dff0x01019947'); //pepper value
define('cypherMethod', 'AES-256-CBC'); //cipher method

//action types
define('create', 1);
define('read', 2);
define('update', 3);
define('delete', 4);

function create_DB(){ //function allows to create database handler
    return $db = new BD(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
}