<?php
/**
 * Created by PhpStorm.
 * User: jauhien
 * Date: 20.12.14
 * Time: 15.46
 */

class NewMessage
{

    public $arr;

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

    public function getDefaultValues()
    {
        $dataToInsert['name'] = $this->arr['name'];
        $defVal['comment']=$this->arr['comment'];
        $defVal['email']=$this->arr['email'];
        return $defVal;
    }


} 