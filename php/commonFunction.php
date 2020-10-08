<?php
function nonerror($array) {

    $allclear = 1;
    foreach($array as $item) {
        if($item!="") { $allclear = 0; break;}//jezeli jest bład ustaw na 0 i przerwij pętle
    }

    if($allclear==1) { return true; } //brak błędów
    else { return false; } //są błędy
}

function test_input($data)
{
    $data = trim($data); //usuwa niepotrzebne spacje
    $data = stripslashes($data); //usuwa sleshe
    $data = htmlspecialchars($data); //usuwa znaki specjalne html
    return $data;
}