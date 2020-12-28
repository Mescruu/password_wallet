<?php
session_start();// start the session

include_once('php/BD.php');// database class
include_once ('php/config.php');// database configuration file;
include_once ('php/commonFunction.php');// file with functions used in index.php and password_wallet.php
include_once('php/partition.php'); //partition class


$wallet =true; // if true show window with wallet, if false - window with password change

$db = create_DB();//create db handler

// create variables with no initial value
$password = $login = $description= $web_address = $id = $decrypt = $password_new = $repeatPassword_new = $hashType_new = $old_password = "";

$errors = [  // an array with errors
    "login" => "",
    "password" => "",
    "description" => "",
    "web_address" => "",
    "password_new" => "",
    "repeatPassword_new" => "",
    "hashType_new" => "",
    "old_password" => ""
];

if (!isset($_SESSION['login'])) { // if the user is not logged in
    $_SESSION['info'] = "You must log in first";
    header("location: index.php"); // redirect to the start page
}
    //if there is no session with key mode
    if(isset($_SESSION['mode'])==false){
        $_SESSION['mode'] = 'read-mode';
    }

$user=$db->getUser($_SESSION['login']);


if (isset($_GET['Logout'])) { // if user logs out
    session_destroy();//close session
    unset($_SESSION['login']); // remove the session variable "Login"
    unset($_SESSION['password']); // remove the session variable "Password"

    header("location: index.php"); //redirect to the start page
}

    if (isset($_GET["mode"])) // request to change lock mode to opposite
    {
                   if(isset($_SESSION['mode'])){
                       if($_SESSION['mode']=='read-mode'){
                           $_SESSION['mode'] = 'modify-mode';
                       }
                       else{
                           $_SESSION['mode'] = 'read-mode';
                       }
                   }else{
                       $_SESSION['mode'] = 'read-mode';
                   }
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if this is a POST request

    if (isset($_REQUEST["Save"])) // request to create  new partition to the wallet
    {
        if (empty($_POST["login"])) { // check if the given "login" is empty. If true, write the appropriate error. If false, save the variable login
            $login = "";
            $errors['login'] = "Login is required";
        } else {
            $login = test_input($_POST["login"]);
        }
        if (empty($_POST["password"])) {//similar to the comment above
            $password = "";
            $errors['password'] = "Login is required";
        } else {
            $password = test_input($_POST["password"]);
        }
        $description = test_input($_POST["description"]); //save the website description

        if (empty($_POST["web_address"])) { // check if the given "web_address" is empty. If true, write the appropriate error. If false, save the variable web_address
            $web_address = "";
            $errors['web_address'] = "Web address is required";
        } else {
            $web_address = test_input($_POST["web_address"]);
        }

        if (nonerror($errors)) { // if there is no errors
            if($user==null){ // if there is no user in database with that data
                $_SESSION['info'] = "Error - there is no user";
            }else{
                // create a partition with the following data: login to that website, password, website description, link, user id.
                $_SESSION['info'] = $db->createPartition($login, $password, $description, $web_address, $user->getId()); // returns information about task realization
                header('location:password_wallet.php');  // thanks to it, another partition is not added after refreshing the page.
            }
        }else{
            $_SESSION['info'] = "Error - there is some problem with your data, check the window with form"; // if there are any errors with data given to the form
        }
    }

    if (isset($_REQUEST["Delete"])) // request to delete the partition
    {
        if(isset($_SESSION['mode'])){
            if($_SESSION['mode']=='modify-mode'){
               // echo "delete";
                $id = test_input($_POST["id"]);
                $_SESSION['info'] = $db->deletePosition($id);
                header('location:password_wallet.php');
            }

        }
    }

    if (isset($_REQUEST["Show"])) //show a password
    {
        $id = test_input($_POST["id"]);
        $_SESSION['id'] = $id;
        $decrypt = $db->decryptPassword($id); //call the password decrypt function
    }

    if (isset($_REQUEST["Hide"])) // clear a decrypt variable- If decrypt variable is empty application shows user an asterisk ****
    {
        $id = test_input($_POST["id"]);
        $_SESSION['id'] = $id;
        $decrypt = "";
    }

    if (isset($_REQUEST["Access"])) {  // request to change user password

        if (!empty($_POST["Userlogin"]) && !empty($_POST["Password"]) && !empty($_POST["Otherlogin"])) {  // check if the given "login" is empty. If true, write the appropriate error. If false, save the variable old_password
            $userLogin = test_input($_POST["Userlogin"]);
            $userPassword = test_input($_POST["Password"]);
            $otherlogin = test_input($_POST["Otherlogin"]);

            $id = $_POST['id'];

            $_SESSION['info'] = $db->share($userLogin,$userPassword, $otherlogin, $id);
        } else {
            $_SESSION['info']="You have to write a Login";
        }
    }


    if (isset($_REQUEST["Edit"])) {  // request to change user password

        $id = test_input($_POST["id"]);


        if (empty($_POST["login"])) { // check if the given "login" is empty. If true, write the appropriate error. If false, save the variable login
            $login = "";
            $errors['login'] = "Login is required";
        } else {
            $login = test_input($_POST["login"]);
        }
        if (empty($_POST["password"])) {//similar to the comment above
            $password = "";
            $errors['password'] = "Login is required";
        } else {
            $password = test_input($_POST["password"]);
        }

        $description = test_input($_POST["description"]); //save the website description

        if (empty($_POST["web_address"])) { // check if the given "web_address" is empty. If true, write the appropriate error. If false, save the variable web_address
            $web_address = "";
            $errors['web_address'] = "Web address is required";
        } else {
            $web_address = test_input($_POST["web_address"]);
        }

        if (nonerror($errors)) { // if there is no errors
            if($user==null){ // if there is no user in database with that data
                $_SESSION['info'] = "Error - there is no user";
            }else{
                // create a partition with the following data: login to that website, password, website description, link, user id.
                $_SESSION['info'] = $db->editPartition($id, $login, $password, $description, $web_address, $user->getId()); // returns information about task realization
               // header('location:password_wallet.php');  // thanks to it, another partition is not added after refreshing the page.
            }
        }else{
            $_SESSION['info'] = "Error - there is some problem with your data, check the window with editing form."; // if there are any errors with data given to the form
        }

    }

    if (isset($_REQUEST["Change"])) {  // request to change user password
        $wallet =false;

        if (empty($_POST["old_password"])) {  // check if the given "old_password" is empty. If true, write the appropriate error. If false, save the variable old_password
            $old_password = "";
            $errors['old_password'] = "Password is required";
        } else {
            $old_password = test_input($_POST["old_password"]);
        }

        if (empty($_POST["password_new"])) { //similar to the comment above

            $password_new = "";
            $errors['password_new'] = "Password is required";
        } else {
            $password_new = test_input($_POST["password_new"]);
        }

        if (empty($_POST["repeatPassword_new"])) { //similar to the comment above
            $repeatPassword_new = "";
            $errors['repeatPassword_new'] = "Repeat password is required";
        } else {
            $repeatPassword_new = test_input($_POST["repeatPassword_new"]);
        }


        if (empty($_POST["hashType_new"])) { //similar to the comment above
            $hashType_new = "";
            $errors['hashType_new'] = "Hash type is required";
        } else {
            $hashType_new = test_input($_POST["hashType_new"]);
        }

        if ($repeatPassword_new != $password_new) { //check if given passwords are the same
            $errors['repeatPassword'] = "The passwords aren't the same";
        }

        if (nonerror($errors)) { //if there is no errors
            if($old_password==$_SESSION['password']){
                $user = $db->getUser($_SESSION['login']); //check if there is an user with that login
                if ($user == null) {
                    $errors['info'] = "Uoops, we found some error!"; //there is no user
                } else {
                    if ($hashType_new == "SHA512") { //set hash type
                        $hash = true;
                    } else {
                        $hash = false;
                    }
                    //call registerUser function
                    $db->registerUser($_SESSION['login'], $password_new, $hash, false); // true - means user registration / false - password change
                }
            }else{
                $_SESSION['info'] = "Your password is not correct!"; //the message if passwords isn't the same
            }
        }else{
           // var_dump($errors);
        }
    }

    if(isset($_SESSION['info'])){
        if($_SESSION['info']=="Your password has changed" ) //message if password change
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

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <?php
    if (isset($_SESSION['id'])) {// if session variable ID exist, then move to active partition
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

    <?php
    if (isset($_SESSION['login_log_successful']) || isset($_SESSION['login_log_failed'])) {// if session variable ID exist, then move to active partition
        echo ' <div class="m-5 alert alert-dark alert-dismissible p-3 fade show position-fixed " style="width: 20%; z-index: 3" role="alert">
            <h4 class="text-center">Last logs!</h4>
            <br>
                <div class="text-center w-100">
                    <strong>Successful</strong><br>'.$_SESSION['login_log_successful'].'<br> <br> 
                    <strong>failed</strong><br>';

                if(isset($_SESSION['login_log_failed'])){
                    echo $_SESSION['login_log_failed'];
                }else{
                    echo "There is no failed logs.";
                }

              echo'</div>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
    ?>

    <div class="m-5 alert alert-light alert-dismissible p-3 fade show position-fixed border-bottom text-center" style="width: 20%; z-index: 3; height: auto; right: 0px" role="alert">
        <h4 class="text-center px-3 text-justify">You are in <br>
            <?php if(isset($_SESSION['mode'])){ if($_SESSION['mode']=='read-mode'){ echo 'read mode - You can not delete any partitions';} else{echo 'modify mode - You can delete partitions';}}?>
        </h4>

        <h5>Click on padlock below to
            <?php if(isset($_SESSION['mode'])){ if($_SESSION['mode']=='read-mode'){ echo 'enter modify mode';} else{echo 'enter read mode';}}?>
        </h5>
        <hr>
        <form action="password_wallet.php" method="get">
            <input type="submit" value="<?php if(isset($_SESSION['mode'])){ if($_SESSION['mode']=='modify-mode'){ echo 'modify';} else{echo 'read';}}?>" name="mode"class="btn btn-light btn-circle btn-xl
        <?php if(isset($_SESSION['mode'])){ if($_SESSION['mode']=='read-mode'){ echo 'mode-alert-lock';} else{echo 'mode-alert-unlock';}}?>
        ">
        </form>
    </div>

    <div class="container p-1 w-50">
        <?php if(isset($_SESSION['info'])) echo '<h3 class="text-center text-dark alert-warning p-3 position-absolute w-50">'.$_SESSION['info']."</h3>"; // display the error ?>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false">

            <div class="carousel-inner" data-interval="false">
                <div class="carousel-item
            <?php if($wallet) echo "active"; ?>
                " data-interval="false" id="loginBox">
                    <h1 class="p-5 text-center mt-4">Welcome <?php echo $_SESSION['login']; ?> to your Password Wallet</h1>
                    <div class ="card-frame-password_wallet">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Password Wallet</h5>
                                <p class="card-text">Check and add new password and websites to your password wallet.</p>
                                <hr>
                                <div id="accordion" class="wallet pl-3">
                                    <?php
                                    //generation of partitions
                                    $partitions = $db->getPartition($user->getId()); // get partitions
                                    $i=0;
                                    if($partitions!=null){
                                        foreach($partitions as $partition) {
                                            $i++;
                                            if (isset($_SESSION['id'])) {
                                                if ($partition->getId() == $_SESSION['id'])// if this is the tab we are operating on
                                                {
                                                    $partition->setActive(true); // if it is a THAT partition set it active
                                                    $partition->createPartition($i, $decrypt); //display partition
                                                    echo '<script> scroll('.$i.'); </script>';

                                                }else{
                                                    $partition->createPartition($i, ""); //display partition
                                                }
                                            }else{
                                                $partition->createPartition($i, ""); //display partition
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
                            <a class="btn w-25 btn-dark m-auto nextButton" href="#carouselExampleIndicators" id="click"  role="button" data-slide="prev"">
                            <span class="" id="text">&#8592; Logs</span>
                            </a>

                            <a class="btn w-25 btn-dark m-auto nextButton" href="#carouselExampleIndicators" id="click"  role="button" data-slide="next"">
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
                            <a class="btn w-25 btn-dark m-auto nextButton" href="#carouselExampleIndicators" id="click"  role="button" data-slide="prev"">
                            <span class="" id="text">&#8592; Wallet</span>
                            </a>

                            <a class="btn w-25 btn-dark m-auto nextButton" href="#carouselExampleIndicators" id="click"  role="button" data-slide="next"">
                            <span class="" id="text">Logs &#8594;</span>
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
                    <h1 class="p-5 text-center  mt-4""><?php echo $_SESSION['login']; ?> check logs of application! </h1>

                    <div class ="card-frame-password_wallet">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Logs of application</h5>
                                <p class="card-text">Take a look and check what happend in your password wallet.</p>

                                <hr>

                                <div class="logs_table sticky-top">
                                    <table class="table table-hover">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">id</th>
                                            <th scope="col">time</th>
                                            <th scope="col">name of function</th>
                                            <th scope="col">description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        //rows with logs
                                        echo $db->showLogsOfFunctions();
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="text-center p-3">
                            <a class="btn w-25 btn-dark m-auto nextButton" href="#carouselExampleIndicators" id="click"  role="button" data-slide="prev"">
                            <span class="" id="text">&#8592; Change password</span>
                            </a>

                            <a class="btn w-25 btn-dark m-auto nextButton" href="#carouselExampleIndicators" id="click"  role="button" data-slide="next"">
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

<?php if(isset($_SESSION['info'])) unset($_SESSION['info']) // remove the session variable "info"?>
