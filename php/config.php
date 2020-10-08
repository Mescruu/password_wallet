<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'password_wallet');
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$db = new BD("localhost", "root", "", "password_wallet");

define('pepper', '6883589765f7e08e226dff0x01019947');
