<?php
function nonerror($array) { //function which checks if there are errors in given array
    $allclear = 1;
    foreach($array as $item) {
        if($item!="") { $allclear = 0; break;}// if there is an error set to 0 and break the loop
    }

    if($allclear==1) { return true; } // no errors
    else { return false; } // there are errors
}

function test_input($data)
{
    $data = trim($data); // remove unnecessary spaces
    $data = stripslashes($data); // remove slashes
    $data = htmlspecialchars($data); // remove special html characters
    return $data;
}