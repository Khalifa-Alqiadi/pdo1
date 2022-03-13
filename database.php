<?php

class database{
    private $dsn;
    private $user;
    private $password;
    private $option;
    private $con;
    
    function __construct()
    {
        $this->dsn = 'mysql:host=localhost;dbname=products2';
        $this->user = 'root';
        $this->password = '';
        $this->option = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );

        try{
            $this->con = new PDO($this->dsn, $this->user, $this->password, $this->option);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        }
        catch(PDOException $e){
            echo "Failed To Connect " . $e->getMessage();
        }
        
    }

    public function getAllTable($field, $allTable, $where = NULL, $and = NULL, $orderField, $ordering = 'DESC', $limit = NULL){

        $getAll = $this->con->prepare("SELECT $field FROM $allTable $where $and ORDER BY $orderField $ordering $limit");

        $getAll->execute();

        $all = $getAll->fetchAll();

        return $all;

    }
    public function insertData($table, $values){
        $insert = $this->con->prepare("INSERT INTO $table $values");
        return $insert;
    }
    public function selectByID($table,$id){
        $stmt=$this->con->prepare("select * from $table where $id=?");
        $stmt->execute([$id]); 
        return $stmt->fetch();

    }
    public function updateData($table, $set, $where){
        $update = $this->con->prepare("UPDATE $table SET $set WHERE $where");
        return $update;
    }
    public function deleteRecord($from, $delete, $value){

        $statment = $this->con->prepare("DELETE FROM $from WHERE $delete = :zid");

        $statment->bindParam(":zid", $value);

        $statment->execute();

        return $statment;
    }
    public function redirectHome($TheMsg, $url = null, $seconds = 3){

        if($url === null){
            $url = 'index.php';
            $link = 'HomePage';
        }else{
            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){

                $url = $_SERVER['HTTP_REFERER'];
                $link = 'Previous Page';

            }else{
                
                $url = 'index.php'; 
                $link = 'HomePage';
            } 
        }

        echo "<div class='container'>";
        echo $TheMsg;
        echo "<div class='alert alert-info'>You Will Redirected To $link After $seconds Seconds.</div>";

            header("refresh:$seconds;url=$url");
            
            exit(); 

        echo "</div>";
    }

}

?>