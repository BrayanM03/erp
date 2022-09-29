function agregarProducto(){

    console.log( arrayImages);

    let codigo = document.getElementById("codigo").value
    let valid_codigo = document.getElementById("small_response").getAttribute("valid")
  
    let categoria = document.getElementById("categoria").value
    let subcategoria = document.getElementById("subcategoria").value
    let cantidad = +document.getElementById("cantidad").value //Aqui pongo el mas para hacer la cantidad un "number"
    let sucursal = document.getElementById("sucursal").value
    let costo = document.getElementById("costo").value
    let precio = document.getElementById("precio-base").value
    let tasa = document.getElementById("impuesto").value
    let impuesto = $("#impuesto").attr("impuesto")
    let precio_total = document.getElementById("precio-total").value
    let descripcion = document.getElementById("descripcion").value

     //Opcionales
     let modelo = document.getElementById("modelo").value
     let marca = document.getElementById("marca").value    
     let upc = document.getElementById("upc").value
     let sat = document.getElementById("sat").value




    let hasCantidadInt = Number.isInteger(cantidad);
 
    if(valid_codigo == "false"){
        Toast.fire({
            icon: 'error',
            title: 'Hay un problema con el codigo'
          })
     }else if(categoria == "null"){
        Toast.fire({
            icon: 'error',
            title: 'Selecciona una categoria'
          })
     }

     else if(subcategoria == "null"){
        Toast.fire({
            icon: 'error',
            title: 'Selecciona una categoria'
          })
    }

    else if(cantidad === "" || cantidad < 0){
        Toast.fire({
            icon: 'error',
            title: 'Ingresa una cantidad igual o mayor a 0'
          })
    }

    else if(hasCantidadInt == false){
        Toast.fire({
            icon: 'error',
            title: 'Ingresa una cantidad entera'
          })
    }
  
    else if(costo == ""){
        Toast.fire({
            icon: 'error',
            title: 'Ingresa un costo'
          })
    }

    else if(precio == ""){
        Toast.fire({
            icon: 'error',
            title: 'Ingresa un precio'
          })
    }

    else{

     datosForm = new FormData();
     datosForm.append("codigo", codigo);
     datosForm.append("categoria", categoria); 
     datosForm.append("subcategoria", subcategoria); 
     datosForm.append("cantidad", cantidad);
     datosForm.append("sucursal", sucursal);
     datosForm.append("costo", costo);
     datosForm.append("precio", precio);
     datosForm.append("tasa", tasa);
     datosForm.append("impuesto", impuesto);
     datosForm.append("precio_total", precio_total);
     datosForm.append("descripcion", descripcion);
     
     datosForm.append("modelo", modelo);
     datosForm.append("marca", marca);
     datosForm.append("upc", upc);
     datosForm.append("sat", sat);

     
     $.ajax({
        type: "POST",
        url: "../servidor/inventario/registrar-producto.php",
        processData: false,
        contentType: false,
        data: datosForm,
        dataType: "JSON",
        success: function (response) {
            if(response.status == true){

                //Agregando imagenes

                if(arrayImages.length > 0){
                    let imgData = new FormData();
              

                    for (let i = 0; i < arrayImages.length; i++) {
                        

                        const element = arrayImages[i];
                        imgData.append(`file${i}`, element)
                        
                    }

                    fetch(`../servidor/inventario/subir-imagen.php?product_id=${response.id}`, {
                        method: "POST",
                        body: imgData
                    }).then(res => res.json()).then(data =>{
                        console.log(data);
                    })

                }

           
                Swal.fire({
                    icon: "success",
                    html: "<b>"+ response.message + "</b>",
                    allowOutsideClick: false,
                    confirmButtonText: "Entendido"
                }).then((response)=>{
                    location.reload();
                })
            }
        }
    });
     
     

    }
     

     

}

const Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })


async function validarCodigo(codigo) {

    if(codigo == "" || codigo.length == 0){

        $("#codigo").css("border", "1px solid red")
        $("#small_response").css("color", "red").removeClass("d-none").attr("valid", "false").text("Agrega un codigo")

    }else if (/\s/.test(codigo)) {
        $("#codigo").css("border", "1px solid red")
        $("#small_response").css("color", "red").removeClass("d-none").attr("valid", "false").text("No puede haber espacios en el codigo")
    }else{
        let data = {"codigo": codigo};

        console.log(data);
         
        await fetch('../servidor/inventario/validar-codigo.php',{
         method: 'POST',
         body: JSON.stringify(data),
         headers:{
             'Accept': 'application/json',
             'Content-Type': 'application/json'
           }
        })
       .then(response => response.json())
       .then(data => {
         console.log(data)
         if(data.status == true){
             $("#codigo").css("border", "1px solid green")
             $("#small_response").css("color", "green").removeClass("d-none").attr("valid", "true").text("Codigo disponible")
         }else if(data.status ==false){
             $("#codigo").css("border", "1px solid red")
             $("#small_response").css("color", "red").removeClass("d-none").attr("valid", "false").text("Codigo en uso")
         }
        
     });

    }

   

}  





  