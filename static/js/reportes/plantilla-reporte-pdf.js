// Landscape export, 2×4 inches
const doc = new jsPDF();

logo = data_logo.replace(/[\s"\\]/gm, "");
doc.addImage(logo, "JPEG", 8, 5, 40, 18);

let id_orden = getParameterByName("id_orden")  

/* $.ajax({
    type: "POST",
    url: "../inventario/traer-datos-de-ordne.php",
    data: {id_orden: id_orden},
    dataType: "JSON",
    success: function (response) {
        console.log(response);
    }
}); */
/* 
console.log(doc.getFontList()); */
doc.setFont("helvetica"); // set font
doc.setFontType("bold"); // set font

doc.text("Orden de servicio", 140, 10);

doc.setFontSize(12);
doc.text("868348398", 140, 17);

doc.setDrawColor(255,0,0); // draw red lines
doc.line(8, 30, 200, 30); //Line
doc.setDrawColor(10,10,10); // draw black lines
doc.line(8, 31, 200, 31); //Line

//Diseño de formulario de datoa de cliente - maquetacion
doc.setDrawColor(220,220,220); // draw gray lines
doc.rect(8,32,192,15)
doc.line(8, 39, 200, 39); //Line
doc.line(145, 32, 145, 47); // vertical line

doc.rect(8,47,192,15)
doc.line(8, 55, 200, 55); //Line
doc.line(145, 47, 145, 62); // vertical line

doc.setDrawColor(10,10,10); // draw black lines
doc.setFontType("normal"); // set font
doc.setFontSize(10);
doc.text("Calle Diesciseis Buena Vista, 87350 Heroica Matamoros, Tamps.", 80, 27);

//Datos cliente
doc.setFontType("bold"); // set font
doc.text("Nombre", 10, 38);
doc.text("Fecha", 147, 38);
doc.text("Contacto", 10, 45);
doc.text("RFC", 147, 45);
doc.text("Domicilio", 10, 53);
doc.text("Telefono", 147, 53);
doc.text("Colonia", 10, 60);
doc.text("Correo", 147, 60);

//-----------Cuerpo de items -----//
let bodyTable = [
    { cantidad: '2', descripcion: 'Toshiba T-15300 2 TON 220V', precio_unit: '9,500.00', importe:'19,000.00' },
    { precio_unit: 'Metodo', importe:'Tarjeta' },
    { descripcion: 'Recuerde hacer limpieza de filtros de Aire Acondicionado cada mes', precio_unit: 'Total', importe:'76,000.00' },
  ];

  //---------Cuerpo de seires ---//
  let bodySeries = [
    { index: '1', condensador: 'MUI789524', evaporizador: 'MOU789524', desc:'TOSHIBA T-15300' },
  ];
  //---------END------


doc.autoTable(({
    theme: 'grid',
    /* columnStyles: { 0: { halign: 'left', fillColor: [255, 255, 255] } }, */
    /* headStyles: { 0: { halign: 'left', fillColor: [211, 211, 211] } }, */
    headStyles: { fillColor: [211, 211, 211], textColor: [54, 69, 79]},
    body: bodyTable,

    columns: [
      { header: 'Cant', dataKey: 'cantidad' },
      { header: 'Descripcion', dataKey: 'descripcion' },
      { header: 'Precio Unit.', dataKey: 'precio_unit' },
      { header: 'Importe', dataKey: 'importe' },
    ],
    startY:64,
    margin: { left: 8 },
    tableWidth: 193
  }))

  //Tabla medidas de StartY a partir de la primera pártida. 7.5 puntos de altura por partida
  //86.5 puntos de altura inicial
  /* 1 item = 94 puntos en Y
     2 item = 101.5 puntos en Y
     3 item = 109 puntos en Y
     4 item = 116.5 puntos en Y */
     let alturaPartidas = 7.5 * (bodyTable.length)   
     let startY = 71.5 + alturaPartidas;


  doc.autoTable(({
    headStyles: { fillColor: [255, 195, 0], textColor: [0, 0, 0], halign: 'center'},
    startY:startY,
    margin: { left: 8 },
    tableWidth: 193,
    columns: [
        { header: 'Venta sin instalación', dataKey: null }
      ],
  }))

  let startYSeries = startY + 7.5; 
  doc.autoTable(({
    headStyles: { fillColor: [211, 211, 211], textColor: [54, 69, 79], halign: 'center'},
    startY:startYSeries,
    body: bodySeries,
    margin: { left: 8 },
    tableWidth: 193,
    columns: [
        { header: '#', dataKey: "index" },
        { header: 'Serie condensador', dataKey: "condensador" },
        { header: 'Serie evaporizador', dataKey: "evaporizador" },
        { header: 'Equipo', dataKey: "desc"}
      ],
  }))

  let alturaSeries = 7.5 * (bodySeries.length)
  let startYfooter = 25 + startY + alturaSeries;


  doc.text("Firma:", 10, startYfooter);
  doc.text("Nombre:", 60, startYfooter);
  doc.text("Fecha:", 160, startYfooter);

  doc.setFontSize(8);
  doc.setFontType("normal");
  let contrato = `Recibi(mos) de conformidad los equipos, materiales y trabajos mencionados debo y pagare(mos) incondicionalmente a la orden de Maria Dolores Gon-
  zalez Ramirez, el total descrito en esta orden. De no ser cubierto el importe de la misma de 8 dias, causara el 10% de interes moratorio mensual. 
  Rev. 11 2015`
  doc.text(contrato, 10, startYfooter + 5, {align: 'justify',lineHeightFactor: 1.5,maxWidth:193});


  //--------GARANTIA-------
  let garantia = `Garantia de fabricante MiniSplit Nuevo - Cobertura limitada a refacciones. 
Usuario cubre costos de revisiones, mano de obra por remplazo de refacciones, para hacer valida su GARANTIA, fabricante requiere factura de compra
y requiere que realize MANTENIMIENTO PREVENTIVO cada año. Con AireExpress o tecnico certiicado, como tener comprobantes correspondientes.`

doc.text(garantia, 10, startYfooter + 15, {align: 'justify',lineHeightFactor: 1.5,maxWidth:193});

let bodyGarantia = [
  {index: "5", desc: "Año(s) de garantia en compresor. Compresor no debe estar quemado, aterrizado, cruzado o con los bordes botados o zafados"},
  {index: "1", desc: "Año(s) de garantia en refacciones"},
  {index: "3", desc: "Año(s) de garantia en componentes electronicos"}];
doc.autoTable(({
  headStyles: { fillColor: [211, 211, 211], textColor: [54, 69, 79], halign: 'center'},
  startY:startYfooter + 25,
  body: bodyGarantia,
  margin: { left: 8 },
  tableWidth: 193,
  columns: [{header: null, dataKey: 'index'},
  {header: null, dataKey: 'desc'},]
}))

//----MINISPLIT INCLUYE
let alturaGarantias = startYfooter + 89
console.log(alturaGarantias);
doc.setFontType("bold"); // set font
doc.setFontSize(11);

doc.text("Mini Split incluye", 10, alturaGarantias);
doc.setFontType("normal");
let inlcuye = `Evaporador, Condensador, control remoto, kit de instalacion`
doc.save("Orden de servicio.pdf");



function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
  }