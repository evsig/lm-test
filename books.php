<?php

require_once 'DBSQL.php';

class bookList {
    /**метод getUserData()
     * создает объект скл
     * квэри = текст запроса
     * выполняет запрос
     * получаем массив из результата запроса
     * возвращает массив myArray
     * @return type
     */
    public function getBookData() { //метод getUserData()
        $mysqli = new DBSQL();      //
        $query = "SELECT
                b.id_book,
                b.title,
                id_jenre as id_jenre,
                b.jenre,
                b.year
        FROM
                books b
        LEFT JOIN jenres  j ON b.jenre = j.title_jenre";
        // вывод юзера по ид: запрос+WHERE users_aevsigneev.id =" . $id;
        $result = $mysqli->f_query($query);
        $myArray = $mysqli->myFetchArray($result);
        return $myArray;
    }
    /**
     * добавдяет запись в таблицу
     * @param type $name
     * @param type $city
     * @param type $age
     * @return type
**/
    public function addBook($title, $jenre, $year) {
        $mysqli = new DBSQL();
        $addText = 'INSERT INTO `books` (`title`, `jenre`, `year`)
                                    VALUES ("' . $title . '","' . $jenre . '", ' . $year . ')';
        $result = $mysqli->f_query($addText);
        if (!$result) {
            echo 'error ' . $mysqli->connection->error;
        }
        return $result;
    }


    public function updateBook($title,$id) {
        $mysqli = new DBSQL();
        $changeText = 'UPDATE `books` SET `title` = "'.$title.'" WHERE `id` = '.$id;
        $result = $mysqli->f_query($changeText);
        if (!$result) {
            echo 'error ' . $mysqli->connection->error;
        }
        return $result;
    }     


//    public function __construct($id = 0) {
//    
//        $this->ud = $id;
//    }
    /**
     * 
     * @param type $name
     * @param type $city
     * @param type $age
     * @return string
     */
}
