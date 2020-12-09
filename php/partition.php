<?php

class partition
{
    private $id = null;
    private $password = null;
    private $id_user;
    private $web_address;
    private $description;
    private $login;
    private $active; // value that stored information if the tab is open
    private $shared;

    public function __construct($id, $password, $id_user, $web_address, $description, $login, $shared)
    {
        $this->id = $id;
        $this->password = $password;
        $this->id_user = $id_user;
        $this->web_address = $web_address;
        $this->description = $description;
        $this->login = $login;
        $active = false;
        $this->shared = $shared;

    } // end __construct();

    //unused functions which return private value of object
    public function getId(){
        return $this->id;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getId_User(){
        return $this->id_user;
    }
    public function getWeb_Address(){
        return $this->web_address;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getShared(){
        return $this->shared;
    }
    public function getLogin(){
        return $this->login;
    }
    public function setActive($state)
    {
        $this->active = $state;
    }

    function createPartition($i, $decrypt){ // creating partitions in the wallet (each items from the database)

        if($decrypt!=""){
            $password = $decrypt;
        }else{
            $password = "************";
        }

        if($this->active){
            $show="show";
        }else{
            $show = "";
        }

            echo '              
                                    <div class="card">
                                        <div class="card-header bg-dark" id="heading"'.$i.'>
                                                <button class="btn text-light font-weight-bold w-100" style="font-size:20px" data-toggle="collapse" data-target="#collapse'.$i.'" aria-expanded="true" aria-controls="collapse'.$i.'">
                                                    '.$this->web_address;
                                                    if($this->shared==true) {
                                                        echo ' [shared]';
                                                    }
            echo ' 
                                                    
                                                </button>
                                        </div>

                                        <div id="collapse'.$i.'" class="collapse '.$show.'" aria-labelledby="heading'.$i.'" data-parent="#accordion">
                                            <div class="card-body text-justify bg-dark">
                                            
                                            <table class="table  table-dark colgroup" >
                                              <thead>
                                                <tr>
                                                  <th class="w-50 text-center">Login</th>
                                                  <th class="w-50 text-center">Password</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <tr>
                                                  <td class="text-center" id="login"> '.$this->login.'</td>
                                                  <td  class="text-center" id="password">'.$password.'</td>
                                                </tr>
                                                <tr>
                                                 <th class="w-50 text-center"  colspan="2">Description</th>
                                                </tr>
                                                <tr>
                                                  <td  class="text-justify" colspan="2" id="description">'.$this->description.'</td>
                                                </tr>
                                              </tbody>
                                            </table>
                                            <br>   
                                            <div class="w-100 d-flex justify-content-center mb-3">
                                            <!--Divided into two forms to create confirmation system to delete record quickly-->
                                                <form action="password_wallet.php" method="post" class="text-center d-inline" onsubmit="return confirm(';
                                                    //if there is a mode sesssion value and user is owner
                                                    if(isset($_SESSION['mode']) && $this->shared==false){
                                                        if($_SESSION['mode']=='modify-mode') {
                                                            echo '\'Are you sure? This operation can not be undone!\');">\'';

                                                            echo '<input type="submit" name="Delete" value="Delete" class="btn btn-danger m-1" style="width: 150px;">';
                                                        }else{
                                                            echo '\'You can not do this in read mode!\');">\'';

                                                            echo '<input type="submit" name="--" value="Delete" class="btn btn-danger m-1 disabled" style="width: 150px;">';
                                                        }
                                                    }else{
                                                        echo '\'You are not the owner of this partition!\');">\'';

                                                        echo '<input type="submit" name="--" value="Delete" class="btn btn-danger m-1 disabled" style="width: 150px;">';
                                                    }

                                             echo '
                                                   <input type="number" id="id" name="id" value="'.$this->id.'" style="display: none">
                                                </form>
                                                <form  action="password_wallet.php" method="post" class="text-center d-inline">
                                                    <input type="number" id="id" name="id" value="'.$this->id.'" style="display: none">';
                                                    if($decrypt==""){ //if decrypt variable is empty display button which allows user to decrypt the password
                                                        echo '<input type="submit" name="Show" value="Show" class="btn btn-outline-light m-1" style="width: 150px;">';
                                                    }else{
                                                        echo '<input type="submit" name="Hide" value="Hide" class="btn btn-outline-light m-1" style="width: 150px;">';
                                                    }
                                                    echo '
                                                    
                                                    <a class="btn btn-light m-1" href="http://'.$this->web_address.'" style="width: 150px;">
                                                        To the site  &#8594;
                                                    </a>
                                                                                                        
                                                    ';
                                                        if(isset($_SESSION['mode']) && $this->shared==false){
                                                            if($_SESSION['mode']=='modify-mode') {
                                                                echo '<a class="btn btn-outline-light" data-toggle="collapse" href="#shareForm" role="button" aria-expanded="false" aria-controls="shareForm">Share password</a>';
                                                            }else{
                                                                echo '<a class="btn btn-outline-light disabled" data-toggle="collapse" href="#shareForm" role="button" aria-expanded="false" aria-controls="shareForm">Share password</a>';
                                                            }
                                                        }else{
                                                            echo '<a class="btn btn-outline-light disabled" data-toggle="collapse" href="#shareForm" role="button" aria-expanded="false" aria-controls="shareForm">Share password</a>';
                                                        }


                                                    if(isset($_SESSION['mode']) && $this->shared==false){
                                                        if($_SESSION['mode']=='modify-mode') {
                                                            echo '<a class="btn btn-outline-light" data-toggle="collapse" href="#editForm" role="button" aria-expanded="false" aria-controls="shareForm">Edit password</a>';
                                                        }else{
                                                            echo '<a class="btn btn-outline-light disabled" data-toggle="collapse" href="#editForm" role="button" aria-expanded="false" aria-controls="shareForm">Edit password</a>';
                                                        }
                                                    }else{
                                                        echo '<a class="btn btn-outline-light disabled" data-toggle="collapse" href="#editForm" role="button" aria-expanded="false" aria-controls="shareForm">Edit password</a>';
                                                    }
                                                    echo '
                                                    
                                                </form>

                                            </div>                                         
                                            
                                                 <form  action="password_wallet.php" method="post" class="text-center w-100">
                                                     <div class="collapse multi-collapse" id="shareForm">
                                                      <div class="card card-body w-100 px-5 text-center">
                                                                 <input type="number" id="id" name="id" value="'.$this->id.'" style="display: none">
                                                                <label for="LoginInput">Your login</label>
                                                                <input type="login" name="Userlogin" class="form-control btn btn-dark" id="LoginInput" aria-describedby="Login Input" placeholder="Enter your login">
                                                                
                                                                <label for="password">Your passsword</label>
                                                                <input type="password" class="form-control btn btn-dark" name="Password" id="password" aria-describedby="password" placeholder="Enter password">
                                                                
                                                                <label for="LoginInput">User login</label>
                                                                <input type="login" name="Otherlogin" class="form-control btn btn-dark" id="LoginInput" aria-describedby="Login Input"  placeholder="Enter other user login">
                                                                <hr>
                                                                <input type="submit" name="Access" value="Share" class="m-auto form-control btn btn-dark m-2" style="width: 150px;">
                                                      </div>
                                                    </div>
                                                </form>
                                               
                                               <form  action="password_wallet.php" method="post" class="text-center w-100" onsubmit="return confirm(';
                                                        //if there is a mode sesssion value and user is owner
                                                        if(isset($_SESSION['mode']) && $this->shared==false){
                                                            if($_SESSION['mode']=='modify-mode') {
                                                                echo '\'Are you sure? This operation can not be undone!\');">';
                                                            }else{
                                                                echo '\'You can not do this in read mode!\');">';
                                                            }
                                                        }else{
                                                            echo '\'You are not the owner of this partition!\');">';
                                                        }
                                                        echo '
                                                     <div class="collapse multi-collapse" id="editForm">
                                                      <div class="card card-body w-100 px-5 text-center">
                                                                 <input type="number" id="id" name="id" value="'.$this->id.'" style="display: none">
                                                          
                                                            <label for="login">Login</label>
                                                            <input type="text" class="form-control" name="login" id="login" aria-describedby="Login" placeholder="Enter login" value="'.$this->login.'">
                       
                                                               <label for="password">Password</label>
                                                                <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder="Enter password" value="">
                       
                                                                    <label for="web_address">Web address</label>
                                                                    <input type="text" class="form-control" name="web_address" id="web_address" aria-describedby="web_address" placeholder="Enter web address" value="'.$this->web_address.'">
                                                              
                                                               <label for="description">Description</label>
                                                               <input type="text" class="form-control mb-2" name="description" id="description" aria-describedby="description" placeholder="Enter description" value="'.$this->description.'">';
                                                              
                                                                //if there is a mode sesssion value and user is owner
                                                                if(isset($_SESSION['mode']) && $this->shared==false){
                                                                    if($_SESSION['mode']=='modify-mode') {
                                                        
                                                                        echo '<input type="submit" name="Edit" value="Edit" class="m-auto form-control btn btn-dark " style="width: 150px;">';
                                                                    }else{
                                                                        echo '<input type="submit" name="--" value="Edit" class="m-auto form-control btn btn-dark disabled" style="width: 150px;">';
                                                                    }
                                                                }else{
                                                                    echo '<input type="submit" name="--" value="Edit" class="m-auto form-control btn btn-dark disabled" style="width: 150px;">';
                                                                }
                       echo '

                                                      </div>
                                                    </div>
                                                </form>
                                                 
                                             </div>
                                        </div>
                                    </div>
             ';
    }
}