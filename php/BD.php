<?php

include_once('user.php');
include_once("config.php");

class BD {
    //const pepper = "6883589765f7e08e226dff0.01019947";

    public $mysqli;
    public function __construct($serwer,$user,$pass,$baza) { //utworzenie bazy danych
        $this->mysqli = new mysqli($serwer,$user,$pass,$baza);

        if($this->mysqli->connect_errno){
            printf("Nie udalo sie polaczenie  z serwerem: %s\n",$this->mysqli->connect_error);
            exit();
        }
        if($this->mysqli->set_charset("utf8")){}
    }

    function __destruct() {
        $this->mysqli->close();
    }

    public function getUser($login)
    {
        $sql= "select * from user where login='$login'";

        $result = $this->mysqli->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $user = new user($row["id"],  $row["login"], $row["password_hash"], $row["salt"], $row["isPasswordKeptAsHash"]);
            }
            return $user;

        } else {
            return null;
        }
    }
    public  function  createPartition($login, $password, $description, $web_address, $user_Id){

        $user_password = $_SESSION['password'];

        //wywołanie funkcji wprowadzającej do bazy
        $insert_sql = 'INSERT INTO `password` (`id`, `password`, `id_user`, `web_address`, `description`,`login`) VALUES (NULL, "'.$password.'", "'.$user_Id.'", "'.$web_address.'", "'.$description.'", "'.$login.'");';
        $this->insert($insert_sql);

        return "Position added";
    }

    public function getPartition($userId){

        $sql= "select * from password where id_user='$userId;'";

        $result = $this->mysqli->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $partitions[] = new partition($row["id"],  $row["password"], $row["id_user"], $row["web_address"], $row["description"], $row["login"]);
            }
            return $partitions; //oddaje listę zakładek.

        } else {
            return null;
        }
    }

    public  function  deletePosition($id){

        $sql= "DELETE from password where id='$id;'";

        if ($this->mysqli->query($sql) === TRUE) {
            return "Position removed"."\n";
        } else {
            return "Position was not removed". $this->mysqli->error;
        }

    }


    /* funkcja select
    public  function select($sql){

        $result = $this->mysqli->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo print_r($row);       // Print the entire row data
            }
        } else {
            echo "There is no results";
        }

    }
    */

    public  function login($login, $password, $keptAsHash){


        $user=$this->getUser($login);

        if($user!=null){
            if($keptAsHash==1)
            {
               @$loginPasswordHas = $this->hashPassword($password.$user->getSalt().constant(pepper)); //dołączenie stałej pepper z pliku config.

            }
            else{
                @$loginPasswordHas = $this->HMACPassword($password,$user->getSalt().constant(pepper));
                //  $passwordHash = $this->HMACPassword($password.$salt.BD::pepper); //pepper jako stała, która wcześniej była zadeklarowana jako //const pepper = "6883589765f7e08e226dff0.01019947";.
            }

            //sprawdzenie hashu
            if(hash_equals($user->getPassword_Hash(), $loginPasswordHas)){

                $_SESSION['login'] = $login;
                $_SESSION['info'] = "You are now logged in";
                $_SESSION['password'] = $password;

                header('location: password_wallet.php'); //przeniesienie na odpowiednią stronę


            }else{
                return "Hasło niepoprawne";
            }
        }else{
            return "Nie ma takiego użytkownika!";
        }
    }

    public  function registerUser($login, $password, $keptAsHash){


        //tworzenie soli
        $salt = substr(uniqid(mt_rand(), false), 0, 20); //utworzenie w funkcji uniqid ciągu 23 znaków, a następnie odcięcie 3 ostatnich (w bazie maksymalna długość soli to 20.
        /*
            //dodatkowe opcje do hashowania
            $options = [
                'salt' => $salt
            ];
            $passwordHash = password_hash("rasmuslerdorf", PASSWORD_BCRYPT, $options);
             $hashPassword = $this->hashPassword($password);
        */
  //      echo "<hr>".$password.$salt.BD::pepper;

       // echo @constant(pepper);  //@ukrycie warningów

        if($keptAsHash)
        { //jeżeli jest kodowane SHA512
            @$passwordHash = $this->hashPassword($password.$salt.constant(pepper)); //dołączenie stałej pepper z pliku config.
        }
        else{ //jeżeli jest kodowane MHAC
            @$passwordHash = $this->HMACPassword($password, $salt.constant(pepper));
            //  $passwordHash = $this->HMACPassword($password.$salt.BD::pepper); //pepper jako stała, która wcześniej była zadeklarowana jako //const pepper = "6883589765f7e08e226dff0.01019947";.
        }

        //wywołanie funkcji wprowadzającej do bazy
        $insert_sql = 'INSERT INTO `user` (`id`, `login`, `password_hash`, `salt`, `isPasswordKeptAsHash`) VALUES (NULL, "'.$login.'", "'.$passwordHash.'", "'.$salt.'", "'.$keptAsHash.'");';
        $this->insert($insert_sql);

        $_SESSION['login'] = $login;
        $_SESSION['info'] = "You are now logged in";
        $_SESSION['password'] = $password;

        header('location: password_wallet.php'); //przeniesienie na odpowiednią stronę
    }
/*     inna opcja hashu
       public  function hashPassword($password){
       $hashPassword =  password_hash($password, PASSWORD_DEFAULT);
       return $hashPassword;
    }
    */
    public  function hashPassword($password){
        $hashPassword = hash('sha512', $password);
       // echo "<hr> hasło zahaszowane 2: ".$hashPassword;

        return $hashPassword;
    }

    public  function HMACPassword($password, $salt){

        /* dokumentacja
            1.algo
            Name of selected hashing algorithm (i.e. "md5", "sha256", "haval160,4", etc..) See hash_hmac_algos() for a list of supported algorithms.

            2.data
            Message to be hashed.

            3.key
            Shared secret key used for generating the HMAC variant of the message digest.

            4.raw_output
            When set to TRUE, outputs raw binary data. FALSE outputs lowercase hexits.
         */

        $hashPassword =  hash_hmac('sha512', $password, $salt); //
        return $hashPassword;
    }

    public function insert($sql) { //funkcja insert
        if(mysqli_real_escape_string($this->mysqli,$sql)) //Ta funkcja służy do tworzenia dozwolonego ciągu SQL, którego można używać w instrukcji SQL. Podany ciąg jest kodowany jako łańcuch znaków SQL ze zmianą znaczenia, biorąc pod uwagę bieżący zestaw znaków połączenia.
        {
            if(mysqli_query($this->mysqli, $sql)==True){
                $feedback= "<span>Rekordy został dodany poprawnie</span>";     //pokazuje, czy dodałoo niby
            }
            else {
                $feedback= "<span>Błąd nie udało się dodać nowego rekordu</span>";
            }
        }
        return $feedback;
    }

    public function getRows($sql) { //funkcja pobierająca dane
        return mysqli_query($this->mysqli, $sql);
    }

    /*
    public function delete() //funkcja usuwająca
    {
        $sql = "DELETE FROM user";
        if ($this->mysqli->query($sql) === TRUE) {
            echo "Poprzednie rekordy zostały usunięte prawidłowo."."\n";
        } else {
            echo "Wystąpił błąd podczas usuwania rekordów: " . $this->mysqli->error;
        }
    }
    */
};
?>