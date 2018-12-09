<?php

require_once 'DBSQL.php';

class userList {
    /**метод getUserData()
     * создает объект скл
     * квэри = текст запроса
     * выполняет запрос
     * получаем массив из результата запроса
     * возвращает массив myArray
     * @return type
     */
    public function getUserData() { //метод getUserData()
        $mysqli = new DBSQL();      //
        $query = "SELECT
                u.id,
                u.`name`,
                c.id as city_id,
                u.age
        FROM
                users_aevsigneev u
        LEFT JOIN cities_aevsigneev c ON u.city = c.id";
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
     */
    public function addUser($name, $city, $age) {
        $mysqli = new DBSQL();
        $addText = 'INSERT INTO `users_aevsigneev` (`name`, `city`, `age`)
                                    VALUES ("' . $name . '","' . $city . '", ' . $age . ')';
        $result = $mysqli->f_query($addText);
        if (!$result) {
            echo 'error ' . $mysqli->connection->error;
        }
        return $result;
    }
    
    public function updateUser($name,$id) {
        $mysqli = new DBSQL();
        $changeText = 'UPDATE `users_aevsigneev` SET `name` = "'.$name.'" WHERE `id` = '.$id;
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
