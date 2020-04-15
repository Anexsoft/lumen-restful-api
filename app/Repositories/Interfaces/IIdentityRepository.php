<?php
namespace App\Repositories\Interfaces;

interface IIdentityRepository
{
    public function signin(string $email, string $password) : array;
}
