<?php

namespace App\Services\Mapping;

class Provider1Mapper
{
    public function map($data)
    {
        return [
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'] ?? null,
            'username' => $data['username'] ?? null,
            'password' => $data['password'] ?? null,
            'birthday' => $data['birthdate'] ?? null,
            'gender' =>$data['gender'] ?? null,
            'primaryPhone' => $data['primary_phone'] ?? null
        ];
    }
}