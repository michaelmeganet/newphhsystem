<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//get current address https://stackoverflow.com/questions/9504608/request-string-without-get-arguments
$uri_parts = explode('?',$_SERVER['REQUEST_URI'],2);
if (isset($_GET['page'])){
    $getPage = $_GET['page'];
    $pageMode = 'SCAN MODE';
    $link = $uri_parts[0].'?view='.$_GET['view'];
}else{
    $getPage = 'normal';
    $pageMode = 'KEYBOARD MODE';
    $link = $uri_parts[0].'?view='.$_GET['view'].'&page=scan';
}
