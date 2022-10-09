function realizarVenta(){

    const loader = `<lottie-player src="./img/load.json" background="transparent"  speed="1"  style="width: 50px; height: 30px; color:#e9bd15" loop autoplay></lottie-player>`
    const btn_vender = document.querySelector("#btn-vender")

    btn_vender.innerHTML = loader

    let data = {
        cliente: cliente_id
    }

    $.ajax({
        type: "POST",
        url: "../servidor/nueva_orden/procesar-orden.php",
        data: data,
        dataType: "dataType",
        success: function (response) {
            
        }
    });


}