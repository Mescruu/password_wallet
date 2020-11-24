<?php
session_start();// start the session

include_once('php/BD.php');// database class
include_once ('php/config.php');// database configuration file;
include_once ('php/commonFunction.php');// file with functions used in index.php and password_wallet.php

// create variables with no initial value
$password = $login = $hashType= $repeatPassword =  "";

$db = create_DB();//create db handler

$errors = [  // an array with errors
    "login" => "",
    "password" => "",
    "repeatPassword" => "",
    "hashType" => "",
];

$loginbox=true; // variable responsible for displaying the appropriate box

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if this is a POST request

    if (isset($_REQUEST["Login"]))  // request to login to the wallet
    {

        if (empty($_POST["login"])) { // check if the given "login" is empty. If true, write the appropriate error. If false, save the variable login
            $login = "";
            $errors['login'] = "Login is required";
        } else {
            $login = test_input($_POST["login"]);
        }

        if (empty($_POST["password"])) { //similar to the comment above
            $password = "";
            $errors['$password']  = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
        }

        $loginbox=true;

        if (nonerror($errors)) { // if there is no errors
            $user=$db->getUser($login);  //create an user with that login
            if($user==null){ // if there is no user in database with that data
                $loginError= "Error - There is no user with this login";
            }else{

                $errors['password']=$db->login($login, $password)."<br><hr>"; //call login function
            }
        }
    }

    if (isset($_REQUEST["unlock"])) { // request to remove ip block
        $loginbox=true;

        $errors['password']= "ip unlocked"."<br><hr>";
        $db->removeIp(); //call login function
        $_SESSION['failed_ip_counter']=0;
    }

    if (isset($_REQUEST["Register"])) { // request to register user to the wallet
        $loginbox=false; //display box with register form

        if (empty($_POST["login"])) { // check if the given "login" is empty. If true, write the appropriate error. If false, save the variable login
            $login = "";
            $errors['login'] = "Login is required";
        } else {
            $login = test_input($_POST["login"]);
        }

        if (empty($_POST["password"])) { //similar to the comment above
            $password = "";
            $errors['$password'] = "Login is required";
        } else {
            $password = test_input($_POST["password"]);
        }

        if (empty($_POST["repeatPassword"])) {  //similar to the comment above
            $repeatPassword = "";
            $errors['repeatPassword'] = "Login is required";
        } else {
            $repeatPassword = test_input($_POST["repeatPassword"]);
        }


        if (empty($_POST["hashType"])) { //similar to the comment above
            $hashType = "";
            $errors['hashType'] = "Hash type is required";
        } else {
            $hashType = test_input($_POST["hashType"]);
        }

        if($repeatPassword!=$password){  //check if given passwords are the same
            $errors['repeatPassword']  = "The passwords aren't the same";
        }

        if (nonerror($errors)) {  //if there is no errors
            $user=$db->getUser($login); //check if there is an user with that login
            if($user!=null){
                $errors['login']="There is user with this login. User another one!";
            }else{
                if($hashType=="SHA512"){  //set hash type
                    $hash=true;
                }else{
                    $hash=false;
                }
                $db->registerUser($login, $password, $hash, true);// true - means user registration / false - password change
            }
        }
       else{
            //echo var_dump($errors);
        }
    }
}


?>

<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Password Wallet</title>
    <meta name="author" content="Albert Woś">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>

    <link href="css/style.css" media="all" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <script src="js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

</head>
<body>
<main>
<h1 class="text-center p-5">
    Welcome to the Password Wallet!
</h1>
    <hr>
<div class="container p-1 w-50">
    <?php if(isset($_SESSION['info'])) echo '<h3 class="text-center text-dark alert-warning p-3">'.$_SESSION['info']."</h3>"; //display errors?>

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">

        <div class="carousel-inner" data-interval="false">
            <div class="carousel-item
            <?php
            if($loginbox)
                echo "active";
            ?>
        " data-interval="false" id="loginBox">
                <h1 class="p-5 text-center">Login</h1>
                <div class ="card-frame-index">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Login</h5>
                        <p class="card-text">Login to your password wallet.</p>
                        <hr>

                        <form action="index.php" method="post">
                            <input id="loginLogsCounter" name="loginLogsCounter" type="hidden" value="
                             <?php
                            //time = failed logs count * 1000ms

                            if (!isset($_SESSION['failed_logs_counter'])) {

                                $_SESSION['failed_logs_counter'] = 0;
                            }
                            if (!isset($_SESSION['failed_ip_counter'])) {

                                $_SESSION['failed_ip_counter'] = 0;
                            }



                            //take greater value of count
                            if($_SESSION['failed_logs_counter']>$_SESSION['failed_ip_counter']){
                                $counter = $_SESSION['failed_logs_counter'];
                            }else{
                                $counter = $_SESSION['failed_ip_counter'];
                            }
                            if($_SESSION['failed_ip_counter']<4){
                                if ($counter <2)
                                    echo 1000*0;

                                if ($counter == 2)
                                    echo 1000*5;

                                if ($counter == 3)
                                    echo 1000*10;

                                if ($counter >= 4)
                                    echo 1000*120;
                            }else{
                                echo 0;
                            }

                            ?>
                            ">


                            <div class="form-group">
                                <?php

                                if($errors['login']!=="")
                                    echo '<span class="text-danger">'.$errors['login']."</span>";
                                ?>
                                <label for="login">Login</label>
                                <input type="text" class="form-control" name="login" id="login" aria-describedby="Login" placeholder="Enter login">
                            </div>
                            <div class="form-group">
                                <?php
                                if($errors['password']!=="")
                                {
                                    if($errors['password']=="Ip is locked!"){
                                        echo '<span class="text-danger">'. $errors['password']."</span>";
                                        echo '<input type="submit" id="unlockSubmit" name="unlock" value="unlock ip" class="btn btn-dark w-25"><hr>';
                                    }else{
                                        echo '<span class="text-danger">'. $errors['password']."</span>";
                                    }
                                }
                                ?>
                                <?php
                                if(isset($_SESSION['failed_logs_counter'])) {
                                    if($_SESSION['failed_logs_counter']>=2){
                                        if(isset($_SESSION['failed_ip_counter'])){
                                            if($_SESSION['failed_ip_counter']<4){
                                                echo '<div id="registrationClosedText">Registration closes in <span id="time">00:00</span> minutes!</div>';
                                            }
                                        } else{
                                            echo '<div id="registrationClosedText">Registration closes in <span id="time">00:00</span> minutes!</div>';
                                        }
                                    }
                                }
                                ?>
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder="Enter password">
                            </div>

                            <script>
                            <?php
                            if(isset($_SESSION['failed_logs_counter'])) {
                               echo ' window.onload = function () {
                                    startTimer(document.getElementById("loginLogsCounter").value/1000, document.querySelector("#time"));
                                }';
                            }
                            ?>


                            function startTimer(duration, display) {

                                var timer = duration, minutes, seconds;
                                setInterval(function () {
                                    minutes = parseInt(timer / 60, 10)
                                    seconds = parseInt(timer % 60, 10);

                                    minutes = minutes < 10 ? "0" + minutes : minutes;
                                    seconds = seconds < 10 ? "0" + seconds : seconds;

                                    display.textContent = minutes + ":" + seconds;
                                        if(timer>=0) {
                                            timer--
                                            <?php
                                            if(isset($_SESSION['failed_logs_counter']))
                                                echo 'document.getElementById("loginSubmit").classList.add("disabled")';
                                            ?>


                                        }
                                        if (timer <= 0) {
                                            document.getElementById("loginSubmit").classList.remove("disabled");
                                            document.getElementById("loginSubmit").disabled=false;
                                            document.getElementById("registrationClosedText").style.display = "none";
                                        }
                                }, 1000);
                            }

                            </script>

                            <input type="submit" id="loginSubmit" name="Login" value="Login" class="btn btn-dark w-25"
                                <?php
                                if(isset($_SESSION['failed_logs_counter'])) {
                                    if($_SESSION['failed_logs_counter']>=2)
                                        echo 'disabled';
                                }
                                ?>
                            >

                        </form>
                    </div>
                </div>

                <div class="text-center p-5">
                    <a class="btn w-50 btn-dark m-auto nextButton" href="#carouselExampleIndicators" id="click"  role="button" data-slide="next"">
                    <span class="" id="text">Register &#8594;</span>
                    </a>
                </div>
            </div>

            </div>
            <div class="carousel-item
            <?php
            if(!$loginbox)
                echo "active";
            ?>
            " data-interval="false">
                <h1 class="p-5 text-center">Register</h1>

                <div class ="card-frame-index">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Register</h5>
                        <p class="card-text">Sing up to your password wallet.</p>

                        <hr>

                        <form action="index.php" method="post">
                            <div class="form-group">
                                <?php
                                if($errors['login']!=="")
                                    echo '<span class="text-danger">'.$errors['login']."<br></span>";
                                ?>
                                <label for="login">Login</label>
                                <input type="text" class="form-control" name="login" id="login" aria-describedby="Login" placeholder="Enter login">
                            </div>
                            <div class="form-group">
                                <?php
                                if($errors['password']!=="")
                                    echo '<span class="text-danger">'. $errors['password']."<br></span>";
                                ?>
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder="Enter password">
                            </div>
                            <div class="form-group">
                                <?php
                                if($errors['repeatPassword']!=="")
                                    echo '<span class="text-danger">'. $errors['repeatPassword']."<br></span>";
                                ?>
                                <label for="repeatPassword">Password</label>
                                <input type="password" class="form-control" name="repeatPassword" id="repeatPassword" aria-describedby="repeatPassword" placeholder="Enter password again">
                            </div>

                            <div class="form-group">
                                <label class="mr-sm-2" for="HashType">Hash Type</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="hashType">
                                    <option <?php if (isset($hashType) && $hashType=="SHA512") echo "selected";?> value="SHA512">SHA512</option>
                                    <option <?php if (isset($hashType) && $hashType=="MHAC") echo "selected";?> value="MHAC">MHAC</option>
                                </select>
                            </div>

                            <input type="submit" name="Register" value="Register" class="btn btn-dark w-25">
                        </form>

                    </div>
                </div>
                <div class="text-center p-5">
                    <a class="btn w-50 btn-dark m-auto nextButton" href="#carouselExampleIndicators" id="click"  role="button" data-slide="next"">
                    <span class="" id="text">Login &#8594;</span>
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
</body>
</html>
