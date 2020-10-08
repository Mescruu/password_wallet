<?php
session_start();

include_once('php/BD.php');
include_once ('php/config.php');//plik konfiguracyjny do bazy danych;
include_once ('php/commonFunction.php');//plik z typowymi funkcjami
include_once('php/partition.php'); //przegroda

$user=$db->getUser($_SESSION['login']);

$wallet =true;
$modal=false; //jezeli true włącz okno z formularze, jezeli false - nie

$password = $login = $description= $web_address = $id =  "";

$errors = [  //zmienna przechowująca błędy
    "login" => "",
    "password" => "",
    "description" => "",
    "web_address" => "",
];

if (!isset($_SESSION['login'])) { //jeżeli użytkownik nie jest zalogowany
    $_SESSION['info'] = "You must log in first";
    header('location: index.php');
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
                $user->showUserInfo();
                // echo "<hr> hash type ".$hashType;
                $_SESSION['info'] = $db->createPartition($login, $password, $description, $web_address, $user->getId()); //zwraca obiekt zakładki
                header('location:password_wallet.php');  //dzięki niemu nie dodaje się kolejna pozycja po odświerzeniu strony.
            }
        }else{
            $_SESSION['info'] = "Error - there is some problem with your data, check the window with form";
        }
    }

    if (isset($_REQUEST["Delete"])) //próba dodania nowej pozycji
    {
        $id = test_input($_POST["id"]);
        $_SESSION['info'] = $db->deletePosition($id);
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
                if($wallet){
                    echo "active";
                }
                ?>
" data-interval="false" id="loginBox">
                    <h1 class="p-5 text-center">Your Password Wallet</h1>
                    <div class ="card-frame">
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
                                            $partition->createPartition($i); //wyświetlenie zakładek
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

                        <div class="text-center p-5">
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
                    <h1 class="p-5 text-center">Your Password Wallet</h1>

                    <div class ="card-frame">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Change your password</h5>
                                <p class="card-text">Change your password and hash type.</p>

                                <hr>

                                <form action="password_wallet.php" method="post">
                                    <input type="submit" name="Change" value="Change" class="btn btn-dark w-25 m-1">
                                </form>

                            </div>
                        </div>

                        <div class="text-center p-5">
                            <a class="btn w-50 btn-dark m-auto nextButton" href="#carouselExampleIndicators" id="click"  role="button" data-slide="next"">
                            <span class="" id="text">Wallet &#8594;</span>
                            </a>
                        </div>


                    </div>

                </div>
            </div>

            <form action="password_wallet.php" method="GET" class="text-center">
                <input type="submit" name="Logout" value="Logout" class="btn btn-dark w-50 m-auto">
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
