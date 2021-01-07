<?php
namespace Tests\Unit;
use PHPUnit\Framework\TestCase;

use AttractionsIo\Controllers\V1\UserController;

class SignupTest extends TestCase
{
    public function setUp()
    {
        $this->controller = new UserController(null);
        $this->faker = \Faker\Factory::create();
    }

    public function testEmailValidationReturnsTrueForValidEmail()
    {
        $result = $this->controller->testFunction('validateEmailAddr', $this->faker->safeEmail);
        $this->assertTrue($result);
    }

    public function testEmailValidationReturnsFalseForInvalidEmail()
    {
        $result = $this->controller->testFunction('validateEmailAddr', $this->faker->firstName);//used firstname inplace of email
        $this->assertFalse($result);
    }

    public function testDobValidationReturnsFalseForInvalidDob()
    {
        $result = $this->controller->testFunction('validateDateOfBirth', $this->faker->firstName);//used firstname inplace of a valid dob
        $this->assertFalse($result);
    }

    public function testDobValidationFailsForDobLt13yrs()
    {
        $result = $this->controller->testFunction('validateDateOfBirth', '2011-10-19');//used firstname inplace of email
        $this->assertFalse($result);
    }

    public function testDobValidationReturnsTrueForValidDob()
    {
        $result = $this->controller->testFunction('validateDateOfBirth', '2001-10-19');//used firstname inplace of email
        $this->assertTrue($result);
    }

}
?>