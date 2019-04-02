<?php

class Theme
{
    public $dataBases;

    public function __construct()
    {
        $this->dataBases = new DataBases();
    }

    public function select($array = [])
    {
        return $this->dataBases->whereSelect('theme', $array);
    }

    public function add($name)
    {
        return $this->dataBases->insertData('theme', ['name' => $name, 'status' => 1]);
    }

    public function delete($id)
    {
        return
            [
                $this->dataBases->deleteId('theme', ['id' => $id]),
                $this->dataBases->deleteId('content', ['id_theme' => $id])
            ];
    }
}