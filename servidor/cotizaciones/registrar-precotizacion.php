<?php
session_start();
if ($_POST) {
    include "../database/conexion.php";
    date_default_timezone_set('America/Matamoros');

    $id_sesion = $_SESSION["id"];
    $id_producto = $_POST['id_producto'];
    $codigo = $_POST["codigo"];
    $descripcion = $_POST["descripcion"];
    //$categoria = $_POST["categoria"];
    $subcategoria = $_POST["subcategoria"];
    $cantidad = $_POST["cantidad"];
    $precio = $_POST["precio"];
    $descuento = $_POST["descuento"];
    

    if($cantidad !== ""){
        $fecha_ingreso = date("Y-m-d");

        $consulta = "SELECT COUNT(*) FROM detalle_cotizacion_tmp WHERE usuario_id = ? AND producto_id = ?";
        $resp = $con->prepare($consulta);
        $resp->execute([$id_sesion, $id_producto]);
        $total = $resp->fetchColumn(); 
        $resp->closeCursor();
    
        
    
        if($total > 0){
    
            $sel = "SELECT * FROM detalle_cotizacion_tmp WHERE producto_id = ? AND usuario_id = ?";
            $resps = $con->prepare($sel);
            $resps->execute([$id_producto, $id_sesion]);
            while($fila = $resps->fetch()){
                $id_actualizado = $fila["id"];
                $importe_actual = $fila["importe"];
                $cantidad_actual = $fila["cantidad"];
            }
            $resps->closeCursor();
    
           
            $cantidad_nueva = $cantidad_actual + $cantidad;
            $importe = $cantidad * $precio;
            $nuevo_importe = ($importe_actual + $importe) - $descuento;
         
            $update = "UPDATE detalle_cotizacion_tmp SET cantidad = ?, descuento =?, importe = ?  WHERE usuario_id = ? AND producto_id = ?";
            $resp = $con->prepare($update);
            $resp->execute([$cantidad_nueva, $descuento, $nuevo_importe, $id_sesion, $id_producto]);
            $resp->closeCursor();
    
            $last_id = $id_actualizado;
    
    
        }else{
            $importe = (floatval($precio) * intval($cantidad)) - $descuento;

            $insercion = "INSERT INTO detalle_cotizacion_tmp(id, 
            codigo, 
            concepto, 
            producto_id, 
            cantidad,
            precio_unit,
            descuento,
            importe, 
            usuario_id) VALUES(null,?,?,?,?,?,?,?,?)";
    
            $resp = $con->prepare($insercion);
    
            $resp->execute([$codigo, $descripcion, $id_producto, $cantidad, $precio, $descuento, $importe, $id_sesion]);
    
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