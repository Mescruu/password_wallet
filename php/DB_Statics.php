<?php

function returnDecryptPassword($input_password, $decryptString){
// decrypt the password from the "password" table using the encryption method from the config file and the user's password. 0 stands for OPENSSL_ZERO_PADDING
// Returns the decrypted password
    return  @openssl_decrypt($input_password, constant('cypherMethod'), $decryptString, 0);
}


// Function generating the hash value using the algorithm: SHA512. Arguments: password
function hashPassword($password){
    $hashPassword = hash('sha512', $password);
    return $hashPassword;
}

// A function that generates a hash value with a key, using the HMAC method. Arguments: password and salt
function HMACPassword($password, $salt){
    /* hash_hmac
        1.
        Name of selected hashing algorithm (i.e. "md5", "sha256", "haval160,4", etc..) See hash_hmac_algos() for a list of supported algorithms.

        2.
        Message to be hashed.

        3.key
        Shared secret key used for generating the HMAC variant of the message digest.
     */
    $hashPassword =  hash_hmac('sha512', $password, $salt); //
    return $hashPassword;
}


function login_result($statement, $user_id, $ip){
    if($statement){

        $query = 'INSERT INTO `logs` (`id_log`, `id_user`, `time`, `result`, `ip`) VALUES (NULL, "'.$user_id.'", "'.date('Y-m-d H:i:s').'", "'."successful".'", "'.$ip.'");';
    }else{
    //count of failed login
        if(isset($_SESSION['failed_logs_counter'])){
            $_SESSION['failed_logs_counter'] = $_SESSION['failed_logs_counter']+1;
        }else{
            $_SESSION['failed_logs_counter'] = 1;
        }

        $query = 'INSERT INTO `logs` (`id_log`, `id_user`, `time`, `result`, `ip`) VALUES (NULL, "'.$user_id.'", "'.date('Y-m-d H:i:s').'", "'."failed".'", "'.$ip.'");';
    }
    return $query;
}

function getUserIp(){
    $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
}

function properTime($time_of_last_login,$current_time, $log_counter){
    $last_log_with_extra_time = strtotime($time_of_last_login);

        if ($log_counter <2)
            $last_log_with_extra_time=+0;

        if ($log_counter == 2)
            $last_log_with_extra_time+=5;

        if ($log_counter == 3)
            $last_log_with_extra_time+=10;

        if ($log_counter >= 4)
            $last_log_with_extra_time+=120;


        if(strtotime($current_time)>$last_log_with_extra_time){
            return true;
        }else{
            return false;
        }
}