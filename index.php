<?php

mb_internal_encoding("UTF-8");

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'books.php';
require_once 'writers.php';

require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem(__DIR__ .'/tpl');
$twig = new Twig_Environment($loader, array(
    'cache'       => false,
    'auto_reload' => true
));
$action = $_POST['action']??'not eee';
$T = $twig->loadTemplate('base.html.twig');

$bookObject = new bookList(); //создаются объекты
$jenreObject = new jenreList();

if ($action == 'UpdBook') {
    $title = $_POST['title'];
    $id = $_POST['id'];
    $resultUpdate = $bookObject->updateBook($title, $id);
    if ($resultUpdate) {
        echo 'ok';
    } else {
        echo 'not so good';
    } 
    exit;
}


$table = "<div class='table'>";

$resultBookData = $bookObject->getBookData(); //получение данных
$resultJenre = $jenreObject->getJenre();

array_push($resultJenre, ['id_jenre'=>0,'title_jenre'=>'Город не выбран']);

$book = '';
$jenre = '';
$errors = [];



function clean($value = "") {
    $value = trim($value);              //проверка на пробелы
    $value = stripslashes($value);      //на слэши
    $value = strip_tags($value);        //на php и html - теги
    $value = htmlspecialchars($value);  //спец.символы html
    return $value;
}


//foreach ($resultUserData as $row) {
// $table .= "<div class='tr'>";
// $table .= "<div class='td_id'>".$row['id']."</div>";
// $table .= "<div class='td_name'>".$row['name']."</div>";
// $table .= "<div class='td_city'>".$row['city']."</div>";
// $table .= "<div class='td_age'>".$row['age']."</div>";
// $table .= "</div>";
//      }
//$table .= "</div>";
//        echo $table;

//echo count($resultUserData);
//var_dump($resultUserData);
//var_dump($resultCity);
//exit;
$T->display(['dataARR'=>$resultBookData,
             'jenreList'=>$resultJenre]);



//foreach ($resultUserData as $row) {
//
//$T->display([    
//    'id'=>$row['id'],
//    'name'=>$row['name'],
//    'city'=>$row['city'],
//    'age'=>$row['age'],
//    ]);
//}

if (isset($_POST["title"])) {

    $title=clean($_POST["title"]);
    $jenre=$_POST["jenre"];
    $year = $_POST['year'];
    $errors = array();

        if ($title == ''){
            $errors[] = array(
                "field" => "title",
                "message" => "Поле Имя не заполнено");
        }else{
            if (!preg_match('/^[a-zA-Zа-яА-Я]+$/u', $title)){ //проверка на ввод допустимых символов
                $errors[] = array(
                    "field" => "title",
                    "message" => "Поле должно содержать только кириллические и латинские буквы"
                );
            }
        }
        if ($year == ''){
            $errors[] = array(
                "field" => "year",
                "message" => "Поле год не заполнено");
        }else {
            if (filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT)) {
                if (!($year >= 1900 && $year <= 2019)) {
                    $errors[] = array(
                        "field" => "year",
                        "message" => "Введенный год некорректен");
                }
            } else {
                $errors[] = array(
                    "field" => "year",
                    "message" => "Год должен быть числом");
            }
        }
        if ($jenre == '0'){
            $errors[] = array(
                "field" => "jenre",
                "message" => "Город не выбран");
        }

        if(!count($errors)){
            
            $resultInsert = $bookObject->addBook($title, $jenre, $year);
            $resultUpdate = $bookObject->updateBook($title);
            
            echo "Строка успешно добавлена";
        }
}

//adding string in table
//if (isset($_POST['name'])&&isset($_POST['city'])&&isset($_POST['age'])){
//$name = $_POST['name'];
//$city = $_POST['city'];
//$age = $_POST['age'];
//if(mysqli_query($link, $errors))
//}

?>
