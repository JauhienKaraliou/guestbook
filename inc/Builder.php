<?php
/**
 * Created by PhpStorm.
 * User: jauhien
 * Date: 20.12.14
 * Time: 15.31
 */

class Builder
{
    public $dbh;
    public $defaultValues;
    public function __construct($user,$pasw)
    {
        $this->dbh= new DBStorage($user, $pasw);
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
        $data = new NewMessage();
        if($data->readForm()==null) {
            $dataToInsert = $data->insertData();
            $this->dbh->putComment($dataToInsert);
        } else {
            $this->defaultValues = $data-> getDefaultValues();
        }

    }


    public function createPage($templates)
    {
        $headerTemplate = file_get_contents($templates['header']);
        $headerTemplate = str_replace("{{PAGE_TITLE}}", "guestbook", $header);
        $bodyTemplate =  file_get_contents($templates['body']);
        $page = $headerTemplate.$bodyTemplate;
        $messageTemplate = file_get_contents($templates['message']);

        $comments = $this->dbh->getComments();
        foreach ($comments as $c) {
            $message = str_replace('{{AUTHOR}}', $c['name'], $messageTemplate);
            $message = str_replace('{{DATE}}', $c['date_time'], $message);
            $message = str_replace('{{MESSAGE_TEXT}}', $c['comment'], $message);
            $page.= $message;
        }
        $formTemplate = file_get_contents($templates['form']);
        $defaultStatments = $this->defaultValues;
        $page.=




    }


} 