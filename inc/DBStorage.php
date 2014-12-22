<?php
/**
 * Created by PhpStorm.
 * User: jauhien
 * Date: 20.12.14
 * Time: 15.33
 */

class DBStorage
{

    public $dbh;


    /**
     * @param $user
     * @param $pasw
     */
    public function __construct($user, $pasw, $dsn) {

        try {
            $this->dbh = new PDO($dsn, $user, $pasw, array(PDO::ATTR_PERSISTENT));

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
        $stsh = $this->dbh->prepare("INSERT INTO cmnt (`id_comment`, `username`,`comment`, `email`, `date_time`, `ip`, `client`)
       VALUES (:id_comment, :username,  :comment, :email, :date_time, :ip, :client)");
        var_dump($arr);
        $stsh->execute($arr);
        echo $stsh->debugDumpParams();
        return;
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