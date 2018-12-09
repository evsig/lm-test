<?php
require_once 'DBSQL.php';
class cityList {
    
public function getCity() {
    $mysqli = new DBSQL();
    $queryCity = "select `id`, `city` from `cities_aevsigneev`";
    $result = $mysqli->f_query($queryCity);
    $myArray = $mysqli->myFetchArray($result);
    return $myArray;
}

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

