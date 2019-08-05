<?php
require_once 'DBSQL.php';
class jenreList {
    
public function getJenre() {
    $mysqli = new DBSQL();
    $queryCity = "select `id_jenre`, `title_jenre` from `jenres`";
    $result = $mysqli->f_query($queryJenre);
    $myArray = $mysqli->myFetchArray($result);
    return $myArray;
}

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

