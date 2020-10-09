<?php


class partition
{
    private $id = null;
    private $password = null;
    private $id_user;
    private $web_address;
    private $description;
    private $login;
    private $active; //czy zakładka jest otwarta

    public function __construct($id, $password, $id_user, $web_address, $description, $login)
    {
        $this->id = $id;
        $this->password = $password;
        $this->id_user = $id_user;
        $this->web_address = $web_address;
        $this->description = $description;
        $this->login = $login;
        $active = false;

    } // end __construct();

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
    public function getLogin(){
        return $this->login;
    }
    public function setActive($state){
        $this->active=$state;
    }

    function createPartition($i, $decrypt){ //tworzenie przegród w portfelu (poszczególne pozycje z bazy)

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
                                                    '.$this->web_address.'
                                                </button>
                                        </div>

                                        <div id="collapse'.$i.'" class="collapse '.$show.'" aria-labelledby="heading'.$i.'" data-parent="#accordion">
                                            <div class="card-body text-justify bg-dark">
                                            
                                            <table class="table table-bordered table-dark colgroup" >
                                              <thead>
                                                <tr>
                                                  <th class="w-25 text-center">Login</th>
                                                  <th class="w-25 text-center">Password</th>
                                                  <th class="w-50 text-center">Description</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <tr>
                                                  <td class="text-center" id="login"> '.$this->login.'</td>
                                                  <td  class="text-center" id="password">'.$password.'</td>
                                                  <td  class="text-center" id="description">'.$this->description.'</td>
                                                </tr>
                                              </tbody>
                                            </table>
                                            
                                            <form action="password_wallet.php" method="post" class="text-center">
                                                <input type="number" id="id" name="id" value="'.$this->id.'" style="display: none">
                                                <input type="submit" name="Delete" value="Delete" class="btn btn-danger w-25 m-1">
                                                
                                                ';

        if($decrypt==""){
            echo '<input type="submit" name="Show" value="Show" class="btn btn-outline-light w-25 m-1">';
        }else{
            echo '<input type="submit" name="Hide" value="Hide" class="btn btn-outline-light w-25 m-1">';
        }

        echo '
                                                <a class="btn btn-light w-25 m-1" href="http://'.$this->web_address.'">
                                                    To the site  &#8594;
                                                </a>
                                            </form>
                                             </div>
                                        </div>
                                    </div>
             ';
    }

}