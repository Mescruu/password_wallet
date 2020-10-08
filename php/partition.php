<?php


class partition
{
    private $id = null;
    private $password = null;
    private $id_user;
    private $web_address;
    private $description;
    private $login;

    public function __construct($id, $password, $id_user, $web_address, $description, $login)
    {
        $this->id = $id;
        $this->password = $password;
        $this->id_user = $id_user;
        $this->web_address = $web_address;
        $this->description = $description;
        $this->login = $login;

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

    function createPartition($i){ //tworzenie przegród w portfelu (poszczególne pozycje z bazy)

            echo '              
                                    <div class="card">
                                        <div class="card-header" id="heading"'.$i.'>
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse'.$i.'" aria-expanded="true" aria-controls="collapse'.$i.'">
                                                    '.$this->web_address.'
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapse'.$i.'" class="collapse" aria-labelledby="heading'.$i.'" data-parent="#accordion">
                                            <div class="card-body">
                                             <h5>Login</h5>
                                                    '.$this->login.'
                                            <hr>
                                            <h5>Password</h5>
                                                        '.$this->password.'
                                            <hr>
                                            <h5>Description</h5>
                                               <p>
                                              '.$this->description.'
                                                </p> 
                                            </div>
                                            
                                            <form action="password_wallet.php" method="post">
                                                <input type="number" id="id" name="id" value="'.$this->id.'" style="display: none">
                                                <input type="submit" name="Delete" value="Delete" class="btn btn-dark w-25 m-1">
            
                                            </form>
                                
                                        </div>
                                    </div>
             ';
    }

}