<?php

    include "../database/conexion.php";
    date_default_timezone_set('America/Matamoros');

    $producto_id = $_GET['product_id'];
    $tabla = "inventario";
  

    $folder_product = "P" . $producto_id;
    $folder = "../../static/img/productos/$folder_product";

    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    //print_r($_FILES);
    $countfiles = count($_FILES);

    $fi = new FilesystemIterator($folder, FilesystemIterator::SKIP_DOTS);
    $total_imagenes_inicial = iterator_count($fi);
  

    if($total_imagenes_inicial >= 3){
        $response = array("status"=>"error",
        "message"=>"Ya hay mas de 3 imagenes, borra una o mas",
        "files_uploads"=>$countfiles,"data"=>"null");   
     }else{

        for($i=0;$i<$countfiles;$i++){
           
            
            $fi = new FilesystemIterator($folder, FilesystemIterator::SKIP_DOTS);
            $total_imagenes = iterator_count($fi);

           
    
            if($total_imagenes >= 3){
                $data = array("status"=>"error", 
                "message"=>"No puedes subir mas de 3 imagenes",
                );
            }else{
                $arreglo_original = array("P1.jpg","P2.jpg","P3.jpg");

          //  $escaneo = array_values(array_diff(scandir($folder), array('.', '..')));
           

            $actual_files = array_values(array_diff(scandir($folder), array('.', '..')));
          
          //  array_shift($actual_files);
            

            $result = array_diff($arreglo_original, $actual_files);
           
          
           
            //echo json_encode($_FILES, JSON_UNESCAPED_UNICODE);

            if(count($result)!=0){
                $array_reverse = array_reverse($result);
                $nombre_nuevo = array_pop($array_reverse);
          
            }else{
                $nombre_nuevo = "No";
            }

     
            $_FILES["file$i"]['name'] = $nombre_nuevo;
           
            $filename = $_FILES["file$i"]['name'];

                if (move_uploaded_file($_FILES["file$i"]["tmp_name"], "$folder/".$_FILES["file$i"]['name'])) {

                    $update="UPDATE $tabla SET imagen = ? WHERE id =?";
                    $resp = $con->prepare($update);
                    $carp = $folder_product . "/P1";
                    $resp->execute([$carp, $producto_id]);
                    $resp->closeCursor();

                    $data[]= array("status"=>"success", "message"=>"Archivo(s) subidos correctamente",
                    "array_dif"=> $result,
                    "name file"=>$filename,
                    "images in folder"=>$total_imagenes );
                } else {
                    $data = array("status"=>"error", 
                "message"=>"No se pudo mover el archivo",
                "name file"=>$nombre_nuevo,
                "r"=> $result,
                "files in folder"=>$total_imagenes);
                } 
            }
    
    
           
     //       move_uploaded_file($_FILES['file']['tmp_name'][$i],'upload/'.$filename);
        }
        $response = array("files_uploads"=>$countfiles,
        "message"=>"Archivo(s) correctamente subidos",
        "data"=>$data,
        "status"=>"success");
     }

    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);


    /* */
?>