<?php
if ($_POST) {
    session_start();
    include "../database/conexion.php";
    date_default_timezone_set('America/Matamoros');

   
    $type = $_POST["type"];
    
    $user_id = $_SESSION["id"];

    function actualizarStocks($con, $id_producto, $user_id, $nuevo_stock){
     
        $consult = "SELECT stock FROM inventario WHERE id = ?";
        $rep = $con->prepare($consult);
        $rep->execute([$id_producto]);
        $stock_actual = $rep->fetchColumn();
        $rep->closeCursor();

        $stock_total = $stock_actual + $nuevo_stock;
        $est = "Activo";
        $updt = "UPDATE inventario SET stock = ?, estatus = ? WHERE id = ?";
        $rep = $con->prepare($updt);
        $rep->execute([$stock_total, $est, $id_producto]);
        $rep->closeCursor();

    }


    if($type == "insercion"){
 
        $fecha_insercion = date("Y-m-d H:i:s");
        $hora_insercion = date("H:i:s");
        $usuario_id = $_SESSION["id"];
        $sucursal_id = $_POST["sucursal_id"];
        $nombre_usuario = $_SESSION["nombre"] . " ". $_SESSION["apellido"];


        

        $consult = "SELECT COUNT(*) FROM detalle_entrada_tmp WHERE usuario_id = ?";
            $rep = $con->prepare($consult);
            $rep->execute([ $user_id]);
            $total = $rep->fetchColumn();


            if($total > 0){

                $insert = "INSERT INTO entradas(id, fecha, hora, usuario_nombre, usuario_id, sucursal_id) VALUES (null, ?,?,?,?,?)";
                $rep = $con->prepare($insert);
                $rep->execute([$fecha_insercion, $hora_insercion, $nombre_usuario, $usuario_id, $sucursal_id]);
                $rep->closeCursor();

                $last_id = $con->lastInsertId();

                


                $select = "SELECT * FROM detalle_entrada_tmp WHERE usuario_id = ?";
                $res = $con->prepare($select);
                $res->execute([$usuario_id]);

            
                while ($row = $res->fetch()) {

                    
                    $codigo = $row["codigo"];
                    $concepto = $row["concepto"];
                    $producto_id = $row["producto_id"];
                    $cantidad = $row["cantidad"];

                    //Insertando datos de remisison

                   actualizarStocks($con, $producto_id, $usuario_id, $cantidad);

                    $insercion_detalle = "INSERT INTO detalle_entrada(id, 
                    codigo,
                    concepto,
                    producto_id,
                    cantidad,
                    entrada_id,
                    usuario_id) VALUES(null, ?,?,?,?,?,?)";//:fecha, :serie_co, :serie_ev, :id, :tipo
                    $resp = $con->prepare($insercion_detalle);
                    $data = [$codigo, $concepto, $producto_id, $cantidad, $last_id, $usuario_id];

                    $resp->execute($data);
        
                    $response = array("mensj"=>"Se insertaron los productos correctamente, stock actualizado.",
                                      "data"=>$data,
                                      "status"=> true,
                                      "folio"=>$last_id
                                      );
                }
                
            }else{
                $response = array("mensj"=> "No hay productos en la tabla temporal...",
                              "status"=> false,
                              );
            }

        

    }

    if($type == "eliminacion"){
        $detalle_id = $_POST["id_detalle"];

            $eliminar = "DELETE FROM detalle_entrada_tmp WHERE id =?";
            $resp = $con->prepare($eliminar);
            $resp->execute([$detalle_id]);
            $resp->closeCursor();

            $response = array("mensj"=> "Producto eliminado correctamente",
                              "status"=> true,
                              );
                       
    
    }

    if($type == "validacion"){

            $producto_id = $_POST["id_producto"];
        
            $consult = "SELECT COUNT(*) FROM detalle_entrada_tmp WHERE producto_id = ? AND usuario_id = ?";
            $rep = $con->prepare($consult);
            $rep->execute([$producto_id, $user_id]);
            $total = $rep->fetchColumn();

            if($total > 0){
                $response = array("status" =>true);
            }else{
                $response = array("status" =>false);
            }
    
        
    }

    if($type== "actualizacion"){

        $id_serie = $_POST["serie"];
        $producto_id = $_POST["producto"];
        $serie_condensador = $_POST["serie_cond"]; 
        $serie_evaporizador = $_POST["serie_evap"];
        $fecha_compra = $_POST["fecha_compra"];

        $validate1 = validarSerieRepetidad($con, $serie_condensador, $producto_id);
        $validate2 = validarSerieRepetidad($con, $serie_evaporizador, $producto_id);

        if($validate1 == true || $validate2 == true){

            $eliminar = "UPDATE series SET fecha_compra = ?, serie_condensador = ?, serie_evaporizador = ? WHERE id =?";
            $resp = $con->prepare($eliminar);
            $resp->execute([$fecha_compra, $serie_condensador, $serie_evaporizador, $id_serie]);
            $resp->closeCursor();

            $response = array("mensj"=> "Series actualizadas correctamente",
                              "status"=> true,
                              );

        }else{

            $eliminar = "UPDATE series SET fecha_compra = ? WHERE id =?";
            $resp = $con->prepare($eliminar);
            $resp->execute([$fecha_compra, $id_serie]);
            $resp->closeCursor();

            $response = array("mensj"=> "Las dos son las mismas series, pero ok ...",
                              "status"=> false,
                              );
        } 

    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);

}

?>