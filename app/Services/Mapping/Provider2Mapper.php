<?php

namespace App\Services\Mapping;

class Provider2Mapper
{
    public function map($data)
    {
        return [
            'firstName' => $data['f_name'],
            'lastName' => $data['l_name'],
            'email' => $data['email'] ?? null,
            'username' => $data['usrname'] ?? null,
            'password' => $data['password'] ?? null,
            'birthday' => $data['birthday'] ?? null,
            'gender' =>$data['gender'] ?? null,
            'primaryPhone' => $data['phone'] ?? null
        ];
    }
}