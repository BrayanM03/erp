function dibujarCanvas(){

let canvasImagen1 = document.getElementById('canvas1')
let canvasImagen2 = document.getElementById('canvas2')
let canvasImagen3 = document.getElementById('canvas3')

let btn_eliminar1 = document.getElementById('btn-delete1')
let btn_eliminar2 = document.getElementById('btn-delete2')
let btn_eliminar3 = document.getElementById('btn-delete3')

let ctx1 = canvasImagen1.getContext('2d')
let ctx2 = canvasImagen2.getContext('2d')
let ctx3 = canvasImagen3.getContext('2d')

let imgElement1 = document.createElement('img')
let imgElement2 = document.createElement('img')
let imgElement3 = document.createElement('img')

imgElement1.src = `./img/Productos/P${id_producto}/P1.jpg`
imgElement2.src = `./img/Productos/P${id_producto}/P2.jpg`
imgElement3.src = `./img/Productos/P${id_producto}/P3.jpg`

flag1 = true;
flag2 = true;
flag3 = true;



imgElement1.addEventListener("error", (e)=>{
    imgElement1.src = `./img/Productos/NA.jpg`
    flag1 = false;

})
imgElement2.addEventListener("error", (e)=>{
    imgElement2.src = `./img/Productos/NA.jpg`
    flag2 = false;

})
imgElement3.addEventListener("error", (e)=>{
    imgElement3.src = `./img/Productos/NA.jpg`
    flag3 = false;
}) 


imgElement1.addEventListener('load', function(e) {
    if(flag1== true){     
        ctx1.drawImage(imgElement1, 65, 30, 150, 100)
        btn_eliminar1.classList.remove('d-none')
    }else if(flag1== false){
        ctx1.drawImage(imgElement1, 65, 30, 150, 87)
    }
})

imgElement2.addEventListener('load', function(e) {
    if(flag2== true){     
    ctx2.drawImage(imgElement2, 65, 30, 150, 100)
    btn_eliminar2.classList.remove('d-none')
    
}else if(flag2 == false){
    ctx2.drawImage(imgElement2, 65, 30, 150, 87)
    }
})

imgElement3.addEventListener('load', function(e) {
    if(flag3== true){     
     ctx3.drawImage(imgElement3, 65, 30, 150, 100)
     btn_eliminar3.classList.remove('d-none')
     
    }else if(flag3== false){
        ctx3.drawImage(imgElement3, 65, 30, 150, 87)
    }
})
}

function remplazarImagen(id) { 
    let contenedorCanvas1 = document.getElementById(`contenedor-canvas-${id}`)
    let input_file = document.getElementById(`input-file-${id}`);

    input_file.click()
    input_file.addEventListener("change", function() {
        var reader = new FileReader();
    
        reader.addEventListener("loadend", function(arg) {
          var src_image = new Image();

          contenedorCanvas1.innerHTML = `
             <div class="container-lottier-player">
             <lottie-player src="./img/load-2.json" background="transparent"  speed="1"  style="width: 90px; height: 90px;" loop autoplay></lottie-player>
             </div>
          
          `
        setTimeout(function(){
                contenedorCanvas1.innerHTML = `
                <div class="btn-delete-img d-none" id="btn-delete${id}" onclick="eliminarImagen(${id})">
                     <i class="fa-solid fa-x"></i>
                </div>
                    <canvas id="canvas${id}" onclick="remplazarImagen(${id})" action="#">
                                    
                     <div class="fallback d-none">
                     <input type="file" name="file" id="input-file-${id}" accept="image/*">
                    </div>
                </canvas>
                
                `;

                let canvas = document.getElementById(`canvas${id}`)
                let context = canvas.getContext("2d");
                let btn_del = document.getElementById(`btn-delete${id}`)

                canvas.height = src_image.height;
                canvas.width = src_image.width;
                context.drawImage(src_image, 20, 20, src_image.width-50,src_image.height-30);
                var imageData = canvas.toDataURL("image/png"); 
                uploadCanvas(imageData, id);
                btn_del.classList.remove('d-none')
              //}
        },2500)
          
          src_image.src = this.result;
        });
    
        reader.readAsDataURL(this.files[0]);
      });

 }



 function uploadCanvas(dataURL, indicador) {
    var blobBin = atob(dataURL.split(',')[1]);
    var array = [];
    for(var i = 0; i < blobBin.length; i++) {
        array.push(blobBin.charCodeAt(i));
    }
    var file=new Blob([new Uint8Array(array)], {type: 'image/png'});
    var formdata = new FormData();
    formdata.append("image", file);
    formdata.append("id_producto", id_producto);
    formdata.append("indicador", indicador);

    $.ajax({ 
        type: "POST",
        enctype: "multipart/form-data",
        url: "../servidor/inventario/remplazar-subir-imagen.php",
        data: formdata,
        processData:false,
        contentType:false,
        dataType: "JSON",
        encode: true,
        success: function (response) {
            if(response.status == false){
                Toast.fire({
                    icon: 'error',
                    title: response.mensaje
                  })

            }else{
                Toast.fire({
                    icon: 'success',
                    title: response.mensaje
                  })
            }
        }
    });
}

function eliminarImagen(id){
    let contenedorCanvas= document.getElementById(`contenedor-canvas-${id}`)

    contenedorCanvas.innerHTML = `
             <div class="container-lottier-player">
             <lottie-player src="./img/load-2.json" background="transparent"  speed="1"  style="width: 90px; height: 90px;" loop autoplay></lottie-player>
             </div>
          
          `
    

    setTimeout(function(){

        $.ajax({
            type: "POST",
            url: "../servidor/inventario/eliminar-imagen.php",
            data: {"id_img": id, "id_producto": id_producto},
            dataType: "JSON",
            success: function (response) {
                if(response.status == false){
                    Toast.fire({
                        icon: 'error',
                        title: response.mensaje
                      })

                }else{
                    Toast.fire({
                        icon: 'success',
                        title: response.mensaje
                      })
                }
            }
        });

        contenedorCanvas.innerHTML = `
        <div class="btn-delete-img d-none" id="btn-delete${id}" onclick="eliminarImagen(${id})">
             <i class="fa-solid fa-x"></i>
        </div>
            <canvas id="canvas${id}" onclick="remplazarImagen(${id})" action="#">
                            
             <div class="fallback d-none">
             <input type="file" name="file" id="input-file-${id}" accept=".jpg, .png">
            </div>
        </canvas>
        
        `;

        let canvas = document.getElementById(`canvas${id}`)
        let ctx = canvas.getContext('2d')
        let imgElement = document.createElement('img')
        let btn_eliminar = document.getElementById(`btn_delete${id}`)

        imgElement.src = `./img/Productos/NA.jpg`

        imgElement.addEventListener('load', function(e) {
        ctx.drawImage(imgElement, 65, 30, 150, 87)
    })
      
},1200)

    


}