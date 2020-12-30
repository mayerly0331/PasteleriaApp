<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <h6>
                        <i class="fa fa-align-justify"></i> Encargos
                        <button type="button" @click="mostrarDetalle()" class="btn btn-success">
                            <i class="fa fa-line-chart"></i>&nbsp;Encargar
                        </button>
                    </h6>
                </div>
                <!-- listado -->
                <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="cantidad">Número de factura</option>
                                        <option value="fec_entrega">Fecha-Hora</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarEncargo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarEncargo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>      
                                        <th>Anticipo</th>
                                        <th>Fecha Encargo</th>
                                        <th>Fecha Entrega</th>
                                        <th>Cliente</th>
                                        <th>Estado</th>
                                        
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="encargo in arrayEncargo" :key="encargo.id">
                                        <td v-text="encargo.anticipo"></td>
                                        <td v-text="encargo.fec_encargo"></td>
                                        <td v-text="encargo.fec_entrega"></td>
                                        <td v-text="encargo.cliente"></td>
                                          <td v-text="encargo.estado"></td>
                                        <td>
                                            <button type="button" @click="obtenerDatos(encargo.id)" class="btn btn-warning btn-sm">
                                                <i class="icon-eye"></i>
                                            </button>&nbsp;
                                            <template v-if="encargo.estado=='Registrado'">
                                                <button type="button" class="btn btn-danger btn-sm" @click="anularEncargo(encargo.id)">
                                                <i class="icon-trash"></i>
                                                </button>
                                            </template>                          
                                        </td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </template>
                <!-- Fin del listado -->
                <!-- Inicio de detalles -->
                <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row border">
                           <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Cliente(*)</label>                                                                 
                                        <select class="form-control" v-model="id_cliente">                                         
                                            <option v-for="cliente in arrayCliente" :key="cliente.id" :value="cliente.id" v-text="cliente.nombre">
                                            </option>
                                        </select>                                
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha de Entrega </label>
                                    <input type="date" class="form-control" v-model="fec_entrega" placeholder="Ingrese la fecha de entrega">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Anticipo </label>
                                    <input type="number" class="form-control" v-model="anticipo" placeholder="Ingrese el anticipo">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div v-show="errorEntrada" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjEntrada" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Producto <span style="color:red;" v-show="id_producto==0">(*Seleccione)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="nombre" @keyup.enter="buscarProducto()" placeholder="Ingrese producto">
                                        <button @click="abrirModal()" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        <input type="text" readonly class="form-control" v-model="producto">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cantidad <span style="color:red;" v-show="cantidad==0">(*Ingrese)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="cantidad" placeholder="Ingrese la cantidad">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-primary form-control btnagregar"><i class="icon-plus"></i> Agregar</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>                                            
                                            <th>Opciones</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle_encargo,index) in arrayDetalle" :key="detalle_encargo.id">
                                            <td v-text="detalle_encargo.producto">
                                            </td>
                                            <td>
                                            <input v-model="detalle_encargo.cantidad" class="form-control" type="number">
                                            </td>                                
                                            <th > 
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn sm"><i class="icon-trash"></i></button>
                                                
                                            </th>
                                        </tr>   
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No hay productos agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row float-right">
                            <div class="col-md-12 ">
                                <button type="button" @click="ocultarDetalle" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarEntrada()">Comprar</button>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Cliente:</label>
                                    <p v-text="cliente"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Fecha de encargo:</label>
                                    <p v-text="fec_encargo"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Fecha de entrega:</label>
                                    <p v-text="fec_entrega"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Anticipo $:</label>
                                    <p v-text="anticipo"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>                                         
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle_encargo in arrayDetalle" :key="detalle_encargo.id">
                                            <td v-text="detalle_encargo.producto"></td>
                                            <td v-text="detalle_encargo.cantidad"></td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No hay productos agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row float-right">
                            <div class="col-md-12 ">
                                <button type="button" @click="ocultarDetalle" class="btn btn-secondary">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Fin de entrada -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div> 
        <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document"> 
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titulo"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioA">
                                    <option value="nombre">Nombre</option>
                                    </select>
                                    <input type="text" v-model="buscarA" @keyup.enter="listarProducto(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarProducto(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>C. Indirecto</th>
                                        <th>Existencias</th>
                                        <th>C. Producción</th>
                                        <th>Opciones</th>                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="producto in arrayProducto" :key="producto.id">
                                        <td v-text="producto.nombre"></td>
                                        <td v-text="producto.costos_indirectos"></td>
                                        <td v-text="producto.existencias"></td>
                                        <td v-text="producto.costo_produccion"></td>                                        
                                        <td>
                                            <button type="button" @click="agregarDetalleModal(producto)" class="btn btn-success btn-sm">
                                            <i class="fa fa-mouse-pointer"></i>
                                            </button>
                                        </td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="accion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="accion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                <!-- /.modal-content -->
                </div>
            <!-- /.modal-dialog -->
            </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
    export default {
        data ()
        {
            return {
                
                id_entrada:0,
                id_cliente:0,
                id_producto:0,
                cliente:'',
                nombre:'',
                cantidad:'',
                fec_encargo:"",
                fec_entrega:"",
                anticipo:"",
                cantidad:0,
                producto:'',
                cliente:'',
                arrayEncargo:[],
                arrayDetalle:[],
                arrayCliente:[],
                arrayProducto:[],
                listado:1,
                modal:0,
                titulo:'',
                accion:0,
                errorEntrada:0,
                errorMostrarMsjEntrada:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
                },
                offset:3,
                criterio:'cantidad',
                buscar:'',
                criterioA:'nombre',
                buscarA:'',
            }
        },

        
        methods : {
            cambiarPagina(page,buscar,criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarEncargo(page,buscar,criterio);
            },
            listarEncargo (page,buscar,criterio){
                let me=this;
                var url= '/encargos?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEncargo = respuesta.encargos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCli(){
                let me=this;
                var url= '/cliente/selectCli';
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    me.arrayCliente = respuesta.clientes;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            listarProducto: function (buscarA, criterioA) {
                let me = this;
                var url = "/producto/listarProducto?buscar=" + buscarA + '&criterio=' + criterioA;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayProducto = respuesta.productos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            buscarProducto(){
                let me=this;
                var url= '/producto/buscarProducto?filtro=' + me.nombre;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProducto = respuesta.productos;
                    if (me.arrayProducto.length>0){
                        me.producto=me.arrayProducto[0]['nombre'];
                        me.id_producto=me.arrayProducto[0]['id'];                      
                        me.existencias=me.arrayProducto[0]['existencias'];
                    }
                    else{
                        me.producto='No existe este producto';
                        me.id_producto=0;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'])){
                        Swal.fire({
                            icon:'error',
                            title: 'Error',
                            text:'Este producto ya se agrego...'
                        })
                    }
                    else{
                        me.arrayDetalle.push({
                            id_producto: data['id'],
                            producto: data['nombre'],
                            cantidad: 0,
                        }); 
                    }
            },
            encuentra(id){
                var dy=0
                for(var i=0;i<this.arrayDetalle.length;i++){ 
                if(this.arrayDetalle[i].id_producto==id){
                    dy=true;
                    }
                }
                return dy;
            },
            agregarDetalle(){
                let me=this;
                if(me.id_producto==0 || me.cantidad==0){ 
                }
                else{
                    if(me.encuentra(me.id_producto)){ 
                        Swal.fire({
                            icon:'error',
                            title: 'Error',
                            text:'Este producto ya se agrego...'
                        })
                    }
                    else{
                    me.arrayDetalle.push({
                        id_producto: me.id_producto,
                        producto: me.producto,
                        cantidad: me.cantidad,
                    }); 
                        
                        me.id_producto=0;
                        me.producto="";
                        me.cantidad=0;

                    }
                }
            },
            eliminarDetalle(index){ 
                let me = this;
                me.arrayDetalle.splice(index, 1);  
            },
            registrarEntrada(){
                if (this.validarEntrada()){
                    return;
                }
                let me = this;
                axios.post('/encargos/registrar',{
                    'cantidad' : this.cantidad,
                    'fec_encargo' : this.fec_encargo,
                    'fec_entrega' : this.fec_entrega,
                    'anticipo' : this.anticipo,
                    'id_cliente': this.id_cliente,
                    'data': this.arrayDetalle
                }).then(function (response) {
                    me.listado=1;
                    me.listarEncargo(1,'','cantidad');
                    me.id_cliente=0;
                    me.cantidad='';
                    me.anticipo=0.0;
                    me.id_producto=0;
                    me.producto='';
                    me.cantidad=0;
                    me.arrayDetalle=[];
                    me.mensaje("¡Se facturo correctamente!");

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarEntrada(){
                this.errorEntrada=0;
                this.errorMostrarMsjEntrada =[];
                if (this.id_cliente==0) this.errorMostrarMsjEntrada.push("Seleccione un cliente");
                if (this.arrayDetalle.length<=0) this.errorMostrarMsjEntrada.push("Ingrese detalles");
                if (this.errorMostrarMsjEntrada.length) this.errorEntrada = 1;

                return this.errorEntrada;
            },
            abrirModal: function(){

                this.modal = 1;
                this.titulo = "Selecione uno o varios productos";
            },
            cerrarModal(){
                this.modal = 0;
                this.titulo = "";
            },
            mostrarDetalle(){ 
                let me=this
                me.listado=0;
                me.id_cliente="";
                me.cantidad="";
                me.anticipo="";
                me.id_producto=0;
                me.producto='';
                me.arrayDetalle=[]; 
            },
            ocultarDetalle(){
                this.listado=1;
            },
            obtenerDatos(id){
                let me = this;
                me.listado=2;
                var arrayEncargoT=[];
                var url= '/encargos/obtenerDatos?id=' + id;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayEncargoT = respuesta.encargos;
                    me.fec_encargo=me.arrayEncargoT[0]['fec_encargo'];
                    me.fec_entrega=me.arrayEncargoT[0]['fec_entrega'];
                    me.anticipo=me.arrayEncargoT[0]['anticipo'];
                    me.cliente=me.arrayEncargoT[0]['nombre'];
                    me.cantidad=me.arrayEncargoT[0]['cantidad'];
                })
                .catch(function (error) {
                    console.log(error);
                });
                        
                var urld= '/encargos/obtenerDetalles?id=' + id;
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalle_encargos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            anularEncargo(id){
                Swal.fire({
                title: '¿Está seguro de anular esta compra?',
                text: '¡No podrá revertir esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '¡No, cancelar!',
                confirmButtonText: '¡Si, anular!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/encargos/desactivarEncargo',{
                        'id': id
                    }).then(function (response) {
                        me.listarEncargo(1,'','cantidad');
                        Swal.fire(
                        '¡Anulada!',
                        'La compra ha sido anulado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    result.dismiss === Swal.fire.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            mensaje(msj) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: msj,
                    showConfirmButton: false,
                    timer: 2000
                });
            },
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  
                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             
            },
        },
        mounted() {
            this.listarEncargo(1,this.buscar,this.criterio);
            this.selectCli();
            this.listarProducto(this.buscarA,this.criterioA);
            
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 1.8rem;
        }
    }
</style>
