function realizarCotizacion(){

    let cliente = $("#nombre_cliente").attr("id_cliente")
    let fecha = $("#fecha").val()
    let sucursal  = $("#sucursal").val()
    let comentario = $("#comentario").val()
    let tasa = $("#tasa").val()
    let direccion_cliente = $("#direccion_cliente").val()
    let correo_cliente = $("#correo_cliente").val()
    let telefono_cliente = $("#telefono_cliente").val()


    if(fecha == "" || fecha == null){
        Toast.fire({
            icon: 'error',
            title: "Selecciona una fecha"
          })
    }else if(cliente == null || cliente == ""){
        Toast.fire({
            icon: 'error',
            title: "Selecciona un cliente"
          })
    }else if(sucursal  == null || sucursal == ""){
        Toast.fire({
            icon: 'error',
            title: "Selecciona una sucursal"
          })
    }else{


        $.ajax({
            type: "POST",
            url: "../servidor/cotizaciones/procesar-cotizacion.php",
            data: {
                cliente, fecha, sucursal, comentario, tasa, direccion_cliente, correo_cliente, telefono_cliente
            },
            dataType: "JSON",
            success: function (response) {
                if(response.estatus == true){
                    Swal.fire({
                        icon: 'success',
                        html: `Remisión generada con exito`,
                        confirmButtonText: "Ver remisión",
                        
                    }).then((res)=>{
                        if(res.isConfirmed){
                            verRemision(response.id_remision)
                            traerTotales()
                        }
                    })
                }
                tabla.ajax.reload(null, true)
            }
        });
    }

}
