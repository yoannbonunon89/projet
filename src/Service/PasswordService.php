<?php
namespace App\Service;



class PasswordService
{
    static public function ValidPassword($password)
    {

        return strlen($password) > 7;
    }
}
