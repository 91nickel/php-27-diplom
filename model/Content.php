<?php

class Content extends Actions
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select()
    {
        $array = [];
        foreach ($this->dataBases->whereSelect('theme', ['status' => 1]) as $item) {
            $array[$item['id']]['name'] = $item['name'];
            $array[$item['id']]['data'] = [];
            foreach ($this->dataBases->whereSelect('content', ['status' => 1]) as $key) {
                if ((int)$item['id'] === (int)$key['id_theme'] && trim($key['answer']) !== '') {
                    $array[$item['id']]['data'][$key['id']] = $key;
                }
            }
        }
        return $array;
    }

    public function add($idTheme, $question, $answer)
    {
        $array = ['id_theme' => $idTheme, 'question' => $question, 'answer' => $answer];
        $array['date'] = time();

        return $this->dataBases->insertData('content', $array);
    }

    public function edit($idTheme, $name, $question, $answer)
    {
        return $this->dataBases->updateData('content', ['question' => $question, 'name' => $name, 'answer' => $answer], ['id' => $idTheme]);
    }

    public function move($idTheme, $theme)
    {
        return $this->dataBases->updateData('content', ['id_theme' => $theme], ['id' => $idTheme]);
    }

    public function delete($id)
    {
        return $this->dataBases->deleteId('content', ['id' => $id]);
    }

    public function changeStatus($id, $status)
    {
        return $this->dataBases->updateData('content', ['status' => (int)$status], ['id' => $id]);
    }

    //Формирует массив для блока контента
    public function themeQuestions($theme, $content)
    {
        $array = [];
        foreach (array_reverse($theme) as $item) {
            $array[$item['id']]['name'] = $item['name'];
            $array[$item['id']]['data'] = [];
            foreach ($content as $key) {
                if ((int)$item['id'] === (int)$key['id_theme'] && trim($key['answer']) !== '') {
                    $array[$item['id']]['data'][$key['id']] = $key;
                }
            }
        }
        return $array;
    }

    public function getInfo()
    {
        $info = [];
        $info['all'] = $this->dataBases->selectCount('question')[0][0] + $this->dataBases->selectCount('content')[0][0];
        $info['published'] = $this->dataBases->selectCount('content', '*', ['status' => 1])[0][0];
        $info['noPublished'] = $this->dataBases->selectCount('question')[0][0] + $this->dataBases->selectCount('content', '*', ['status' => 0])[0][0];
        return $info;
    }

    public function getCounter()
    {
        $counter = [];
        foreach ($this->dataBases->whereSelect('theme', []) as $row) {
            $id = $row['id'];
            $counter[$id]['noPublished'] =
                $this->dataBases->selectCount('question', '*', ['theme' => $id])[0][0] +
                $this->dataBases->selectCount('content', '*', ['id_theme' => $id, 'status' => 0])[0][0];
            $counter[$id]['published'] =
                $this->dataBases->selectCount('content', '*', ['id_theme' => $id, 'status' => 1])[0][0];
            $counter[$id]['all'] = $counter[$id]['noPublished'] + $counter[$id]['published'];
        }
        return $counter;
    }
}