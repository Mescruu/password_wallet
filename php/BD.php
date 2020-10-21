<?php

include_once('user.php');
include_once("config.php"); // configuration constants;

class BD {

    public $mysqli; // handle to the database

    public function __construct($server,$user,$pass,$base) {// create a handle to the database
        $this->mysqli = new mysqli($server,$user,$pass,$base);

        if($this->mysqli->connect_errno){
            printf("Connection to the server failed: %s\n",$this->mysqli->connect_error);// creation error
            exit();
        }
        if($this->mysqli->set_charset("utf8")){} // set the character set.
    }

    function __destruct() { // delete the object
        $this->mysqli->close();
    }

// Function that creates a user object on the basis of data from the database / Argument: user login
    public function getUser($login)
    {
        // Query the record in the table "user" with the given login
        $sql= "select * from user where login='$login'";

        // execute the query
        $result = $this->select($sql);

        // if there is such a record
        if ($result!=null&&$result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $user = new user($row["id"],  $row["login"], $row["password_hash"], $row["salt"], $row["isPasswordKeptAsHash"]); // create a user object with the database fetched data.
            }
            return $user; // return the user object
        } else {
            return null;// return null if the user with the given login does not exist.
        }
    }

    public  function  createPartition($login, $password, $description, $web_address, $user_Id){
        // encrypt the password using the encryption method in the config file and the user's password. 1 means OPENSSL_ZERO_PADDING
        $encryptedPassword= @openssl_encrypt($password, constant('cypherMethod'), $_SESSION['password'], 0);

        // call the insert function to the database
        $insert_sql = 'INSERT INTO `password` (`id`, `password`, `id_user`, `web_address`, `description`,`login`) VALUES (NULL, "'.$encryptedPassword.'", "'.$user_Id.'", "'.$web_address.'", "'.$description.'", "'.$login.'");';
        $this->insert($insert_sql);

        //feedback
        return "Position added";
    }

// Get the appropriate partition. argument: the user id
    public function getPartition($userId){
    // SQL query for tabs with passwords of the given user
        $sql= "select * from password where id_user='$userId;'";

        // execute the query
        $result = $this->select($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $partitions[] = new partition($row["id"],  $row["password"], $row["id_user"], $row["web_address"], $row["description"], $row["login"]);
            }
            return $partitions; // return the array of partition.

        } else {
            return null;
        }
    }

// Function that removes a record from the "password" table with the given id. Item id.
    public  function  deletePosition($id){
// Query removing the item from the portfolio
        $sql= "DELETE from password where id='$id;'";

// SQL execution
        if ($this->mysqli->query($sql) === TRUE) {
            return "Position removed"."\n";
        } else {
            return "Position was not removed". $this->mysqli->error;
        }
    }

    public  function decryptPassword($id){
// query for a password with a given id
        $sql= "select password from password where id='$id'";

// query result
        $result = $this->select($sql);

// get the password from the database
        if ($result!=null && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
               $password= $row["password"];
            }
        } else {
            return null;// in case there is no such record
        }
// decrypt the password from the "password" table using the encryption method from the config file and the user's password. 0 stands for OPENSSL_ZERO_PADDING
        $decrypted = @openssl_decrypt($password, constant('cypherMethod'), $_SESSION['password'], 0);

// Returns the decrypted password
        return $decrypted;
    }

// Function responsible for user login. Arguments: user login, password and the way in which his password was hashed.
    public  function login($login, $password){
// create a user with a given login
        $user=$this->getUser($login);

        if($user!=null){// if the user with the given login exists:
            if($user->getIsPasswordKeptAsHash()==1)// if encoded with SHA512
            {
               @$loginPasswordHas = $this->hashPassword($password.$user->getSalt().constant('pepper')); // call SHA512 with password from the form and combined salt and pepper from config.
            }
            else{//jeżeli jest kodowane MHAC
                @$loginPasswordHas = $this->HMACPassword($password,$user->getSalt().constant('pepper')); // call the HMAC function with the password from the form and the salt and pepper combined
            }

            //sprawdzenie hashu
            if(hash_equals($user->getPassword_Hash(), $loginPasswordHas)){

                $_SESSION['login'] = $login;
                $_SESSION['info'] = "You are now logged in";
                $_SESSION['password'] = $password;

                header('location: password_wallet.php'); // transfer to the appropriate page
            }else{
                return "Wrong password";
            }
        }else{ // if there is no such user
            return "There is no user with that login!";
        }
    }

// function for creating a new user and changing the password
    public  function registerUser($login, $password, $keptAsHash, $register){
        // salt generating
        $salt = substr(uniqid(mt_rand(), false), 0, 20); // create a string of 23 characters in the uniqid function, and then cut off the last 3, because the maximum salt length in the database is 20.

        if($keptAsHash)
        { // if it is hashing with SHA512
            @$passwordHash = $this->hashPassword($password.$salt.constant('pepper')); // include the constant pepper from config.
            $keptAsHash=1;
        }
        else{ // if it is hashing with HMAC
            @$passwordHash = $this->HMACPassword($password, $salt.constant('pepper'));// combine salt and pepper for hash_hmac as key
            $keptAsHash=0;
        }

// call the introductory function to the database
        if($register){
            $this->register($login, $passwordHash, $keptAsHash, $salt);
        }else{
            $this->changePassword($login, $passwordHash, $keptAsHash, $salt, $password);
        }

        // saving the user's login and password in the session variables
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
    }

    public function register($login, $passwordHash, $keptAsHash, $salt){
        $insert_sql = 'INSERT INTO `user` (`id`, `login`, `password_hash`, `salt`, `isPasswordKeptAsHash`) VALUES (NULL, "'.$login.'", "'.$passwordHash.'", "'.$salt.'", "'.$keptAsHash.'");';
        $this->insert($insert_sql); // call the function that introduces data to the database
        $_SESSION['info'] = "You are now logged in"; // save the session variable with feedback
        header('location: password_wallet.php'); // transfer to the appropriate page

    }
    public  function changePassword($login, $passwordHash, $keptAsHash, $salt, $password){
        $update_sql = 'UPDATE user SET `password_hash`= "'.$passwordHash.'", `salt` = "'.$salt.'", `isPasswordKeptAsHash` = "'.$keptAsHash.'" WHERE login = "'.$login.'";';
        $this->insert($update_sql); // call the insert function to the database
        $_SESSION['info'] = "Your password has changed";// save the session variable with feedback

        $this->changePasswordsInDataBase($_SESSION['password'], $password); //old password to decrypt passwords in wallet, new password to encrypt again
    }

    public function changePasswordsInDataBase($old_password, $new_password){

        //query allowing to take the id and password from the database
        $sql= "select id, password from password";

        // execute the query
        $result = $this->select($sql);

        // if there is such a record
        if ($result!=null && $result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $id = $row["id"]; //take from database itd value
                $password_from_data_base = $row["password"]; // take from database password value.

                $decrypted = @openssl_decrypt($password_from_data_base, constant('cypherMethod'), $old_password, 0); //decrypt password encrypted with old password
                $encryptedPassword= @openssl_encrypt($decrypted, constant('cypherMethod'), $new_password, 0); //encrypt password with new password

                $update_sql = 'UPDATE password SET `password`= "'.$encryptedPassword.'" WHERE id = "'.$id.'";'; //update the row
                $this->insert($update_sql); // call the insert function to the database
            }
        } else {
            $_SESSION['info'] .= " There is some error with change your passwords in wallet";// save the session variable with feedback
        }
    }

// Function generating the hash value using the algorithm: SHA512. Arguments: password
    public  function hashPassword($password){
        $hashPassword = hash('sha512', $password);
        return $hashPassword;
    }

// A function that generates a hash value with a key, using the HMAC method. Arguments: password and salt
    public  function HMACPassword($password, $salt){
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

// Database introductory function - the argument is a SQL string
    public function insert($sql) {
        $feedback = "Something gone wrong";

        //mysqli_real_escape_string - function to create a allowed SQL string that can be used in a query.
// The specified string is encoded as an SQL string.
        if(mysqli_real_escape_string($this->mysqli,$sql)){
            if(mysqli_query($this->mysqli, $sql)==True){
                $feedback= "<span>Rekordy został dodany poprawnie</span>";
            }
            else {
                $feedback= "<span>Błąd nie udało się dodać nowego rekordu</span>";
            }
        }
        return $feedback;
    }

    public function select($sql){
        if($result = $this->mysqli->query($sql)){ //if select execute properly
            return $result;
        }else{
            return null; //if not
        }
    }

}

?>