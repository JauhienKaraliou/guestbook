<?php
/**
 * Created by PhpStorm.
 * User: jauhien
 * Date: 11.12.14
 * Time: 16.04
 */
define('USER','root');
define('PASSWORD','1276547');
define('DSN', 'mysql:host=localhost; dbname=guestbook');

$templateFiles = array(
    'header'=>'tpl/header.html',
    'body'=>'tpl/body.html',
    'message'=>'tpl/message.html',
    'emptyMessage'=>'tpl/empty_message.html',
    'form'=>'tpl/form.html',
    'footer'=>'tpl/footer.html'
);

include 'inc/Builder.php';
include 'inc/DBStorage.php';
include 'inc/NewMessage.php';


$page = new Builder(USER, PASSWORD, DSN);
if($_POST) {
   $page->saveNewMessage();

}

echo $page->createPage($templateFiles);
//$page->checkGet();






/*
echo 'GET=';
var_dump($_GET);

echo FormData::invData('0');
*/
/*
$arr=array(
    'id_comment'=> '243',
    'name'=>'name',
    'comment'=>'some other comment',
    'email'=> 'sosdfasgfsagdsagadme@e.mail',
    'date_time'=> time(),
    'ip'=>$_SERVER['REMOTE_ADDR'],
    'client'=>'opeagaerhgqerhqhgerra-moz'
);

$com = new Query(USER,PASSWORD);
$a= $com->putComment($arr);
$allCom = $com->getComment();

var_dump($allCom);
echo '<br>'.$a;*/