<?php
  
  session_start();
  include '../database/conexion.php';
  
  date_default_timezone_set("America/Matamoros");
  $usuario_id = $_SESSION["id"];
  $detalle_id = $_POST["id_detalle"];
  $tipo = $_POST["tipo"];
  $response = array();

    $comprobar = "SELECT COUNT(*) FROM carrito_compra WHERE id =? AND usuario_id = ?";
    $resp = $con->prepare($comprobar);
    $resp->execute([$detalle_id, $usuario_id]);
    $total = $resp->fetchColumn();

    if($total > 0){
        $select = "SELECT * FROM carrito_compra WHERE id=? AND usuario_id = ?";
        $resp = $con->prepare($select);
        $resp->execute([$detalle_id, $usuario_id]);
        
        while ($row = $resp->fetch(PDO::FETCH_OBJ)) {
            //print_r($row['importe'])
            $id_producto = $row->producto_id;
            
            $sel = "SELECT * FROM inventario WHERE id = ?";
                $res = $con->prepare($sel);
                $res->execute([$id_producto]);

                while ($fila = $res->fetch(PDO::FETCH_OBJ)) {
                    $impuesto_ind = $fila->impuesto;
                    $stock_actual = $fila->stock;
                }

            $importe = floatval($row->importe);
            $iva =  floatval($row->impuesto);
            if($tipo == "mas"){    
                $cantidad_nueva = intval($row->cantidad)+1;
                if($cantidad_nueva > $stock_actual){
                    
                    $status = false;
                    $mensaje = "Cantidad supera el stock actual";
                }else{
                    $status = true;
                    $importe_total = $importe + floatval($row->precio);
                    $iva_total = $iva + $impuesto_ind;
                    $mensaje = "Elemento agregado";

                }
            }else{
                $cantidad_nueva = intval($row->cantidad)-1;
                if($cantidad_nueva < 0){
                    $status = false;
                    $mensaje = "Cantidad inferior a 0";
                }else{
                    $status = true;
                    $importe_total = $importe - floatval($row->precio);
                    $iva_total = $iva - $impuesto_ind;
                    $mensaje = "Elemento retirado";

                }
            }
            
            if($status ==true){
                $upd = "UPDATE carrito_compra SET cantidad = ?, impuesto = ?, importe = ? WHERE id = ?";
                $ress= $con->prepare($upd);
                $ress->execute([$cantidad_nueva, $iva_total, $importe_total, $detalle_id]);
    
                //print_r($row);
                $response["iva"] = $iva_total;
                $response["importe"] = $importe_total;
                $response["data"][] = $row;
            }else{
                $response["iva"] = $iva;
                $response["importe"] = $importe;
                $response["data"][] = $row;

            }

            
        }

        

        $response["status"] = $status;
        $response["message"] = $mensaje;
    }else{
        $response["data"] = [];
        $response["status"] = false;
        $response["message"] = "No se pudo cambiar la cantidad";
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);




?>