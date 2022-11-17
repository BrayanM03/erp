<?php
if ($_POST) {
    session_start();
    include "../database/conexion.php";
    date_default_timezone_set('America/Matamoros');

    $precio_id = $_POST["id_precio"];
    $remov = "DELETE FROM precios WHERE id = ?";
    $resp = $con->prepare($remov);
   
    $resp->execute([$precio_id]);

    $resp->closeCursor();
   
    $response = array("status"=>true, "message"=> "Precio borrado correctamente");
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

    

}



?>