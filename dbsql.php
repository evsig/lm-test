<?php
class DBSQL {

    public $connection;

    public function __construct() {
        $host = '127.0.0.1';
        $database = 'test';
        $user = 'stager';
        $password = 'stager';

//        $link = mysqli_connect($host, $user, $password, $database);
//        if (!$link) {
//            echo "Ошибка: Невозможно установить соединение с MySQL.</br>" . PHP_EOL;
//            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL . "</br> ";
//            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL . "</br> ";
//            exit;
//        }

        $this->connection = new mysqli("127.0.0.1", "stager", "stager", "test");
    }

    public function f_query($queryText) {
        $result = $this->connection->query($queryText);
        return $result;
    }

    public function myFetchArray($myArray) {
        $result = [];
        while ($row = mysqli_fetch_array($myArray)) {
        $result[] = $row;    
        }
        return $result;
    }
    public function __destruct() {
        mysqli_close($this->connection);
    }
}
