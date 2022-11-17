<?php
session_start();
if ($_POST) {
    include "../database/conexion.php";
    date_default_timezone_set('America/Matamoros');

    $id_sesion = $_SESSION["id"];
    $id_producto = $_POST['id_producto'];
    $codigo = $_POST["codigo"];
    $descripcion = $_POST["descripcion"];
    $categoria = $_POST["categoria"];
    $subcategoria = $_POST["subcategoria"];
    $cantidad = $_POST["cantidad"];

    if($cantidad !== ""){
        $fecha_ingreso = date("Y-m-d");

        $consulta = "SELECT COUNT(*) FROM detalle_salida_tmp WHERE usuario_id = ? AND producto_id = ?";
        $resp = $con->prepare($consulta);
        $resp->execute([$id_sesion, $id_producto]);
        $total = $resp->fetchColumn(); 
        $resp->closeCursor();
    
        
    
        if($total > 0){
    
            $consulta = "SELECT cantidad FROM detalle_salida_tmp WHERE usuario_id = ? AND producto_id = ?";
            $resp = $con->prepare($consulta);
            $resp->execute([$id_sesion, $id_producto]);
            $cant_actual = $resp->fetchColumn(); 
            $resp->closeCursor();
    
           
            $cantidad_nueva = $cant_actual + $cantidad;
         
            $update = "UPDATE detalle_salida_tmp SET cantidad = ? WHERE usuario_id = ? AND producto_id = ?";
            $resp = $con->prepare($update);
            $resp->execute([$cantidad_nueva, $id_sesion, $id_producto]);
            $resp->closeCursor();
    
            $last_id = $con->lastInsertId();
    
    
        }else{
            $insercion = "INSERT INTO detalle_salida_tmp(id, 
            codigo, 
            concepto, 
            producto_id, 
            cantidad, 
            usuario_id) VALUES(null,?,?,?,?,?)";
    
            $resp = $con->prepare($insercion);
    
            $resp->execute([$codigo, $descripcion, $id_producto, $cantidad, $id_sesion]);
    
            $resp->closeCursor();
    
            $last_id = $con->lastInsertId();
        }
    
        
       
        $response = array("status"=>true, "message"=> "Producto agregado correctamente", "id"=>$last_id);
    }else{
        $response = array("status"=>false, "message"=> "Ingresa una cantidad", "id"=>"");
    }
 
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

}



?>