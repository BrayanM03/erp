function realizarVenta(){

    $.ajax({
        type: "POST",
        url: "../servidor/nueva-orden/comprobar-tabla.php",
        data: "data",
        dataType: "JSON",
        success: function (responsess) {
            if(responsess.status){
                const loader = `<lottie-player src="./img/load.json" background="transparent"  speed="1"  style="width: 50px; height: 30px; color:#e9bd15" loop autoplay></lottie-player>`
                const btn_vender = document.querySelector("#btn-vender")
                const cliente_id = $("#nombre_cliente").attr("id_cliente")
                const neto = $("#neto").text()
                btn_vender.innerHTML = loader
            
                
            
                Swal.fire({
                    width:"700px",
                    html: `
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <span id="metodo_pago" metodo="null">Elige un metodo de pago: </span>
                                    <div class="row justify-content-between mt-3" attr="https://www.flaticon.com/free-icons/bank">
                                        <div class="col-12 col-md-3 metodo_pago_opcion" id="opcion_efectivo" onclick="elegirMetodoPago(1)">
                                            <img id="icon-selected-efectivo" class="icon_selected d-none" src="./img/metodos_pago/selected.png" style="width: 30px;">
                                            <img class="img-responsive" src="./img/metodos_pago/cash.png" style="width: 80px;">
                                            Efectivo
                                        </div>
            
                                        <div class="col-12 col-md-3 metodo_pago_opcion" id="opcion_tarjeta" onclick="elegirMetodoPago(2)">
                                            <img id="icon-selected-tarjeta" class="icon_selected d-none" src="./img/metodos_pago/selected.png" style="width: 30px;">
                                            <img class="img-responsive" src="./img/metodos_pago/debit-card.png" style="width: 80px;">
                                            Tarjeta
                                        </div>
            
                                        <div class="col-12 col-md-3 metodo_pago_opcion" id="opcion_transferencia" onclick="elegirMetodoPago(3)">
                                            <img id="icon-selected-transferencia" class="icon_selected d-none" src="./img/metodos_pago/selected.png" style="width: 30px;">                               
                                            <img class="img-responsive" src="./img/metodos_pago/online-payment.png" style="width: 80px;">
                                            Transferencia
                                        </div>
                                    </div>
                                </div> 
                            </div>
            
                            <div class="row mt-2">
                                    <div class="col-12 col-md-12">
                                    <span class="">Total a pagar: </span>
                                    <span id="total-a-pagar"><b>${neto}</b></span>
                                    </div> 
                                </div>
            
            
                            <div class="d-none" id="area_metodo_efectivo">
                                
            
                                <div class="row mt-2">
                                    <div class="col-12 col-md-12">
                                    <span class="texto-prepago">Ingresa la cantidad recibida: </span>
                                    <input type="number" placeholder="0.00" id="cantidad_recibida" class="cantidad_recibida">
                                    </div> 
                                </div>
            
                                <div class="row mt-3">
                                    <div class="col-12 col-md-12">
                                    <span class="texto-prepago">Cantidad a devolver: </span>
                                    <input type="text" placeholder="0.00" id="cantidad_devolver" class="cantidad_recibida" disabled>
                                </div> 
                            </div>    
                        </div>
                        </div>
                    `,
                    didOpen: ()=>{
                   
                        let cantidad_recibida = $("#cantidad_recibida");
                        cantidad_recibida.keyup("on", ()=>{
                            
                            let recibi = parseFloat(cantidad_recibida.val());
                            let cant_neto = parseFloat(neto.replace('$', '').replace(',',''))
            
                            let devolver =  recibi - cant_neto;
                            let devolver_redondeado = Number(devolver.toFixed(2));
                            if(devolver_redondeado < 0){

                                $("#cantidad_devolver").val("Cantidad inferior al total a pagar");
                            }else{
                                let format_MXN = Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(devolver_redondeado)
                                $("#cantidad_devolver").val(format_MXN);

                            }
                            
                        })
            
            
                    },
                    preConfirm: function() {
                        let metodo_pago_opcion = $("#metodo_pago").attr("metodo")
                        if(metodo_pago_opcion == "null") {
                            Swal.showValidationMessage(
                                `Elige un metodo de pago`
                              )
                        }
                    },
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Pagar",
                    //confirmButtonColor: "gray", 
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                }).then((resp) =>{
                    if(resp.isConfirmed){

                        let metodo_pago = $("#metodo_pago").attr("metodo");
                        let data = {
                            cliente: cliente_id,
                            metodo_pago: metodo_pago
                        }
                        
            
                        $.ajax({
                            type: "POST",
                            url: "../servidor/nueva-orden/procesar-orden.php",
                            data: data,
                            dataType: "JSON",
                            success: function (response) {
                                if(response.status == true){
                                    Swal.fire("¡Vendido!", "Venta realizada con exito", "success")
                                    $.ajax({
                                        type: "POST",
                                        url: "../servidor/nueva-orden/eliminar-preventa.php",
                                        data: "data",
                                        dataType: "JSON",
                                        success: function () {
                                            traerCarrito();
                                            printTicket(response.id_orden)
                                            $("#subtotal").text("$0.00")
                                            $("#descuento").text("$0.00")
                                            $("#iva").text("$0.00")
                                            $("#neto").text("$0.00")
                                        }
                                    });
                                }
                            }
                        });
                    }
            
                    btn_vender.innerHTML = "vender";
                })
            }else{
                Swal.fire(":(", "Agrega productos al carrito", "warning")
            }
        }
    });

}


function elegirMetodoPago(metodo){

    let metodo_p = $("#metodo_pago");
    let opcion_efectivo = $("#opcion_efectivo");
    let opcion_tarjeta = $("#opcion_tarjeta");
    let opcion_transferencia = $("#opcion_transferencia");
    let area_metodo_efectivo = $("#area_metodo_efectivo");

    let icon_efectivo_sel = $("#icon-selected-efectivo")
    let icon_tarjeta_sel = $("#icon-selected-tarjeta")
    let icon_transferencia_sel = $("#icon-selected-transferencia")

    opcion_efectivo.removeClass("selected_method");
    opcion_tarjeta.removeClass("selected_method");
    opcion_transferencia.removeClass("selected_method");

    //Efectivo
    if(metodo == 1) {
        opcion_efectivo.addClass("selected_method")
        icon_efectivo_sel.removeClass("d-none")
        area_metodo_efectivo.removeClass("d-none")
        metodo_p.attr("metodo", "Efectivo")
        if(!icon_tarjeta_sel.hasClass("d-none")){
            icon_tarjeta_sel.addClass("d-none")
        }

        if(!icon_transferencia_sel.hasClass("d-none")){
            icon_transferencia_sel.addClass("d-none")
        }


    }else if(metodo == 2) {
        opcion_tarjeta.addClass("selected_method")
        icon_tarjeta_sel.removeClass("d-none");
        area_metodo_efectivo.addClass("d-none")
        metodo_p.attr("metodo", "Tarjeta")
        if(!icon_efectivo_sel.hasClass("d-none")){
            icon_efectivo_sel.addClass("d-none")
        }

        if(!icon_transferencia_sel.hasClass("d-none")){
            icon_transferencia_sel.addClass("d-none")
        }
    }else if(metodo == 3) {
        opcion_transferencia.addClass("selected_method")
        icon_transferencia_sel.removeClass("d-none")
        area_metodo_efectivo.addClass("d-none")
        metodo_p.attr("metodo", "Transferencia")

        if(!icon_tarjeta_sel.hasClass("d-none")){
           icon_tarjeta_sel.addClass("d-none")
        }

        if(!icon_efectivo_sel.hasClass("d-none")){
            icon_efectivo_sel.addClass("d-none")
        }
    }


}

function printTicket(id_orden){
    window.open("./vistas/nueva_orden/ticket.php?id="+id_orden, '_blank')

}