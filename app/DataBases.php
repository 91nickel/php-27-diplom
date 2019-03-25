<?php

class DataBases
{
    public $pdo;

    public function __construct()
    {
        $this->pdo = new pdo("mysql:host=127.0.0.1;charset=utf8;dbname=nikita_zma_de_db", "nikita_zma_d_usr", "AwoHcHx4hBlgpKFc");
        $this->query('SET NAMES UTF-8');
    }


    public function query($sql)
    {
        return $this->pdo->query($sql);
    }

    public function summaId($table, $sum, $where)
    {
        $sql = "SELECT SUM(`" . $sum . "`) FROM `" . $table . "` ";
        if (count($where) > 0) {
            $sql .= $this->where($where);
        }
        return $this->query($sql);
    }

    /*Метод для выборки */
    public function select($table, $field = [], $where = [], $order = [], $limit = [])
    {
        //echo '</br>Переменная where в функции select</br>';
        //var_dump($where);
        //echo '</br>';

        $sql = "SELECT ";
        if (count($field) === 0) {
            $sql .= "*";
        } else {
            foreach ($field as $key) {
                if (isset($flag)) {
                    $sql .= " ,";
                }
                $sql .= " `" . $key . "`";
                $flag = true;
            }
        }

        $sql .= " FROM `" . $table . "` ";
        if (count($where) > 0) {
            //echo '</br>Пошло обращение к where из select</br>';
            $sql .= $this->where($where);
        }
        if (count($order) > 0) {

            $sql .= $this->orderBy($order);
        }
        if (count($limit) > 0) {
            $sql .= $this->limit($limit);
        }
        //var_dump($this->query($sql));
        //var_dump($sql);
        return $this->query($sql);
    }


    /*Метод для добавления*/
    public function insert($table, $field = [])
    {
        $sql = "INSERT `" . $table . "` SET ";
        if (count($field) === 0) {
            return false;
        }
        $sql .= $this->sqlInjectedNoneField($field);

        $res = $this->query($sql);
        if (!$res) return false;
        return $this->pdo->lastInsertId();
    }


    /*Метод обновления */
    public function update($table, $field, $where)
    {
        $sql = "UPDATE  `" . $table . "` SET ";
        if (count($field) === 0 || $where === 0) {
            return false;
        }
        $sql .= $this->sqlInjectedNoneField($field);
        $sql .= $this->where($where);
        var_dump($sql);
        return $this->query($sql);
    }


    /*Метод удаления*/
    public function delete($table, $where = [])
    {
        $sql = "DELETE FROM  `" . $table . "` ";
        if (count($where) === 0) {
            return false;
        }
        $sql .= $this->where($where);
        $this->query($sql);
    }

    /*Метод сортировки*/
    public function orderBy($array)
    {
        return ' ORDER BY `' . $array[0] . '` ' . $array[1];
    }

    public function limit($array)
    {
        $limit = $array[0];
        if (isset($array[1])) {
            $limit = $array[1] . ', ' . $limit;
        }
        return ' LIMIT ' . $limit;
    }

    /*Метод формирования предиката WHERE*/
    public function where($array, $separator = 'AND', $operator = '=')
    {
        //echo '</br>Переменная $array в функции where</br>';
        //var_dump($array);
        //echo '</br>';
        $where = ' WHERE ';
        foreach ($array as $field => $value) {
            //var_dump($value);

            if (preg_match("#^[0-9]{1,}$#", $field)) {
                if ($value == 'OR' || $value == 'AND' || $value == 'NOT') {
                    $separator = ' ' . $value . ' ';
                    continue;
                }
                if ($value === '!=' || $value === '<' || $value === '>' || $value === '=' || $value === '<=' || $value === '>=') {
                    $operator = $value;
                    continue;
                }
            } else {
                if (isset($flag)) {
                    $where .= ' ' . $separator . ' ';
                }
                $where .=
                    " `" . $field .
                    "`" . $operator .
                    "'" . $value . "'";
                $flag = true;
            }
        }
        //echo '</br>Возвращаемый массив из функции where</br>';
        //var_dump($where);
        //echo '</br>';
        return $where;
    }


    /*Обработка данных перед помещеннием их в базу защита от атаки SQL INJECTED*/
    public function sqlInjectedNoneField($array)
    {
        $data = '';
        foreach ($array as $field => $value) {
            $data .= " `" . $field . "`='" . $value . "' ,";
        }
        $data = substr($data, 0, -1);
        return $data;
    }
    //output

    /* Вывод из базы данных полей и из обработка */
    public function resOutPut($res)
    {
        $array = [];
        if ($res) {

            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $array[] = $this->xssNone($row);
            }
        }
        return $array;

    }

    /*Защита от XSS атак экранирование спец. символов*/
    public function xssNone($array)
    {
        foreach ($array as $key => $value) {
            $array[$key] = trim(htmlspecialchars($value));
        }
        return $array;
    }

    /*Получить строки или строку со всеми полями*/
    public function AllFields($table, $where = [], $sort, $limit)
    {
        return $this->resOutPut($this->select($table, [], $where, $sort, $limit));
    }

    /*Получить строки с определенными полями */
    public function Fields($table, $field, $where = [], $sort = [], $limit = [])
    {
        return $this->resOutPut($this->select($table, $field, $where, $sort, $limit));
    }

    public function insertData($table, $field = [])
    {
        return $this->insert($table, $field);
    }

    public function whereSelect($table, $where)
    {
        //echo '</br> Переменная $table в функции where_select </br>';
        //var_dump($table);

        //echo '</br> Переменная $where в функции where_select </br>';
        //var_dump($where);

        return $this->resOutPut($this->select($table, [], $where, [], []));
    }

    public function whereSelectSort($table, $where, $sort)
    {
        return $this->resOutPut($this->select($table, [], $where, $sort, []));
    }

    public function deleteId($table, $where)
    {
        return $this->delete($table, $where);
    }

    public function updateData($table, $field, $where)
    {
        return $this->update($table, $field, $where);
    }

    public function summaIdData($table, $sum, $where)
    {
        return $this->resOutPut($this->summaId($table, $sum, $where));
    }

    public function selectCount($table, $column = '*', $where = [], $groupBy = '', $name = '')
    {
        $sql = 'SELECT ';

        if ($name !== '') {
            $sql .= '`' . $name . '`, ';
        }

        $sql .= 'COUNT(' . $column . ') FROM `' . $table . '`';

        if (count($where) !== 0) {
            $sql .= ' WHERE ';
            $i = 0;
            foreach ($where as $key => $w) {
                $sqlWhere = '`' . $key . '` = ' . "'" . $w . "'";
                if ($i !== 0) {
                    $sql .= ' AND ';
                }
                $sql .= $sqlWhere;
                $i++;
            }
        }
        if ($groupBy !== '') {
            $sql .= ' GROUP BY `' . $groupBy . '`';
        }

        $result = $this->pdo->prepare($sql);
        $result->execute();
        $return = $result->fetchAll();
        //echo 'Запрос: ' . $sql;
        //echo 'Результат: ';
        //var_dump($return);
        return $return;
    }
}