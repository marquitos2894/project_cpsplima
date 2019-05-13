<?php 

require_once 'configAPP.php';

class db{

    public function conectar(){
        try{
        $gbd = new PDO(SGBD,USER,PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
       
        $gbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            
        }
        return $gbd;
    }


}