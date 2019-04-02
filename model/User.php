<?php

class User
{
    public $dataBases;

    public function __construct()
    {
        $this->dataBases = new DataBases();
    }

    public function select($array = [])
    {
        return $this->dataBases->whereSelect('users', $array);
    }

    public function add($login, $password)
    {
        return $this->dataBases->insertData('users', ['login' => $login, 'password' => md5($password), 'status' => 1]);
    }

    public function edit($id, $password)
    {
        return $this->dataBases->updateData('users', ['password' => md5($password)], ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->dataBases->deleteId('users', ['id' => $id]);
    }

}