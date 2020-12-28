<?php
include_once('user.php');
include_once("config.php"); // configuration constants;
include_once("DB_statics.php"); // functions that could be static in DB class;

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

//get function id from exists or create new and recall function.
public function getFunctionID($name){
    //get function name and select id
    $sql_call= "select id from function where function_name='$name'";

    // execute the query
    $result = $this->select($sql_call);

    // if there is such a record
    if ($result!=null&&$result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $id = $row["id"]; // create a user object with the database fetched data.
        }
        return $id; // return the id of function object
    } else {

        //if there is no record like that - add new function name to database
        $insert_function_sql = 'INSERT INTO `function` (`id`, `function_name`, `description`) VALUES (NULL, '.$name.', "there is no description")';
        $this->insert($insert_function_sql);

        //get id from database again after adding function name to the database.

            //get function name and select id
            $sql_call= "select id from function where function_name='$name'";

            // execute the query
            $result = $this->select($sql_call);

        if ($result!=null&&$result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $id = $row["id"]; // create a user object with the database fetched data.
            }
            return $id;
        }else{
            return NULL;
        }
    }

}

//Register record when particular functions was called.
public function registerFunctionCall($name, $user_id){

    $function_id = $this->getFunctionID($name);
   // $current_time = date('Y-m-d H:i:s');

    if($function_id != NULL){
        $insert_sql = 'INSERT INTO `function_run` (`id`, `id_user`, `time`, `id_function`) VALUES (NULL, '.$user_id.', current_timestamp(), '.$function_id.')';
        $this->insert($insert_sql);

        return "Record added!";
    }
    else{
        return "Error! There is problem with register function calling.";
    }
}

//show all logs of user
public function showLogsOfFunctions(){

        $user = $this->getUser($_SESSION['login']);
    //register function call with function name from var_dump function and user id

    // Query the record in the table "user" with the given login
    $sql= 'select fr.id, fr.time, f.function_name, f.description from function_run fr
            INNER JOIN function f
            ON f.id = fr.id_function
            where fr.id_user='.$user->getId().' ORDER BY 2 DESC';

    //empty string
    $table="";
    // execute the query
    $result = $this->select($sql);

    // if there is such a record
    if ($result!=null&&$result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $table .= "<tr><td>".$row["id"]."</td><td>". $row["time"]."</td><td>".$row["function_name"]."</td><td>". $row["description"]."</td></tr>";
        }
        return $table; // return the table rows
    } else {
        return "null";// return null if there is no data.
    }

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
            return "null";// return null if the user with the given login does not exist.
        }
    }

    public  function  createPartition($login, $password, $description, $web_address, $user_Id){

        //register function call with function name from var_dump function
        $this->registerFunctionCall(__FUNCTION__, $user_Id);

        // encrypt the password using the encryption method in the config file and the user's login. 1 means OPENSSL_ZERO_PADDING
        $encryptedPassword= @openssl_encrypt($password, constant('cypherMethod'), constant('pepper').$_SESSION['login'], 0);

        // call the insert function to the database
        $insert_sql = 'INSERT INTO `password` (`id`, `password`, `id_user`, `web_address`, `description`,`login`) VALUES (NULL, "'.$encryptedPassword.'", "'.$user_Id.'", "'.$web_address.'", "'.$description.'", "'.$login.'");';
        $this->insert($insert_sql);

        //feedback
        return "Position added";

    }

    //function to edit partition
    public  function  editPartition($id, $login, $password, $description, $web_address, $user_Id){
        //register function call with function name from var_dump function
        $this->registerFunctionCall(__FUNCTION__, $user_Id);

        // encrypt the password using the encryption method in the config file and the user's login. 1 means OPENSSL_ZERO_PADDING
        $encryptedPassword= @openssl_encrypt($password, constant('cypherMethod'), constant('pepper').$_SESSION['login'], 0);

        // call the insert function to the database
        $update_sql = '
        UPDATE `password`
        SET `password` = "'.$encryptedPassword.'", `id_user` = "'.$user_Id.'", `web_address` = "'.$web_address.'", `description` = "'.$description.'", `login` = "'.$login.'"
        WHERE id = '.$id.';
        ';

        $this->insert($update_sql);

        //feedback
        return "Position edited";
    }

// Get the appropriate partition. argument: the user id
    public function getPartition($userId){
        //register function call with function name from var_dump function
        $this->registerFunctionCall(__FUNCTION__, $userId);

    // SQL query for tabs with passwords of the given user
        $sql= "
           SELECT distinct * FROM password p
            WHERE p.id in (SELECT id_password FROM sharing WHERE id_user_taking = ".$userId." OR id_user_giving = ".$userId.")
                OR p.id_user = ".$userId;

        // execute the query
        $result = $this->select($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {

                //if user is owner of that password
                $sharedOrNot = false;
                //if password was shared to the user
                if($row["id_user"]!=$userId){
                    $sharedOrNot = true;
                }

                $partitions[] = new partition($row["id"],  $row["password"], $row["id_user"], $row["web_address"], $row["description"], $row["login"], $sharedOrNot);
            }
            return $partitions; // return the array of partition.

        } else {
            return null;
        }
    }

// Function that removes a record from the "password" table with the given id. Item id.
    public  function  deletePosition($id){
        $user = $this->getUser($_SESSION['login']);
        //register function call with function name from var_dump function and user id
        $this->registerFunctionCall(__FUNCTION__, $user->getId());

        if($this->checkifuserisowner($id)){

            // Query removing the item from the portfolio and sharing
            $sql= "DELETE from sharing where id_password='$id;'";
            $sql2= "DELETE from password where id='$id;'";

// SQL execution
            $this->mysqli->query($sql);

// SQL execution
            if ($this->mysqli->query($sql2) === TRUE) {
                return "Position removed"."\n";
            } else {
                return "Position was not removed". $this->mysqli->error;
            }
        }else{
            return "You are not an owner!"."\n";

        }
    }

    //check if user is password owner
    public function checkifuserisowner($id){

        $user = $this->getUser($_SESSION['login']);
        //register function call with function name from var_dump function and user id
        $this->registerFunctionCall(__FUNCTION__, $user->getId());

        //take password owner login.
        $sql = '
        SELECT lower(u.login) as login FROM `password` p 
            INNER JOIN user u
            ON p.id_user = u.id
        WHERE p.id = '.$id.'
        ';
        $result = $this->select($sql);

        //if logins are the same return true (user is owner)
        if ($result!=null && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
               if( $_SESSION['login']==$row["login"]){
                   return true;
               }else{
                   return false;
               }
            }
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

        $decryptString = $this->combine_user_login($id);

//caling decrypt function //passwords are decrypted using user login
        $decrypted = returnDecryptPassword($password, $decryptString);

// Returns the decrypted password
        return $decrypted;
    }

    public function removeIp(){


        $ip=getUserIp();
        $sql ="DELETE FROM ips WHERE ip='$ip'";
        return $this->select($sql);
    }

//function responsible for  return last time of trying login
public function getLastUserLoginTime($user_id){
    $sql= "select max(`time`) as time from logs where id_user='$user_id'";
    $result = $this->select($sql);
    $time_of_last_login="";

// get the time from the database
    if ($result!=null && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $time_of_last_login = $row["time"];
        }
    } else {
        return null;// in case there is no such record
    }

    return $time_of_last_login;
}

// Function responsible for adding to database count of ip tries to login
    public function put_ip_tries($addone){
        if(!isset($_SESSION['failed_ip_counter'])){
            $_SESSION['failed_ip_counter'] = 0;
        }

        $ip = getUserIp();

        $sql= "select `count_of_failed` from ips where ip='$ip'";
        $result = $this->select($sql);
        $count_of_failed=0;

// get the count of trying from the database
        if ($result!=null && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $count_of_failed = intval($row["count_of_failed"]);
            }

            if($addone){
                //add +1 try to count of failed
                $count_of_failed++;
                $_SESSION['failed_ip_counter'] = $count_of_failed;

            }else{
                //reset count of failed
                $count_of_failed=0;
                $_SESSION['failed_ip_counter'] = 0;

            }
            //if count of failed try of login on current ip is greater than 3 block that ip address
            if($count_of_failed>3){
                //update record
                $block = "lock";
                $sql= "UPDATE ips  SET block = '$block' WHERE ip = '$ip'";
                $result = $this->insert($sql);
            }
            //update record
            $sql= "UPDATE ips  SET count_of_failed = '$count_of_failed' WHERE ip = '$ip'";
            $result = $this->insert($sql);
        } else {
            // in case there is no such record add one
        if($addone){
            $count_of_failed = 1;
            $sql= "INSERT INTO ips (id_ips, ip, count_of_failed) VALUES (null, '$ip', 1)";
        }else{
            $count_of_failed = 0;
            $sql= "INSERT INTO ips (id_ips, ip, count_of_failed) VALUES (null, '$ip', 0)";
        }

        $result = $this->insert($sql);
        //var_dump($result);
        }

        return $count_of_failed;
    }

 // Function responsible for return count of ip tries to login from database
    public  function get_ip_lock(){
        $ip = getUserIp();

        $sql= "select `block` from ips where ip='$ip'";


        $result = $this->select($sql);
        $lock="unlock";
        $lock_boolean = false;

// get the count of trying from the database or is the ip locked
        if ($result!=null && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $lock = $row["block"];

            }
        }

        if($lock == "unlock"){
            $lock_boolean=false;
        }else{
            $lock_boolean=true;
        }

        return $lock_boolean;
    }

// Function responsible for user login. Arguments: user login, password and the way in which his password was hashed.
    public  function login($login, $password){
// create a user with a given login
        $user=$this->getUser($login);

        if($this->get_ip_lock()==false){ // if ip is not lock

            if($user!="null"){ //if user with that login exist

                //take last user login time
                $time_of_last_login = $this->getLastUserLoginTime($user->getId());

                if(properTime($time_of_last_login,date('Y-m-d H:i:s'), $_SESSION['failed_logs_counter'])){// if the user with the given login exists and time of last login is properly
                    if($user->getIsPasswordKeptAsHash()==1)// if encoded with SHA512
                    {
                        @$loginPasswordHas = hashPassword($password.$user->getSalt().constant('pepper')); // call SHA512 with password from the form and combined salt and pepper from config.
                    }
                    else{//jeżeli jest kodowane MHAC
                        @$loginPasswordHas = HMACPassword($password,$user->getSalt().constant('pepper')); // call the HMAC function with the password from the form and the salt and pepper combined
                    }

                    //sprawdzenie hashu
                    if(hash_equals($user->getPassword_Hash(), $loginPasswordHas)){

                        $_SESSION['login'] = $login;
                        $_SESSION['info'] = "You are now logged in";
                        $_SESSION['password'] = $password;

                        $_SESSION['mode']='read-mode'; //enter with lock mode

                        //return appropriate query and insert that to database
                        $this->insert(login_result(true, $user->getId(), getUserIp()));
                        $this->setLogs($user->getId());

                        $_SESSION['failed_logs_counter'] = 0;

                        //reset count of ip trying
                        $this->put_ip_tries(false);

                        header('location: password_wallet.php'); // transfer to the appropriate page
                    }else{
                        //return appropriate query and insert that to database
                        $this->insert(login_result(false, $user->getId(), getUserIp()));

                        //$this->setLogs($user->getId());

                        $this->put_ip_tries(true);

                        //the limit reached
                        if($_SESSION['failed_ip_counter']>=4){
                            return "unlock ip!";
                        }else{
                            return "Wrong password";
                        }
                    }
                }else{ // if there is no such user
                    $this->insert(login_result(true, $user->getId(), getUserIp()));

                    $this->put_ip_tries(true);

                    return "Time isn't left!";
                }
            }else{
                $this->put_ip_tries(true);
                return "There is no user with that login!";
            }
        }else{
            //if user clear cookies set them
            $_SESSION['failed_ip_counter'] = 4;

            return "unlock ip!";
        }
    }

    public function setLogs($user_id){

        // Query the record in the table "user" with the given login
        $sql= "SELECT result, max(time) as time FROM `logs` WHERE id_user = ".$user_id." GROUP BY result";

        // execute the query
        $result = $this->select($sql);

        // if there is such a record
        if ($result!=null&&$result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if($row["result"]=='failed'){
                    $failed_date = $row["time"];
                }else{
                    $success_date = $row["time"];
                }
            }

            $_SESSION['login_log_failed'] = $failed_date;
            $_SESSION['login_log_successful'] = $success_date;
        }

    }

// function for creating a new user and changing the password
    public  function registerUser($login, $password, $keptAsHash, $register){
        // salt generating
        $salt = substr(uniqid(mt_rand(), false), 0, 20); // create a string of 23 characters in the uniqid function, and then cut off the last 3, because the maximum salt length in the database is 20.

        if($keptAsHash)
        { // if it is hashing with SHA512
            @$passwordHash =hashPassword($password.$salt.constant('pepper')); // include the constant pepper from config.
            $keptAsHash=1;
        }
        else{ // if it is hashing with HMAC
            @$passwordHash = HMACPassword($password, $salt.constant('pepper'));// combine salt and pepper for hash_hmac as key
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
    }

    public function share($UserLogin, $UserPassword, $otherLogin, $id){

        //check if user know passes
        if($UserLogin==$_SESSION['login'] && $UserPassword==$_SESSION['password']){
            $user_giving=$this->getUser($_SESSION['login']);
            $user_taking=$this->getUser($otherLogin);

            if($user_taking!="null"){ //if user with that login exist

                $select_sql = 'SELECT * FROM `sharing` WHERE `id_user_giving`="'.$user_giving->getId().'" AND `id_user_taking` ="'.$user_taking->getId().'" AND `id_password`="'.$id.'"';
                //echo  $select_sql;

                if($user_taking->getId()!=$user_giving->getId()){
                    //check if there is no sharing like this and giving user id is not equal taking user id
                    if(($this->select($select_sql))->num_rows == 0){

                        //echo $insert_sql;

                        //change sharing password code method
                        $this->changePasswordsInDataBase($id, $user_taking->getLogin()); //change giving passwords decrypt string

                        //return information if task complete
                        $insert_sql = 'INSERT INTO `sharing` (`id_user_giving`, `id_user_taking`, `id_password`) VALUES ("'.$user_giving->getId().'", "'.$user_taking->getId().'", "'.$id.'");';
                        $this->insert($insert_sql);

                        return "Access granted!";

                    }else{
                        return "Access was  granted earlier!";
                    }
                }else{
                    return "You can not grant access to yourself!";
                }
            }else{
                //return error when something goes wrong
                return "There is no user with given Login!";
            }

        }else{
            return "Your login or password is not correct!";

        }

    }

    public function changePasswordsInDataBase($id, $new_user_login){ //id of  password and user login that get access to password

        $old_logins = $this->combine_user_login($id);
        $new_logins = $old_logins.$new_user_login; //add new user login to string that is used to code password

        //query allowing to take sharing password id and password from the database
        $sql= "select id, password from password WHERE `id`=".$id;

        // execute the query
        $result = $this->select($sql);

        // if there is such a record
        if ($result!=null && $result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $id = $row["id"]; //take from database itd value
                $password_from_data_base = $row["password"]; // take from database password value.

                $decrypted = @openssl_decrypt($password_from_data_base, constant('cypherMethod'), $old_logins, 0); //decrypt password encrypted with old password
                $encryptedPassword= @openssl_encrypt($decrypted, constant('cypherMethod'), $new_logins, 0); //encrypt password with new password

                $update_sql = 'UPDATE password SET `password`= "'.$encryptedPassword.'" WHERE id = "'.$id.'";'; //update the row
                $this->insert($update_sql); // call the insert function to the database
            }
        } else {
            $_SESSION['info'] .= " There is some error with change your passwords in wallet";// save the session variable with feedback
        }
    }

    public function combine_user_login($id){

        $select_query = '
                        SELECT u.id, u.login FROM sharing s 
                        INNER JOIN user u 
                        ON s.id_user_taking = u.id
                        WHERE s.id_password='.$id.'
                        ORDER BY u.id
                        ';

        $result = $this->select($select_query);

        //on start $string using to code is pepper + logins user that share password.
        $logins=constant('pepper').$_SESSION['login'];

        if ($result!=null && $result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $logins.= $row["login"]; //take from database login value
            }
        }

        return $logins;
        //pobranie loginow uzytkownikow, ktorzy maja dostep do danego hasła i zwrocenie polaczanych wzgledem id pozycji loginow
        //do pieprzu i loginu uzytkownika ktory udostepnia dodaj loginy uzytkownikow ktorym został udostepnione hasło
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