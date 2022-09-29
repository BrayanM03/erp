function agregarEventos(params) {

  let sucursal = $("#sucursal");
  let producto = $("#producto");
  let id_usuario = $("#user-data").attr("id_user");
  array_dataset = [];
  inicializarDataTable();
  restearTabla(id_usuario)

  sucursal.on("change", function () {
    if ($(this).val() !== "") {

      let id_sucursal = $(this).val();
      let indicador = "sucursal";
      let tabla_ref = "inventario";
      $("#producto").prop("disabled", false);

      $("#producto").select2({
        theme: "bootstrap",
        ajax: {
          url: "../servidor/busquedas/buscar-productos.php",
          placeholder: "Buscar un producto",
          type: "post",
          dataType: 'json',
          delay: 250,
    
          data: function (params) {
           
           
           return {
             tabla: tabla_ref,
             indicador: indicador,
             id: id_sucursal,
             input: params // search term
             
           };
          },
          processResults: function (data) {
              return {
                 results: data
              }; 
            },
         
          cache: true
    
       },
        templateResult: formatResultProducts,
        templateSelection: formatSelection
      })
    
      function formatResultProducts(repo){
       
        if(repo.loading == true){
          var $container = $(
            `
            <div class="row">
              <div class="col-12 col-md-12">
                <span id="${repo.id}">${repo.text}</span>
              </div>
            </div>`
          
        );
        }else{
          var $container = $(
            `
            <div class="row">
              <div class="col-12 col-md-2">
                 <img src="img/productos/P${repo.id}/P1.jpg" style="width:60px;border-radius:8px;">
              </div>
              <div class="col-12 col-md-10 text-start">
                <div class="row">
                  <span id="${repo.id}">${repo.descripcion}</span>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 text-start">
                      <span style="font-size:12px;">${repo.categoria} - ${repo.subcategoria} |  Stock ${repo.stock} | <i class="fa-solid fa-magnifying-glass"></i> ${repo.codigo}</span>
                    </div> 
                </div>
              </div>
            </div>`
          
        );
        }
       
      return $container
      }
    
      function formatSelection(repo){
     
        if(repo.id !== "null"){

          $("#categoria-data").text(repo.categoria)
          $("#subcategoria-data").text(repo.subcategoria)
          $("#codigo-data").text(repo.codigo)
          $("#estatus-data").text(repo.estatus)
          $("#stock-data").text(repo.stock)
          $("#descripcion-data").text(repo.descripcion)
          $("#area-producto").attr("id_producto", repo.id)

          $("#img-prod").attr("src", `img/productos/P${repo.id}/P1.jpg`)
          $("#btn-add-serie").removeClass("disabled")
          var response = repo.descripcion

        }else{
          var response = repo.text
        }
    
        return response
      }


    } else {
      setearForm();
    }
  });

}


let language_options = {
  processing: "<div >Procesando...</div>",
  lengthMenu: "Mostrar _MENU_ registros",
  zeroRecords: "No se encontraron resultados",
  emptyTable: "Ningún dato disponible en esta tabla",
  infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
  infoFiltered: "(filtrado de un total de _MAX_ registros)",
  search: "Buscar:",
  infoThousands: ",",
  loadingRecords: "Cargando...",
  paginate: {
    first: "Primero",
    last: "Último",
    next: "Siguiente",
    previous: "Anterior",
  },
  aria: {
    sortAscending: ": Activar para ordenar la columna de manera ascendente",
    sortDescending: ": Activar para ordenar la columna de manera descendente",
  },
  buttons: {
    copy: "Copiar",
    colvis: "Visibilidad",
    collection: "Colección",
    colvisRestore: "Restaurar visibilidad",
    copyKeys:
      "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br /> <br /> Para cancelar, haga clic en este mensaje o presione escape.",
    copySuccess: {
      1: "Copiada 1 fila al portapapeles",
      _: "Copiadas %ds fila al portapapeles",
    },
    copyTitle: "Copiar al portapapeles",
    csv: "CSV",
    excel: "Excel",
    pageLength: {
      "-1": "Mostrar todas las filas",
      _: "Mostrar %d filas",
    },
    pdf: "PDF",
    print: "Imprimir",
    renameState: "Cambiar nombre",
    updateState: "Actualizar",
    createState: "Crear Estado",
    removeAllStates: "Remover Estados",
    removeState: "Remover",
    savedStates: "Estados Guardados",
    stateRestore: "Estado %d",
  },
  autoFill: {
    cancel: "Cancelar",
    fill: "Rellene todas las celdas con <i>%d</i>",
    fillHorizontal: "Rellenar celdas horizontalmente",
    fillVertical: "Rellenar celdas verticalmentemente",
  },
  decimal: ",",
  searchBuilder: {
    add: "Añadir condición",
    button: {
      0: "Constructor de búsqueda",
      _: "Constructor de búsqueda (%d)",
    },
    clearAll: "Borrar todo",
    condition: "Condición",
    conditions: {
      date: {
        after: "Despues",
        before: "Antes",
        between: "Entre",
        empty: "Vacío",
        equals: "Igual a",
        notBetween: "No entre",
        notEmpty: "No Vacio",
        not: "Diferente de",
      },
      number: {
        between: "Entre",
        empty: "Vacio",
        equals: "Igual a",
        gt: "Mayor a",
        gte: "Mayor o igual a",
        lt: "Menor que",
        lte: "Menor o igual que",
        notBetween: "No entre",
        notEmpty: "No vacío",
        not: "Diferente de",
      },
      string: {
        contains: "Contiene",
        empty: "Vacío",
        endsWith: "Termina en",
        equals: "Igual a",
        notEmpty: "No Vacio",
        startsWith: "Empieza con",
        not: "Diferente de",
        notContains: "No Contiene",
        notStarts: "No empieza con",
        notEnds: "No termina con",
      },
      array: {
        not: "Diferente de",
        equals: "Igual",
        empty: "Vacío",
        contains: "Contiene",
        notEmpty: "No Vacío",
        without: "Sin",
      },
    },
    data: "Data",
    deleteTitle: "Eliminar regla de filtrado",
    leftTitle: "Criterios anulados",
    logicAnd: "Y",
    logicOr: "O",
    rightTitle: "Criterios de sangría",
    title: {
      0: "Constructor de búsqueda",
      _: "Constructor de búsqueda (%d)",
    },
    value: "Valor",
  },
  searchPanes: {
    clearMessage: "Borrar todo",
    collapse: {
      0: "Paneles de búsqueda",
      _: "Paneles de búsqueda (%d)",
    },
    count: "{total}",
    countFiltered: "{shown} ({total})",
    emptyPanes: "Sin paneles de búsqueda",
    loadMessage: "Cargando paneles de búsqueda",
    title: "Filtros Activos - %d",
    showMessage: "Mostrar Todo",
    collapseMessage: "Colapsar Todo",
  },
  select: {
    cells: {
      1: "1 celda seleccionada",
      _: "%d celdas seleccionadas",
    },
    columns: {
      1: "1 columna seleccionada",
      _: "%d columnas seleccionadas",
    },
    rows: {
      1: "1 fila seleccionada",
      _: "%d filas seleccionadas",
    },
  },
  thousands: ".",
  datetime: {
    previous: "Anterior",
    next: "Proximo",
    hours: "Horas",
    minutes: "Minutos",
    seconds: "Segundos",
    unknown: "-",
    amPm: ["AM", "PM"],
    months: {
      0: "Enero",
      1: "Febrero",
      2: "Marzo",
      3: "Abril",
      4: "Mayo",
      5: "Junio",
      6: "Julio",
      7: "Agosto",
      8: "Septiembre",
      9: "Octubre",
      10: "Noviembre",
      11: "Diciembre",
    },
    weekdays: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
  },
  editor: {
    close: "Cerrar",
    create: {
      button: "Nuevo",
      title: "Crear Nuevo Registro",
      submit: "Crear",
    },
    edit: {
      button: "Editar",
      title: "Editar Registro",
      submit: "Actualizar",
    },
    remove: {
      button: "Eliminar",
      title: "Eliminar Registro",
      submit: "Eliminar",
      confirm: {
        1: "¿Está seguro que desea eliminar 1 fila?",
        _: "¿Está seguro que desea eliminar %d filas?",
      },
    },
    error: {
      system:
        'Ha ocurrido un error en el sistema (<a target="\\"rel="\\nofollow"href="\\">Más información&lt;\\/a&gt;).</a>',
    },
    multi: {
      title: "Múltiples Valores",
      info: "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
      restore: "Deshacer Cambios",
      noMulti:
        "Este registro puede ser editado individualmente, pero no como parte de un grupo.",
    },
  },
  info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
  stateRestore: {
    creationModal: {
      button: "Crear",
      name: "Nombre:",
      order: "Clasificación",
      paging: "Paginación",
      search: "Busqueda",
      select: "Seleccionar",
      columns: {
        search: "Búsqueda de Columna",
        visible: "Visibilidad de Columna",
      },
      title: "Crear Nuevo Estado",
      toggleLabel: "Incluir:",
    },
    emptyError: "El nombre no puede estar vacio",
    removeConfirm: "¿Seguro que quiere eliminar este %s?",
    removeError: "Error al eliminar el registro",
    removeJoiner: "y",
    removeSubmit: "Eliminar",
    renameButton: "Cambiar Nombre",
    renameLabel: "Nuevo nombre para %s",
    duplicateError: "Ya existe un Estado con este nombre.",
    emptyStates: "No hay Estados guardados",
    removeTitle: "Remover Estado",
    renameTitle: "Cambiar Nombre Estado",
  },
};




function setearForm(origin) {
  
  $("#cantidad").val("")
  $("#categoria-data").text("")
  $("#subcategoria-data").text("")
  $("#codigo-data").text("")
  $("#estatus-data").text("")
  $("#stock-data").text("")
  $("#descripcion-data").text("")
  $("#img-prod").attr("src", `img/productos/NA.jpg`)
  $("#area-producto").attr("id_producto", "")

  $("#producto").empty().prop("disabled", true)
  $("#btn-add-serie").addClass("disabled")
 
  
};


function agregarProductoARemision(){
    
    let codigo = $("#codigo-data").text();
    let cantidad = $("#cantidad").val();
    let categoria = $("#categoria-data").text();
    let subcategoria = $("#subcategoria-data").text();
    let descripcion = $("#descripcion-data").text();
    let id_producto =  $("#area-producto").attr("id_producto")

    let dato = {
        type: "insercion",
        codigo: codigo,
        cantidad: cantidad,
        categoria: categoria,
        subcategoria: subcategoria,
        descripcion: descripcion,
        id_producto: id_producto
    };

    

    $.ajax({
        type: "POST",
        url: "../servidor/inventario/agregar-producto-detalle-remision.php",
        data: dato,
        dataType: "JSON",
        success: function (response) {
          
            if(response.status == true) {

                Toast.fire({
                    icon: 'success',
                    title: response.message
                  })

                  tabla.ajax.reload(null, false);
                  validarTabla()

            }else{
                Toast.fire({
                    icon: 'error',
                    title: response.message
                  })
                  validarTabla()
            }

        }
      });



};

function eliminarProducto(id_prod){
  let id_usuario = $("#user-data").attr("id_user");

  Swal.fire({
    icon: "question",
    html: "<b>¿Seguro de eliminarlo de la lista?</b>",
    confirmButtonText: "Si",
    showCancelButton: true,
    cancelButtonText: "Mejor no"
  }).then((response) => {
    if(response.isConfirmed) {

      let dato = {
        type: "eliminacion",
        id_producto: id_prod
    };

      $.ajax({
        type: "POST",
        url: "../servidor/inventario/tabla-preentrada.php",
        data: dato,
        dataType: "JSON",
        success: function (response) {
        
        restearTabla(id_usuario)
        validarTabla()

        Toast.fire({
          icon: 'success',
          title: response.mensj
        })
          
        }
    });

    }
  }) 
    
}




function validarTabla() {
  let id_producto = $("#area-producto").attr("id_producto")

  let dato = {
    type: "validacion",
    id_producto: id_producto
};

  $.ajax({
    type: "POST",
    url: "../servidor/inventario/tabla-preentrada.php",
    data: dato,
    dataType: "JSON",
    success: function (response) {
    
    if(response.status == true){
        $("#btn-registrar-prod").removeClass("disabled");
    }else{
      $("#btn-registrar-prod").addClass("disabled");
    }
      
    }
});

}


function inicializarDataTable(){

  let sucursal_id = $("#sucursal").val()

  tabla = $('#example').DataTable({
    processing: true,
    serverSide: true,
    ajax:{
        url: '../servidor/inventario/server_processing_entrada_tmp.php?sucursal_id=' + sucursal_id ,
        dataType: 'json'
    },
    responsive: true,
    order: [0, 'desc'],
    columns:  [ 
        { data:0, title:'#' },
        { data:1, title:'Codigo' },
        { data:2, title:'Descripción' },
        { data:4, title:'Cantidad' },
       /*  { data:12, title:'Imagen', render: ()=>{ 
          return `<img src="./img/productos/NA.jpg" style="width:60px; border-radius:5px; border:1px solid 	#B4B2B1">`;}},
         */{ data:null, title:'Opciones', render: function(row){
            return `
            <div class='row'>
                <div class='col-12 col-md-12'>
                    <div class="btn btn-danger" onclick="eliminarProducto(${row[0]})"><i class="fa-solid fa-trash"></i></div>
                </div>
            </div>
            `
        }}
    ],
    
        language: language_options,

    
});
  

}

function restearTabla(id){
  $.ajax({
      type: "POST",
      url: "../servidor/inventario/reset-entrada-temp.php",
      data: {id:id},
      dataType: "JSON",
      success: function (response2) { 
          if(response2.status == true){
            tabla.ajax.reload(null, false);
  
             
          }
      }
  });
  
}  

function agregarMercancia() {

  let id_sucursal = $("#sucursal").val()
  let id_usuario = $("#user-data").attr("id_user");


  let dato = {
    type: "insercion",
    sucursal_id: id_sucursal
};

  $.ajax({
    type: "POST",
    url: "../servidor/inventario/tabla-preentrada.php",
    data: dato,
    dataType: "JSON",
    success: function (response) {
    
    if(response.status == true){
      Swal.fire({
        icon: "success",
        html: "<b>Productos agregados con exito</b><br>¿Ver remisión?",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "Mejor no"
      }).then(function (ress) {
        if(ress.isConfirmed){

          verRemision(response.folio)
          setearForm(origin)
          restearTabla(id_usuario)
        }else{
          setearForm(origin)
          restearTabla(id_usuario)
        }
      })
      $("#btn-registrar-prod").addClass("disabled");

    }else{
      $("#btn-registrar-prod").removeClass("disabled");
    }
      
    }
});

}


