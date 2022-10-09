<div class="row">
    <div class="col-12 col-md-9" style="position: relative;">
        <input type="text" class="form-field" placeholder="Buscar producto" id="buscar-producto">
        <div class="result-products d-none" id="result-products"></div>
    </div>
    <div class="col-12 col-md-3">
        <select type="text" class="form-field" id="cliente">
        </select>
    </div>
</div>
<div class="row mt-3" style="padding: 0px;">
    <div class="col-12 col-md-12" style="border:1px solid #CDD9ED; border-radius:8px; margin-right:0px; padding-right: 0px;">

            <div class="row">
                <div class="col-12 col-md-9" id="area-products">
                <div class="row">
                    <div class="col-12 col-md-12">
                    <div class="message_empty">
                        <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_b88nh30c.json" background="transparent"  speed="1"  style="width: 250px; height: 250px;" loop autoplay></lottie-player>
                        <p>Cargando...</p>
                    </div>
                    </div>
                </div>    
                </div>

                <div class="col-12 col-md-3">
                    <div class="card ticket">
                        <div class="row mt-3">
                            <div class="col-12 col-md-12 text-center">
                              <div class="customer-profile">
                                    <img src="./img/user.png" alt="" id="cliente-img">
                                    <div class="cliente-body" id="nombre_cliente" id_cliente="26">Publico en general</div>
                              </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                          <div class="col-12 col-md-12 text-center">
                             <div class="body-ticket">
                                <b style="color: #e9bd15;">Ticket de venta</b>
                                
                                <ul class="products-list" id="products-list">
                                    <li>
                                        <div class="row">
                                            <div class="col-12 col-md-6">Concepto</div>
                                            <div class="col-12 col-md-3">Cant</div>
                                            <div class="col-12 col-md-3">Importe</div>
                                        </div>
                                    </li>
                                    <div id="products-body"></div>
                                </ul>
                              </div>  
                          </div> 
                        </div>

                     
                    </div>
                    <div class="row">
                            <div class="col-12">
                                <div class="totales">
                                    <ul>
                                        <li>
                                           <div class="row">
                                           <div class="col-12 col-md-5">IVA</div> 
                                           <div class="col-12 col-md-7"><span id="iva">$0.00</span></div>
                                           </div> 
                                        </li>
                                        <li>
                                        <div class="row">
                                           <div class="col-12 col-md-5">Total</div> 
                                           <div class="col-12 col-md-7"><b><span id="neto">$0.00</span></b></div>
                                        </div> 
                                        </li>
                                    </ul>
                                    <div class="row">
                                        <div class="col-12 btn-vender">
                                        <div class="btn btn-success" onclick="realizarVenta()" id="btn-vender">Vender</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

    </div>
</div>