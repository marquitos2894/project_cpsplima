<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//GET
$app->get('/api/colegiados', function(Request $request, Response $response){
    
    try{
        $db = new db();
        $db=$db->conectar();
        $result = $db->prepare("SELECT * FROM ALUMNO limit 5");
        $result->execute();
        if($result->rowCount()>0){
        $colegiados=$result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($colegiados);
        }else{
            echo json_encode("No existen registros");
        }
        
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }

});

$app->get('/api/colegiados/{param}', function(Request $request, Response $response){
    $param = $request->getAttribute('param');
    try{
        $db = new db();
        $db=$db->conectar();
        //$result = $db->prepare("SELECT * FROM ALUMNO  WHERE colegiatura={$param} ");
        $param = explode(",",$param);
        if($param[0]=="Numero documento"){

            if($param[1]=="Colegiatura"){
                $result = $db->prepare("SELECT * FROM ALUMNO a WHERE a.colegiatura={$param[2]} LIMIT 10");
            }
            elseif($param[1]=="Doc. de identidad"){
                $result = $db->prepare("SELECT * FROM ALUMNO a WHERE a.Numero_Documento={$param[2]} LIMIT 10");
    
            }
        }

       elseif($param[0]=="Nombres y apellidos"){
            $result = $db->prepare("SELECT * FROM ALUMNO a WHERE a.Paterno LIKE '%{$param[1]}%' AND a.Materno LIKE '%{$param[2]}%' 
            AND a.Nombres LIKE '%{$param[3]}%' LIMIT 10");
        }

        $result->execute();
        if($result->rowCount()>0){
        $colegiados=$result->fetchAll(PDO::FETCH_ASSOC);
        echo $json = json_encode($colegiados);
        $error = json_last_error_msg();
    
        }else{
            echo json_encode("undefined");
        }
        
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }

});

$app->get('/api/codalumno/{param}', function(Request $request, Response $response){
    $param = $request->getAttribute('param');
    try{
        $db = new db();
        $db=$db->conectar();
        $result = $db->prepare("SELECT * FROM ALUMNO  WHERE Cod_Alumno={$param} ");
        $result->execute();
        if($result->rowCount()>0){
        $colegiados=$result->fetchAll(PDO::FETCH_ASSOC);
        echo $json = json_encode($colegiados);
        $error = json_last_error_msg();
    

        }else{
            echo json_encode("undefined");
        }
        
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }

});