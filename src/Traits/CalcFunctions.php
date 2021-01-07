<?php

namespace AttractionsIo\Traits;

use Datetime;


trait CalcFunctions {
    
    public function getAge(string $dob): int
    {
        $age = date_diff(date_create($dob), date_create('now'))->y;

        return $age ?: 0;
    }
}

?>