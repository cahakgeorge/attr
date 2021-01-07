<?php
namespace AttractionsIo\Models;

use AttractionsIo\Traits\CalcFunctions;

class User{
    use CalcFunctions;

    private $firstname;
    private $lastname;
    private $dob; //value object, immutable
    private $email;
    private $password;

    public function __construct(array $userData)
    {
        foreach($userData as $key => $value)
        $this->$key = $value;
    }

    private function getAge()
    {
        //getAge function exposed by trait
        return $this->getAge($this->dob);
    }

    private function getHashedPassword()
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function createUser()
    {
       //use the set info to create a new user
    }
}