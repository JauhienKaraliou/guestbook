<?php
/**
 * Created by PhpStorm.
 * User: jauhien
 * Date: 20.12.14
 * Time: 15.33
 */

class DBStorage
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
    public function getComments() {

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