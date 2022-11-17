<?php
if ($_POST) {
    session_start();
    include "../database/conexion.php";
    date_default_timezone_set('America/Matamoros');

    $tipo = $_POST["tipo"];


if($tipo == "individual"){
    $precio_id = $_POST["id_precio"];
    $remov = "DELETE FROM precios_tmp WHERE id = ?";
    $resp = $con->prepare($remov);
   
    $resp->execute([$precio_id]);

    $resp->closeCursor();
   
    $response = array("status"=>true, "message"=> "Precio borrado correctamente");
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

}else if($tipo == "total"){
    $usuario_id = $_SESSION["id"];
    $remov = "DELETE FROM precios_tmp WHERE usuario_id = ?";
    $resp = $con->prepare($remov);
   
    $resp->execute([$usuario_id]);

    $resp->closeCursor();
   
    $response = array("status"=>true, "message"=> "Tabla vaciada correctamente");
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
    

}



?>