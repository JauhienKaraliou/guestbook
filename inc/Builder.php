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
    public function __construct($user, $pasw, $dsn)
    {
        $this->dbh= new DBStorage($user, $pasw, $dsn);
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
    public function saveNewMessage()
    {
        $newMessage = new NewMessage();
        if($newMessage->checkForm()== null) {
            $dataToInsert = $newMessage->insertData();

            $this->dbh->putComment($dataToInsert);
        } else {
            $this->defaultValues = $newMessage-> getDefaultValues();
        }

    }


    public function createPage($templates)
    {
        $headerTemplate = file_get_contents($templates['header']);
        $header = str_replace("{{PAGE_TITLE}}", "guestbook", $headerTemplate);
        $bodyTemplate =  file_get_contents($templates['body']);
        $page = $header.$bodyTemplate;
        $messageTemplate = file_get_contents($templates['message']);

        $comments = $this->dbh->getComments();

        foreach ($comments as $c) {
            $message = str_replace('{{AUTHOR}}', $c['username'], $messageTemplate);
            $message = str_replace('{{DATE}}', $c['date_time'], $message);
            $message = str_replace('{{MESSAGE_TEXT}}', $c['comment'], $message);
            $page.= $message;
        }
        $formTemplate = file_get_contents($templates['form']);
        /*
        $defaultStatements = $this->defaultValues;
        $form = str_replace('{{DEFAULT_NAME}}',$defaultStatements['name'],$formTemplate);
        $form = str_replace('{{DEFAULT_EMAIL}}',$defaultStatements['email'],$form);
        $form = str_replace('{{DEFAULT_TEXT}}',$defaultStatements['text'],$form);
        $page.= $form;
        */
        $page.= $formTemplate;  //!!!!!!!!!!!!!!!!!!!!delete
        $footerTemplate = file_get_contents($templates['footer']);
        $page.= $footerTemplate;
        return $page;





    }


} 