<?php

namespace App\Models;

class ValidationCars
{
    const RULE_CAR = [
        'name' => "required| min:3 | max: 80",
        "description" => "required",
        "model" => "required| min:3 | max: 15",
        "date" => 'required| date_format: "Y-m-d"',
    ];
}
