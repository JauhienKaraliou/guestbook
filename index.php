<?php
/**
 * Created by PhpStorm.
 * User: jauhien
 * Date: 11.12.14
 * Time: 16.04
 */
class Message /**
 *
 */
{
    public static $numberOfMessages = 0;

    public function __construct()
    {
        //self::$numberOfMessages++;
    }


}


class FormData /**
 *
 */
{
    public $arr;
    public function __construct()
    {

    }
    public static  function invData($i)
    {
        $eMes = array(
            '0'=>'all clear!',
            '1'=>'invalid name filled-in',
            '2'=>'invalid e-mail filled-in',
            '3'=>'invalid comment',
            '4'=>'invalid CAPTCHA'
        );
        return $eMes[$i];
    }

    public function readForm()
    {

        $errMess = null;
        if (!isset($_POST['name'])) {
            $errMess .= self::invData('1');
        } else {
            $this->arr['name'] = htmlspecialchars($_POST['name']); //sanitize!
        }
        if (!isset($_POST['email'])) {
            $errMess .= self::invData('2');
        } else {
            $this->arr['email'] = htmlspecialchars($_POST['email']); //sanitize!
        }
        if (!isset($_POST['comment'])) {
            $errMess .= self::invData('3');
        } else {
            $this->arr['comment'] = htmlspecialchars($_POST['comment']); //sanitize!
        }
        if (!isset($_POST['captcha'])) {
            $errMess .= self::invData('4');
        } else {
            $this->arr['captcha'] = htmlspecialchars($_POST['captcha']); //sanitize! check captcha
        }
        return $errMess;
    }
    public function insertData()
    {
        $dataToInsert=array();
        $dataToInsert['id_comment']=time();
        $dataToInsert['name'] = $this->arr['name'];
        $dataToInsert['comment']=$this->arr['comment'];
        $dataToInsert['email']=$this->arr['email'];
        $dataToInsert['date_time']=date("Y-m-d H:i:s");
        $dataToInsert['ip'] =  $_SERVER['REMOTE_ADDR']; //unsafe
        $dataToInsert['client']=$_SERVER['HTTP_USER_AGENT']; //unsafe!
        return $dataToInsert;
    }

    public function defaultValues()
    {
        $dataToInsert['name'] = $this->arr['name'];
        $defVal['comment']=$this->arr['comment'];
        $defVal['email']=$this->arr['email'];
        return $defVal;
    }

}

class Query /**
 *
 */
{
    public $user;
    public $pasw;
    public $dbh;
    public $arr;

    /**
     * @param $user
     * @param $pasw
     */
    public function __construct($user, $pasw) {
        $this->user = $user;
        $this->pasw = $pasw;
        try {
            $this->dbh = new PDO('mysql:host=localhost; dbname=guestbook',$this->user, $this->pasw, array(PDO::ATTR_PERSISTENT));

        } catch (PDOException $e) {
            print "Error:".$e->getMessage().'<br>';
            die();
        }
    }

    /**
     * @param $arr
     * @return mixed
     */
    public function putComment ($arr)
    {
        $stsh = $this->dbh->prepare("INSERT INTO cmnt (`id_comment`,`name`,`comment`, `email`, `date_time`, `ip`, `client`)
       VALUES ( :id_comment, :name, :comment, :email,:date_time, :ip,:client)");
        $a = $stsh->execute($arr);
        return $a;
    }

    /**
     * @return array
     */
    public function getComment() {

        $querySelect = 'SELECT * FROM cmnt';
        $commentList = $this->dbh->query($querySelect, PDO::FETCH_ASSOC)->fetchAll();
        return $commentList;
    }

    /**
     *
     */
    public function deleteComment() {

    }




}
class Paginator /**
 *
 */
{
    public static $numPage;
    public static $quanMess;
    public static function numPage()
    {

    }

    public static function quanMess()
    {

    }

}

class Capcha /**
 *
 */
{

}

class Builder /**
 *
 */
{
    public $dbh;
    public $defVal;
    public function __construct($user,$pasw)
    {
        $this->dbh= new Query($user, $pasw);
    }

    public function __destruct()
    {

    }
/*
    public function __toString()
    {

    }
*/
    public function getCont($file)
    {
        $cont = file_get_contents($file);

    }

    public function checkPost()
    {
        if($_POST) {
            return true;
        } else {
            return null;
        }

    }
    /*
    public static function checkGet()
    {
        $inputErrorMessageOnPage=0;
        $formDefaultText=array();

        if($_GET){
            if (isset($_GET['numPage'])) {
                $numPage = htmlspecialchars($_GET['numPage']);   //sanitize!
                Paginator::numPage($numPage);
            }
            if (isset($_GET['quanMess'])) {
                $quanMess = htmlspecialchars($_GET['quanMess']);   //sanitize!
                Paginator::quanMess($quanMess);
            }
        } else {
            return null;
        }
    }
*/
    /**
     * @param $user
     * @param $pasw
     */
    public function newMess()
    {
        $data = new FormData();
        if($data->readForm()==null) {
            $dataToInsert = $data->insertData();
            $this->dbh->putComment($dataToInsert);
        } else {
            $this->defVal = $data-> defaultValues();
        }

    }

    public function getAllMessage()
    {
        $comms=$this->dbh->getComment();
        var_dump($comms);
    }

    public function show()
    {

    }

}


define('USER','root');
define('PASSWORD','1276547');

$page = new Builder(USER, PASSWORD);
$post = $page->checkPost();
if($post) {
    $page->newMess();
}
echo '123';
$page->getAllMessage();
$page->show();
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