<?php
session_start();


include_once('php/BD.php');
include_once ('php/config.php');//plik konfiguracyjny do bazy danych;
include_once ('php/commonFunction.php');//plik z typowymi funkcjami

$password = $login = $hashType= $repeatPassword =  "";

$errors = [  //zmienna przechowująca błędy
    "login" => "",
    "password" => "",
    "repeatPassword" => "",
    "hashType" => "",
];

$loginbox=false; //zmienna odpowiadająca za wyświetlanie odpowiedniego boxa

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_REQUEST["Login"]))
    {

        if (empty($_POST["login"])) {
            $login = "";
            $errors['login'] = "Login is required";
        } else {
            $login = test_input($_POST["login"]);
        }

        if (empty($_POST["password"])) {
            $password = "";
            $errors['$password']  = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
        }

        if (empty($_POST["hashType"])) {
            $hashType = "";
            $errors['$hashType'] = "Hash type is required";
        } else {
            $hashType = test_input($_POST["hashType"]);
        }


        //echo $login;
        //echo $password;
       // echo $loginbox;
        $loginbox=true;
        //echo $bd->select($typ, $gdzie, $poziom); //pobieranie danych z bazy danych


        if (nonerror($errors)) { //jeżeli nie ma zadnego błedu jeżeli elementy są puste

            $user=$db->getUser($login);
            if($user==null){
                $loginError="Nie ma takiego użytkownika!";
            }else{
                $user->showUserInfo();

               // echo "<hr> hash type ".$hashType;

                if($hashType=="SHA512"){
                    $hash=1;
                }else{
                    $hash=0;
                }
                $errors['login']=$db->login($login, $password, $hash);
            }
        }


    }

    if (isset($_REQUEST["Register"])) {
        $loginbox=false;

        if (empty($_POST["login"])) {
            $login = "";
            $errors['login'] = "Login is required";
        } else {
            $login = test_input($_POST["login"]);
        }

        if (empty($_POST["password"])) {
            $password = "";
            $errors['$password'] = "Login is required";
        } else {
            $password = test_input($_POST["password"]);
        }

        if (empty($_POST["repeatPassword"])) {
            $repeatPassword = "";
            $errors['repeatPassword'] = "Login is required";
        } else {
            $repeatPassword = test_input($_POST["repeatPassword"]);
        }


        if (empty($_POST["hashType"])) {
            $hashType = "";
            $errors['hashType'] = "Hash type is required";
        } else {
            $hashType = test_input($_POST["hashType"]);
        }

        if($repeatPassword!=$password){
            $errors['repeatPassword']  = "The passwords aren't the same";
        }

        //echo $login;
        //echo $password;
        //echo $repeatPassword;
        //echo $hashType;

        $loginbox=false;

        if (nonerror($errors)) { //jeżeli nie ma zadnego błedu jeżeli elementy są puste
            $user=$db->getUser($login); //sprawdzamy czy istnieje uer o takim loginie
            if($user!=null){
                $errors['login']="login jest zajęty!";
                //$user->showUserInfo();

            }else{
                if($hashType=="SHA512"){
                    $hash=true;
                }else{
                    $hash=false;
                }
                $db->registerUser($login, $password, $hash);
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

<div class="container p-1 w-50">
    <?php if(isset($_SESSION['info'])) echo '<h3 class="text-center text-dark alert-warning p-3">'.$_SESSION['info']."</h3>"; //wyświetlenie błedu?>

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">

        <div class="carousel-inner" data-interval="false">
            <div class="carousel-item
            <?php
            if($loginbox){
                echo "active";
            }
            ?>
" data-interval="false" id="loginBox">
                <h1 class="p-5 text-center">Login</h1>
                <div class ="card-frame">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Login</h5>
                        <p class="card-text">Login to your password wallet.</p>
                        <hr>

                        <form action="index.php" method="post">
                            <div class="form-group">
                                <?php
                                if($errors['login']!=="")
                                {
                                    echo '<span class="text-danger">'.$errors['login']."</span>";
                                }
                                ?>
                                <label for="login">Login</label>
                                <input type="text" class="form-control" name="login" id="login" aria-describedby="Login" placeholder="Enter login">
                            </div>
                            <div class="form-group">
                                <?php
                                if($errors['password']!=="")
                                {
                                    echo '<span class="text-danger">'. $errors['password']."</span>";
                                }
                                ?>
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder="Enter password">
                            </div>

                            <div class="form-group">
                                <label class="mr-sm-2" for="HashType">Hash Type</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="hashType">
                                    <option <?php if (isset($hashType) && $hashType=="SHA512") echo "selected";?> value="SHA512">SHA512</option>
                                    <option <?php if (isset($hashType) && $hashType=="MHAC") echo "selected";?> value="MHAC">MHAC</option>
                                </select>
                            </div>

                            <input type="submit" name="Login" value="Login" class="btn btn-dark w-25">
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
            if(!$loginbox) {
                echo "active";
            }
            ?>
            " data-interval="false">
                <h1 class="p-5 text-center">Register</h1>

                <div class ="card-frame">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Register</h5>
                        <p class="card-text">Sing up to your password wallet.</p>

                        <hr>

                        <form action="index.php" method="post">
                            <div class="form-group">
                                <?php
                                if($errors['login']!=="")
                                {
                                    echo '<span class="text-danger">'.$errors['login']."<br></span>";
                                }
                                ?>
                                <label for="login">Login</label>
                                <input type="text" class="form-control" name="login" id="login" aria-describedby="Login" placeholder="Enter login">
                            </div>
                            <div class="form-group">
                                <?php
                                if($errors['password']!=="")
                                {
                                    echo '<span class="text-danger">'. $errors['password']."<br></span>";
                                }
                                ?>
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder="Enter password">
                            </div>
                            <div class="form-group">
                                <?php
                                if($errors['repeatPassword']!=="")
                                {
                                    echo '<span class="text-danger">'. $errors['repeatPassword']."<br></span>";
                                }
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
