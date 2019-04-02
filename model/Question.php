<?php

class Question
{
    public $dataBases;

    public function __construct()
    {
        $this->dataBases = new DataBases();
    }

    public function select($where = [])
    {
        return $this->dataBases->whereSelect('question', $where);
    }

    public function add($name, $email, $theme, $question)
    {
        return $this->dataBases->insertData('question', ['name' => $name, 'email' => $email, 'theme' => $theme, 'question' => $question]);
    }

    public function answer($question, $id, $name, $email, $idTheme, $answer)
    {
        $this->dataBases->deleteId('question', ['id' => $id]);
        unset($id);

        $array['question'] = $question;
        $array['name'] = $name;
        $array['email'] = $email;
        $array['id_theme'] = $idTheme;
        $array['answer'] = $answer;
        $array['date'] = time();

        return $this->dataBases->insertData('content', $array);
    }

    public function answerPublish($question, $id, $name, $email, $idTheme, $answer)
    {
        $this->dataBases->deleteId('question', ['id' => $id]);
        unset($id);

        $array['question'] = $question;
        $array['name'] = $name;
        $array['email'] = $email;
        $array['id_theme'] = $idTheme;
        $array['answer'] = $answer;

        $array['date'] = time();
        $array['status'] = 1;

        return $this->dataBases->insertData('content', $array);
    }

    public function edit($id, $question)
    {
        $array = ['question' => $question];
        return $this->dataBases->updateData('question', $array, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->dataBases->deleteId('question', ['id' => $id]);
    }


    public function formThemeArray($quest = [], $theme = [])
    {
        foreach ($quest as $key => $row) {
            foreach ($theme as $row1) {
                if ($row['theme'] == $row1['id']) {
                    $quest[$key]['themeName'] = $row1['name'];
                }
            }
        }
        return $quest;
    }

    //Формирует массив для блока themeQuestions
    public function themeQuestions($theme, $content)
    {
        $array = [];
        foreach (array_reverse($theme) as $item) {
            $array[$item['id']]['name'] = $item['name'];
            $array[$item['id']]['data'] = [];

            //var_dump($item);
            foreach ($content as $key) {
                if ((int)$item['id'] === (int)$key['id_theme'] && trim($key['answer']) !== '') {
                    $array[$item['id']]['data'][$key['id']] = $key;
                }
            }
        }
        return $array;
    }

    public function indexContent($databases)
    {
        $array = [];
        foreach ($databases->whereSelect('theme', ['status' => 1]) as $item) {
            $array[$item['id']]['name'] = $item['name'];
            $array[$item['id']]['data'] = [];

            foreach ($databases->whereSelect('content', ['status' => 1]) as $key) {
                if ((int)$item['id'] === (int)$key['id_theme'] && trim($key['answer']) !== '') {
                    $array[$item['id']]['data'][$key['id']] = $key;
                }
            }
        }
        return $array;
    }
}