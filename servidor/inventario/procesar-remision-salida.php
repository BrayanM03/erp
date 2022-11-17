<?php
session_start();
if ($_POST) {
    include "../database/conexion.php";
    date_default_timezone_set('America/Matamoros');


    $cliente_id = $_POST['cliente'];
    $sucursal = $_POST['sucursal'];
    $fecha = $_POST['fecha'];
    $hora = date("H:i a");
    $usuario_id = $_SESSION["id"];
    $usuario_nombre = $_SESSION["nombre"] . " ". $_SESSION["apellido"];
    $comentario = $_POST['comentario'];

    $datos_clientes =  obtenerDatosCliente($con, $cliente_id);
    if($datos_clientes == false){
        $cliente_name = 0;
    }else{

        $cliente_name = $datos_clientes["nombre"];
    }


    $insertar = "INSERT INTO salidas(id, fecha, hora, id_cliente, cliente_etiqueta, usuario_nombre, usuario_id, sucursal_id, comentario)
                             VALUES(null, ?,?,?,?,?,?,?,?)";
    $resp = $con->prepare($insertar);
    $resp->execute([$fecha, $hora, $cliente_id, $cliente_name, $usuario_nombre, $usuario_id, $sucursal, $comentario]); 
    $resp->closeCursor();
    
    $last_id = $con->lastInsertId();

    $comprobar = "SELECT COUNT(*) FROM detalle_salida_tmp WHERE usuario_id = ?";
    $re = $con->prepare($comprobar);
    $re->execute([$usuario_id]);
    $total = $re->fetchColumn();
    $re->closeCursor();

    if($total > 0){
        $traer = "SELECT * FROM detalle_salida_tmp WHERE usuario_id = ?";
        $res = $con->prepare($traer);
        $res->execute([$usuario_id]);

        while($row = $res->fetch()){

            $id = $row['id'];
            $codigo = $row['codigo'];
            $concepto = $row["concepto"];
            $producto_id = $row['producto_id'];
            $cantidad = $row["cantidad"];
            $usuario_id = $row['usuario_id'];

            $insertar_detalle = "INSERT INTO detalle_salida(id, codigo, concepto, producto_id, cantidad, salida_id, usuario_id)
                             VALUES(null, ?,?,?,?,?,?)";
            $respu = $con->prepare($insertar_detalle);
            $respu->execute([$codigo, $concepto, $producto_id, $cantidad, $last_id, $usuario_id]); 
            $respu->closeCursor();


            descontarInventario($con, $cantidad, $producto_id);


        }
        $res->closeCursor();

        $response = array("estatus" => true, "mensaje" => "Remision insertada", "id_remision" => $last_id);

        $truncate = "DELETE FROM detalle_salida_tmp WHERE usuario_id = ?";
        $rrsp = $con->prepare($truncate);
        $rrsp->execute([$usuario_id]);
        $rrsp->closeCursor();


    }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);

}

function descontarInventario($con, $cantidad, $producto_id){ 
    $select = "SELECT COUNT(*) FROM inventario WHERE id = ? ";
    $ree = $con->prepare($select);
    $ree->execute([$producto_id]);
    $cant = $ree->fetchColumn();
    $ree->closeCursor();

    if($cant >0){
        $select_stock = "SELECT stock FROM inventario WHERE id = ? ";
        $rees = $con->prepare($select_stock);
        $rees->execute([$producto_id]);
        $total = $rees->fetchColumn();
        $rees->closeCursor();

        $stock_restante = intval($total) - intval($cantidad);

        $updt = "UPDATE inventario SET stock = ? WHERE id = ? ";
        $rr = $con->prepare($updt);
        $rr->execute([$stock_restante,$producto_id]);
        $rr->closeCursor();
    }
}

function obtenerDatosCliente($con, $cliente_id){
    $queryCount = "SELECT count(*) FROM clientes WHERE id = ?";
    $resp = $con->prepare($queryCount);
    $resp->execute([$cliente_id]);
    $total = $resp->fetchColumn();

    if($total > 0){
        $selectStore = "SELECT * FROM clientes WHERE id = ?";
        $resp = $con->prepare($selectStore);
        $resp->execute([$cliente_id]);
        while ($row = $resp->fetch()) {
            $data = $row;
        }
        return $data;
    }else{
        return false;
    }
}


?>