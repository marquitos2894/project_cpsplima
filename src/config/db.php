<?php 

require_once 'configAPP.php';

class db{

    public function conectar(){
        try{
        $gbd = new PDO(SGBD,USER,PASS);
        $gbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            
        }
        return $gbd;
    }


}