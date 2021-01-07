<?php
namespace AttractionsIo\Controllers\V1;

use AttractionsIo\Controllers\V1\Contracts\UserControllerInterface;
use AttractionsIo\Models\User;
use DateTime;

use AttractionsIo\Traits\CalcFunctions;

class UserController implements UserControllerInterface{
    use CalcFunctions;

    private $requestMethod;
    private $errorMessage;

    public function __construct($requestMethod)
    {
        $this->requestMethod = $requestMethod;
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->createUserFromRequest();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function createUserFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateInput($input)) {
            return (!empty($this->errorMessage)) ? $this->preconditionFailed() : $this->unprocessableEntityResponse();
        }

        $userData = ['email'=>$input['email'], 'firstname'=>$input['firstname'], 'lastname'=>$input['lastname'], 'password'=>$input['password'], 'dob'=>$input['dob']];
        $user = new User($userData);
        $user->createUser();

        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function validateInput($input)
    {
        if (empty($input['firstname']) || strlen($input['firstname']) > 32 ) {
            $this->errorMessage = "Invalid first name";
            return false;
        }
        if (empty($input['lastname'])  || strlen($input['lastname']) > 32 ) {
            $this->errorMessage = "Invalid last name";
            return false;
        }

        if (empty($input['password'])  || strlen($input['password']) > 32 ) {
            $this->errorMessage = "Invalid password provided";
            return false;
        }

        return $this->validateDateOfBirth($input['dob']) && $this->validateEmailAddr($input['email']);
        
        return true;
    }

    private function validateDateOfBirth($dob){
        if (empty($dob) || ! DateTime::createFromFormat('Y-m-d', $dob)) {
            $this->errorMessage = "Invalid date of birth provided";
            return false;
        }

        if($this->getAge($dob) < 13){
            $this->errorMessage = "User must be at least 13 years old";
            return false;
        };
        return true;
    }

    private function validateEmailAddr($email){
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254 ){
            $this->errorMessage = "Invalid email address provided";
            return false;
        }

        return true;
    }

    public function testFunction($name, $data){
        return $this->$name($data);
    }

    private function preconditionFailed()
    {
        $response['status_code_header'] = 'HTTP/1.1 412 Precondition Failed';
        $response['body'] = json_encode([
            'status' => false, 'data'=> null, 'message' => $this->errorMessage
        ]);
        return $response;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'status' => false, 'data'=> null, 'message' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode([
            'status' => false, 'data'=> null, 'message' => ''
        ]);
        return $response;
    }
}