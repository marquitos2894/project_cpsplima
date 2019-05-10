<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//GET
$app->get('/api/colegiados', function(Request $request, Response $response){
    
    try{
        $db = new db();
        $db=$db->conectar();
        $result = $db->prepare("call V_Alumnos");
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
        $result = $db->prepare("select * from alumno where id like '%{$param}%' or nombre like '%{$param}%' ");
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