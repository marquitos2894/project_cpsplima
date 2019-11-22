<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$c = new \Slim\Container();
$c['errorHandler'] = function ($c){
    return function ($request, $response, $exception) use ($c){
        $error = array('error'=> $exception->getMessage());
        return $c['response']
        ->withStatus(500)
        ->withHeader('Content-Type','application/json')
        ->write(json_encode($error));
    };
};




$app = new \Slim\App($c);

$app->get('/api/colegiados', function(Request $request, Response $response, $args){
    
    try{
        $db = new db();
        $db=$db->conectar();
        $result = $db->prepare("SELECT * FROM ALUMNO a WHERE a.cod_matricula LIKE '00%'  limit 5");
        $result->execute();
        if($result->rowCount()>0){
        $colegiados=$result->fetchAll(PDO::FETCH_ASSOC);
        echo $json = json_encode($colegiados);
        }else{
            echo json_encode("No existen registros");
        }
        
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }

});

$app->get('/api/colegiados/{param}', function(Request $request, Response $response,$args){

    $param = $request->getAttribute('param');
    try{
        $db = new db();
        $db=$db->conectar();
        //$result = $db->prepare("SELECT * FROM ALUMNO  WHERE colegiatura={$param} ");
        $param = explode(",",$param);
        if($param[0]=="Numero documento"){

            if($param[1]=="Colegiatura"){
                $result = $db->prepare("SELECT * FROM ALUMNO a WHERE a.cod_matricula={$param[2]} AND a.cod_matricula LIKE '00%' LIMIT 10");
            }
            elseif($param[1]=="Doc. de identidad"){
                $result = $db->prepare("SELECT * FROM ALUMNO a WHERE a.Numero_Documento={$param[2]} AND a.cod_matricula LIKE '00%' LIMIT 10");
    
            }
        }

       elseif($param[0]=="Nombres y apellidos"){
            $result = $db->prepare("SELECT * FROM ALUMNO a WHERE a.Paterno LIKE '%{$param[1]}%' AND a.cod_matricula LIKE '00%'  AND a.Materno LIKE '%{$param[2]}%' 
           AND a.cod_matricula LIKE '00%' AND a.Nombres LIKE '%{$param[3]}%' AND a.cod_matricula LIKE '00%' LIMIT 10");
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

$app->get('/api/codalumno/{param}', function(Request $request, Response $response, $args){
    $param = $request->getAttribute('param');
    try{
        $db = new db();
        $db=$db->conectar();
        $result = $db->prepare("SELECT * FROM ALUMNO  WHERE Cod_Matricula={$param} ");
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

$app->get('/api/codalumno_colegiados/{param}', function(Request $request, Response $response, $args){
    $param = $request->getAttribute('param');
    try{
        $db = new db();
        $db=$db->conectar();
        $result = $db->prepare("CALL consulta_colegiadosnuevo({$param})");
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
