<?php
session_start();

include_once('php/BD.php');
include_once ('php/config.php');//plik konfiguracyjny do bazy danych;
include_once ('php/commonFunction.php');//plik z typowymi funkcjami
include_once('php/partition.php'); //przegroda

$user=$db->getUser($_SESSION['login']);

$wallet =true;
$modal=false; //jezeli true włącz okno z formularze, jezeli false - nie



$password = $login = $description= $web_address = $id = $decrypt = $password_new = $repeatPassword_new = $hashType_new = $old_password = "";

$errors = [  //zmienna przechowująca błędy
    "login" => "",
    "password" => "",
    "description" => "",
    "web_address" => "",
    "password_new" => "",
    "repeatPassword_new" => "",
    "hashType_new" => "",
    "old_password" => ""
];

if (!isset($_SESSION['login'])) { //jeżeli użytkownik nie jest zalogowany
    $_SESSION['info'] = "You must log in first";
    //header('location: index.php');
}

if (isset($_GET['Logout'])) {
    session_destroy();
    unset($_SESSION['login']);
    header("location: index.php");
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_REQUEST["Save"])) //próba dodania nowej pozycji
    {

        if (empty($_POST["login"])) {
            $login = "";
            $errors['login'] = "Login is required";
        } else {
            $login = test_input($_POST["login"]);
        }
        if (empty($_POST["password"])) {
            $password = "";
            $errors['password'] = "Login is required";
        } else {
            $password = test_input($_POST["password"]);
        }
        $description = test_input($_POST["description"]);

        if (empty($_POST["web_address"])) {
            $web_address = "";
            $errors['web_address'] = "Web address is required";
        } else {
            $web_address = test_input($_POST["web_address"]);
        }

        if (nonerror($errors)) { //jeżeli nie ma zadnego błedu jeżeli elementy są puste

            if($user==null){
                $_SESSION['info'] = "Error - there is no user";
            }else{
              //  $user->showUserInfo();
                // echo "<hr> hash type ".$hashType;
                $_SESSION['info'] = $db->createPartition($login, $password, $description, $web_address, $user->getId()); //zwraca obiekt zakładki
            }
        }else{
            $_SESSION['info'] = "Error - there is some problem with your data, check the window with form";
        }
    }

    if (isset($_REQUEST["Delete"])) //próba dodania nowej pozycji
    {
        $id = test_input($_POST["id"]);
        $_SESSION['info'] = $db->deletePosition($id);
        header('location:password_wallet.php');  //dzięki niemu nie dodaje się kolejna pozycja po odświerzeniu strony.

    }

    if (isset($_REQUEST["Show"])) //próba dodania nowej pozycji
    {

        $id = test_input($_POST["id"]);
        $_SESSION['id'] = $id;
        $decrypt = $db->decryptPassword($id);
    }

    if (isset($_REQUEST["Hide"])) //próba dodania nowej pozycji
    {
        $id = test_input($_POST["id"]);
        $_SESSION['id'] = $id;
        $decrypt = "";
    }

    if (isset($_REQUEST["Change"])) {
        $wallet =false;

        echo "admin";

        if (empty($_POST["old_password"])) {
            $old_password = "";
            $errors['old_password'] = "Password is required";
        } else {
            $old_password = test_input($_POST["old_password"]);
        }

        if (empty($_POST["password_new"])) {
            $password_new = "";
            $errors['password_new'] = "Password is required";
        } else {
            $password_new = test_input($_POST["password_new"]);
        }

        if (empty($_POST["repeatPassword_new"])) {
            $repeatPassword_new = "";
            $errors['repeatPassword_new'] = "Repeat password is required";
        } else {
            $repeatPassword_new = test_input($_POST["repeatPassword_new"]);
        }


        if (empty($_POST["hashType_new"])) {
            $hashType_new = "";
            $errors['hashType_new'] = "Hash type is required";
        } else {
            $hashType_new = test_input($_POST["hashType_new"]);
        }

        if ($repeatPassword_new != $password_new) {
            $errors['repeatPassword'] = "The passwords aren't the same";
        }

        //echo $login;
        //echo $password;
        //echo $repeatPassword;
        //echo $hashType;

        if (nonerror($errors)) { //jeżeli nie ma zadnego błedu jeżeli elementy są puste
            if($old_password==$_SESSION['password']){
                $user = $db->getUser($_SESSION['login']); //sprawdzamy czy istnieje uer o takim loginie
                if ($user == null) {
                    $errors['info'] = "Uoops, we found some error!";
                  $user->showUserInfo();
                } else {
                    if ($hashType_new == "SHA512") {
                        $hash = true;
                    } else {
                        $hash = false;
                    }
                    $db->registerUser($_SESSION['login'], $password_new, $hash, false); //true - oznacza pierwsze rejestrowanie użytkownika / false zmiana hasła
                }
            }else{
                $_SESSION['info'] = "Your password is not correct!";
            }
        }else{
            var_dump($errors);
        }
    }

    if(isset($_SESSION['info'])){
        if($_SESSION['info']=="Your password has changed" ) //jeżeli udało się zmienić hasło
            $wallet=false;
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


    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/style.css" media="all" rel="stylesheet" type="text/css"/>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/copy.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> <!-- dodanie ajaxa -->

    <?php
    if (isset($_SESSION['id'])) { //jeżeli jest zmienna sesyjna ID wtedy przenieś do aktywnego pola
        echo '
    <script>
    function scroll(id) {
                  var elmnt = document.getElementById("collapse"+id);
                 elmnt.scrollIntoView();
    }
    </script>
        ';
    }
    ?>

</head>
<body>
<main>

    <div class="container p-1 w-50">
        <?php if(isset($_SESSION['info'])) echo '<h3 class="text-center text-dark alert-warning p-3 position-absolute w-50">'.$_SESSION['info']."</h3>"; //wyświetlenie błedu ?>

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">

            <div class="carousel-inner" data-interval="false">
                <div class="carousel-item
            <?php
                if($wallet){
                    echo "active";
                }
                ?>
" data-interval="false" id="loginBox">
                    <h1 class="p-5 text-center mt-4">Welcom <?php echo $_SESSION['login']; ?> to your Password Wallet</h1>
                    <div class ="card-frame-password_wallet">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Password Wallet</h5>
                                <p class="card-text">Check and add new password and websites to your password wallet.</p>
                                <hr>
                                <div id="accordion" class="wallet pl-3">

                                    <?php
                                    $partitions = $db->getPartition($user->getId()); //pobranie zakładek
                                    $i=0;
                                    if($partitions!=null){
                                        foreach($partitions as $partition) {
                                            $i++;
                                            if (isset($_SESSION['id'])) {
                                                if ($partition->getId() == $_SESSION['id']) //jezeli jest to zakładka na której działamy
                                                {
                                                    $partition->setActive(true); //jezeli jest to konkretna zakładka ustaw ją jako aktywna
                                                    $partition->createPartition($i, $decrypt); //wyświetlenie zakładek
                                                    echo '<script> scroll('.$i.'); </script>';

                                                }else{
                                                    $partition->createPartition($i, ""); //wyświetlenie zakładek
                                                }
                                            }else{
                                                $partition->createPartition($i, ""); //wyświetlenie zakładek
                                            }
                                        }
                                    }else{
                                        echo '<h3 class="mt-5 pt-5"> Add your first position!</h3>';
                                    }

                                    ?>

                                </div>
                                <hr>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#addForm">
                                    Add new posistion
                                </button>

                            </div>
                        </div>

                        <div class="text-center p-3">
                            <a class="btn w-50 btn-dark m-auto nextButton" href="#carouselExampleIndicators" id="click"  role="button" data-slide="next"">
                            <span class="" id="text">Change Password &#8594;</span>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="carousel-item
            <?php
                if(!$wallet) {
                    echo "active";
                }
                ?>
            " data-interval="false">
                    <h1 class="p-5 text-center  mt-4""><?php echo $_SESSION['login']; ?>, change your password to the wallet </h1>

                    <div class ="card-frame-password_wallet">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Change your password</h5>
                                <p class="card-text">Change your password and hash type.</p>

                                <hr>

                                <form action="password_wallet.php" method="post">

                                    <div class="form-group">
                                        <?php
                                        if($errors['old_password']!=="")
                                        {
                                            echo '<span class="text-danger">'. $errors['old_password']."</span>";
                                        }
                                        ?>
                                        <label for="old_password">Password</label>
                                        <input type="password" class="form-control" name="old_password" id="old_password" aria-describedby="password" placeholder="Enter current password">
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        if($errors['password_new']!=="")
                                        {
                                            echo '<span class="text-danger">'. $errors['password_new']."</span>";
                                        }
                                        ?>
                                        <label for="password_new">Password</label>
                                        <input type="password" class="form-control" name="password_new" id="password_new" aria-describedby="password" placeholder="Enter new password">
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        if($errors['repeatPassword_new']!=="")
                                        {
                                            echo '<span class="text-danger">'. $errors['repeatPassword_new']."<br></span>";
                                        }
                                        ?>
                                        <label for="repeatPassword_new">Password</label>
                                        <input type="password" class="form-control" name="repeatPassword_new" id="repeatPassword_new" aria-describedby="repeatPassword" placeholder="Enter new password again">
                                    </div>

                                    <div class="form-group">

                                        <?php
                                        if($errors['hashType_new']!=="")
                                        {
                                            echo '<span class="text-danger">'. $errors['hashType_new']."<br></span>";
                                        }
                                        ?>

                                        <label class="mr-sm-2" for="HashType">Hash Type</label>
                                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="hashType_new">
                                            <option <?php if (isset($hashType) && $hashType=="SHA512") echo "selected";?> value="SHA512">SHA512</option>
                                            <option <?php if (isset($hashType) && $hashType=="MHAC") echo "selected";?> value="MHAC">MHAC</option>
                                        </select>
                                    </div>

                                    <input type="submit" name="Change" value="Change" class="btn btn-dark w-25 m-1">
                                </form>

                            </div>
                        </div>

                        <div class="text-center p-3">
                            <a class="btn w-50 btn-dark m-auto nextButton" href="#carouselExampleIndicators" id="click"  role="button" data-slide="next"">
                            <span class="" id="text">Wallet &#8594;</span>
                            </a>
                        </div>


                    </div>

                </div>
            </div>

            <form action="password_wallet.php" method="GET" class="text-center mt-5">
                <input type="submit" name="Logout" value="Logout" class="btn btn-outline-dark w-25 m-auto">
            </form>
        </div>

    </div>

</main>
<?php
echo $modal?>
<!-- Modal -->
<div class="modal fade" id="addForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">New position</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="password_wallet.php" method="post">
               <div class="modal-body">

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
                       <?php
                       if($errors['web_address']!=="")
                       {
                           echo '<span class="text-danger">'.$errors['web_address']."</span>";
                       }
                       ?>
                       <label for="web_address">Web address</label>
                       <input type="text" class="form-control" name="web_address" id="web_address" aria-describedby="web_address" placeholder="Enter web address">
                   </div>
                   <div class="form-group">
                       <?php
                       if($errors['description']!=="")
                       {
                           echo '<span class="text-danger">'. $errors['description']."</span>";
                       }
                       ?>
                       <label for="description">Description</label>
                       <input type="text" class="form-control" name="description" id="description" aria-describedby="description" placeholder="Enter description">
                   </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light w-25" data-dismiss="modal">Close</button>
                    <input type="submit" name="Save" value="Save" class="btn btn-dark w-25">
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>

<?php if(isset($_SESSION['info'])) $_SESSION['info']=null  ?>
