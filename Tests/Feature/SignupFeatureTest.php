<?php
namespace Tests\Feature;
use PHPUnit\Framework\TestCase;

use GuzzleHttp\Client;

class SignupFeatureTest extends TestCase
{
    private $http;

    public function setUp()
    {
        $this->http = new Client(['base_uri' => 'http://127.0.0.1:8002/', 'exceptions' => false,
                    'headers' => [ "Content-Type"=>'application/json'], 
        ]);
    }

    public function testUserCanSignup()
    {    
        $faker = \Faker\Factory::create();

        $signupData = ['email' => $faker->safeEmail, 'firstname' => $faker->firstName, 'lastname' => $faker->lastName, "dob"=> "2004-10-18",
                        'password' => 'secret'];

        $response = $this->http->request('POST', 'user', ['json' => $signupData]);
        $this->assertEquals(201, $response->getStatusCode());
    } 

    public function testSignupFailsWithInvalidEmail()
    {
        $faker = \Faker\Factory::create();

        $signupData = ['email' => 'c', 'firstname' => $faker->firstName, 'lastname' => $faker->lastName, "dob"=> "2004-10-18",
        'password' => 'secret'];

        $response = $this->http->request('POST', 'user', ['json' => $signupData]);
        
        $this->assertEquals(412, $response->getStatusCode());
        $this->assertContains('Invalid email address provided', json_decode($response->getBody()->getContents(), true));
    }

    public function testSignupFailsWithEmailGt254Chars()
    {
        $faker = \Faker\Factory::create();

        $signupData = ['email' => str_replace([' ', '  ', ',', '.'], '', $faker->text(300)).$faker->safeEmail, 'firstname' => $faker->firstName, 'lastname' => $faker->lastName, "dob"=> "2004-10-18",
        'password' => 'secret'];

        $response = $this->http->request('POST', 'user', ['json' => $signupData]);
        
        $this->assertEquals(412, $response->getStatusCode());
        $this->assertContains('Invalid email address provided', json_decode($response->getBody()->getContents(), true));
    }

    public function testSignupFailsWithInvalidFirstName()
    {
        $faker = \Faker\Factory::create();

        $signupData = ['email' => $faker->safeEmail, 'firstname' => '', 'lastname' => $faker->lastName, "dob"=> "2004-10-18",
        'password' => 'secret'];

        $response = $this->http->request('POST', 'user', ['json' => $signupData]);

        $this->assertEquals(412, $response->getStatusCode());
        $this->assertContains('Invalid first name', json_decode($response->getBody()->getContents(), true));
    }

    public function testSignupFailsWithFirstNameGt32Chars()
    {

        $faker = \Faker\Factory::create();
        $firstname = str_replace([' ', '  ', ',', '.'], '', $faker->text(100));

        $signupData = ['email' => $faker->safeEmail, 'firstname' =>$firstname , 'lastname' => $faker->lastName, "dob"=> "2004-10-18",
        'password' => 'secret'];

        $response = $this->http->request('POST', 'user', ['json' => $signupData]);

        $this->assertEquals(412, $response->getStatusCode());
        $this->assertContains('Invalid first name', json_decode($response->getBody()->getContents(), true));
    }

    public function testSignupFailsWithInvalidLastName()
    {
        $faker = \Faker\Factory::create();

        $signupData = ['email' => $faker->safeEmail, 'firstname' => $faker->lastName, 'lastname' => '', "dob"=> "2004-10-18",
        'password' => 'secret'];

        $response = $this->http->request('POST', 'user', ['json' => $signupData]);

        $this->assertEquals(412, $response->getStatusCode());
        $this->assertContains('Invalid last name', json_decode($response->getBody()->getContents(), true));
    }

    public function testSignupFailsWithLastNameGt32Chars()
    {
        $faker = \Faker\Factory::create();
        $lastname = str_replace([' ', '  ', ',', '.'], '', $faker->text(100));

        $signupData = ['email' => $faker->safeEmail, 'firstname' =>$faker->firstName , 'lastname' => $lastname, "dob"=> "2004-10-18",
        'password' => 'secret'];

        $response = $this->http->request('POST', 'user', ['json' => $signupData]);

        $this->assertEquals(412, $response->getStatusCode());
        $this->assertContains('Invalid last name', json_decode($response->getBody()->getContents(), true));
    }

    public function testSignupFailsWithInvalidPassword()
    {
        $faker = \Faker\Factory::create();

        $signupData = ['email' => $faker->safeEmail, 'firstname' => $faker->firstName, 'lastname' => $faker->lastName, "dob"=> "2004-10-18",
        'password' => ''];

        $response = $this->http->request('POST', 'user', ['json' => $signupData]);

        $this->assertEquals(412, $response->getStatusCode());
        $this->assertContains('Invalid password provided', json_decode($response->getBody()->getContents(), true));
    }

    public function testSignupFailsWithPasswordGt32Chars()
    {
        $faker = \Faker\Factory::create();
        $passwordFn = function ($faker, $var) {return str_repeat($faker->password, $var);};
        
        $signupData = ['email' => $faker->safeEmail, 'firstname' => $faker->firstName, 'lastname' => $faker->lastName, "dob"=> "2004-10-18",
        'password' => $passwordFn($faker, 10)];

        $response = $this->http->request('POST', 'user', ['json' => $signupData]);

        $this->assertEquals(412, $response->getStatusCode());
        $this->assertContains('Invalid password provided', json_decode($response->getBody()->getContents(), true));
    }

    public function testSignupFailsWithInvalidDateOfBirth()
    {
        $faker = \Faker\Factory::create();

        $signupData = ['email' => $faker->safeEmail, 'firstname' => $faker->firstName, 'lastname' => $faker->lastName, "dob"=> "A-10-18",
        'password' => 'secret'];

        $response = $this->http->request('POST', 'user', ['json' => $signupData]);

        $this->assertEquals(412, $response->getStatusCode());
        $this->assertContains('Invalid date of birth provided', json_decode($response->getBody()->getContents(), true));
    }

    public function testSignupFailsWithDateOfBirthLt13()
    {
        $faker = \Faker\Factory::create();
        $lastname = str_replace([' ', '  ', ',', '.'], '', $faker->text(70));

        $signupData = ['email' => $faker->safeEmail, 'firstname' => $faker->firstName, 'lastname' => $faker->lastName, "dob"=> "2010-10-18",
        'password' => 'secret'];

        $response = $this->http->request('POST', 'user', ['json' => $signupData]);

        $this->assertEquals(412, $response->getStatusCode());
        $this->assertContains('User must be at least 13 years old', json_decode($response->getBody()->getContents(), true));
    }
    
    public function tearDown() {
        $this->http = null;
    }
}
?>