<?php

mb_internal_encoding("UTF-8");

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'users.php';
require_once 'cities.php';

require_once 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem(__DIR__ .'/tpl');
$twig = new Twig_Environment($loader, array(
    'cache'       => false,
    'auto_reload' => true
));
$action = $_POST['action']??'not eee';
$T = $twig->loadTemplate('base.html.twig');

$userObject = new userList(); //создаются объекты
$cityObject = new cityList();

if ($action == 'UpdName') {
    $name = $_POST['jname'];
    $id = $_POST['jid'];
    $resultUpdate = $userObject->updateUser($name, $id);
    if ($resultUpdate) {
        echo 'ok';
    } else {
        echo 'not so good';
    } 
    exit;
}


$table = "<div class='table'>";

$resultUserData = $userObject->getUserData(); //получение данных 
$resultCity = $cityObject->getCity();

array_push($resultCity, ['id'=>0,'city'=>'Город не выбран']);

$name = '';
$age = '';
$errors = [];



function clean($value = "") {
    $value = trim($value);              //проверка на пробелы
    $value = stripslashes($value);      //на слэши
    $value = strip_tags($value);        //на php и html - теги
    $value = htmlspecialchars($value);  //спец.символы html
    return $value;
}

if (isset($_GET["ab"]) && $_GET["ab"] == 'success') {
    echo "string $row was added";
} elseif(isset($_GET["ab"]) && $_GET["ab"] != 'success') {
    echo "string not was added";
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
$T->display(['dataARR'=>$resultUserData,
             'cityList'=>$resultCity]);



//foreach ($resultUserData as $row) {
//
//$T->display([    
//    'id'=>$row['id'],
//    'name'=>$row['name'],
//    'city'=>$row['city'],
//    'age'=>$row['age'],
//    ]);
//}

if (isset($_POST["name"])) {

    $name=clean($_POST["name"]);
    $city=$_POST["city"];
    $age = $_POST['age'];
    $errors = array();

        if ($name == ''){
            $errors[] = array(
                "field" => "name",
                "message" => "Поле Имя не заполнено");
        }else{
            if (!preg_match('/^[a-zA-Zа-яА-Я]+$/u', $name)){ //проверка на ввод допустимых символов
                $errors[] = array(
                    "field" => "name",
                    "message" => "Поле должно содержать только кириллические и латинские буквы"
                );
            }
        }
        if ($age == ''){
            $errors[] = array(
                "field" => "age",
                "message" => "Поле Возраст не заполнено");
        }else {
            if (filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT)) {
                if (!($age >= 10 && $age <= 100)) {
                    $errors[] = array(
                        "field" => "age",
                        "message" => "Введенный возраст некорректен");
                }
            } else {
                $errors[] = array(
                    "field" => "age",
                    "message" => "Возраст должен быть числом");
            }
        }
        if ($city == '0'){
            $errors[] = array(
                "field" => "city",
                "message" => "Город не выбран");
        }

        if(!count($errors)){
            
            $resultInsert = $userObject->addUser($name, $city, $age);
            $resultUpdate = $userObject->updateUser($name);
            
            echo "Строка успешно добавлена";
            header('Location: /index.php?ab=success');
            exit;
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
<!--
<FORM ACTION="index.php" METHOD="POST">
<INPUT TYPE="text" name="name" value="<? echo $name; ?>"><br>
    <select name="city">
        <option value="0">Выберите город</option>
        <?
//$myArray=$mysqli->myFetchArray($resultCity);
foreach ($resultCity as $row_city) {
            ?>
            <option value="<?=$row_city['id']?>"><?=$row_city['city']?></option>
            <?
        }
        ?>
    </select><br>
<INPUT TYPE="text" name="age" value="<?php echo $age; ?>"><p>
<INPUT TYPE="submit" value="Ввод">
<INPUT TYPE="submit" value="Проверка AJAX">
</FORM>

<? if(count($errors)){ ?>
    Не все ошибки исправлены:
<ul>
    <? foreach ($errors as $error) { ?>
        <li><? echo $error['message']; ?></li>
    <? } ?>
</ul>
<? } ?>
</body>
</html>-->