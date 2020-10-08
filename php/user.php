<?php


class user
{
    private $id = null;
    private $login = null;
    private $password_hash;
    private $salt;
    private $isPasswordKeptAsHash;

    public function __construct($id, $login, $password_hash, $salt, $isPasswordKeptAsHash)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password_hash = $password_hash;
        $this->salt = $salt;
        $this->isPasswordKeptAsHash = $isPasswordKeptAsHash;

    } // end __construct();

    public function getId(){
        return $this->id;
    }
    public function getLogin(){
        return $this->login;
    }
    public function getPassword_Hash(){
        return $this->password_hash;
    }
    public function getSalt(){
        return $this->salt;
    }
    public function getIsPasswordKeptAsHash()
    {
        return $this->isPasswordKeptAsHash;
    }
    public function showUserInfo(){
        if($this->isPasswordKeptAsHash)
        {
            $isPassword="yes";
        }
        else{
            $isPassword="no";
        }
        echo "Id: ".$this->id."<br>"."Login: ".$this->login."<br>"."Password_Hash: ".$this->password_hash."<br>"."Salt: ".$this->salt."<br>"."isPasswordKeptAsHash: ".$isPassword."<br>";
    }



}