<?php

namespace App\Helpers;


use Illuminate\Http\Exceptions\HttpResponseException;


class ApiErrorResponse
{

    protected function generateVerificationCode()
    {
        return mt_rand(100000, 999999);
    }

    public function broker()
    {
        return Password::broker();
    }


}


