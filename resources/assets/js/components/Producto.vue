<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h6>
                    <i class="icon-basket-loaded"></i> Productos
                    <button type="button" class="btn btn-success" data-toggle="modal" @click="abrirModal('producto', 'registrar')">
                        <i class="icon-plus"></i>&nbsp;Agregar
                    </button>            
                </h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre">Producto</option>
                            </select>
                            <input type="text" @keyup.enter="listarProducto(1, buscar, criterio)" v-model="buscar" class="form-control" placeholder="Buscar texto" />
                            <button type="submit" @click="listarProducto(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
					<thead>
						<tr>                 
                            <th>Producto</th>  
                            <th>Costo I.</th>  
                            <th>% Ganancia</th>
                            <th>C. Produc.</th>                             
                            <th>Existencias</th>
                            <th>Descripción</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="producto in arrayProducto" :key="producto.id">                            
                            <td v-text="producto.nombre"></td>                            
                            <td v-text="producto.costos_indirectos"></td>
                            <td v-text="producto.porcen_ganancia"></td>
                            <td v-text="producto.costo_produccion"></td>
                            <td v-text="producto.existencias"></td>
                            <td v-text="producto.descripcion"></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" @click="abrirModal('producto', 'actualizar', producto)"><i class="fa fa-edit"></i></button>
                                &nbsp;
                                <button type="button" class="btn btn-danger btn-sm" @click="eliminarProducto(producto)"><i class="icon-trash"></i></button>
                                &nbsp;                               
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Anterior</a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" :class="{ mostrar: modal }" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="titulo"></h4>
                    <button type="button" @click="cerrarModal()" class="close" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">                                                
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-10">
                                <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del producto" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="text-input">Costos I.</label>
                            <div class="col-md-10">
                                <input type="number" v-model="costos_indirectos" class="form-control" placeholder="Ingrese costos indirectos" />
                            </div>
                        </div>            
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="text-input">Porcen. Ganancia</label>
                            <div class="col-md-10">
                                <input type="number" v-model="porcen_ganancia" class="form-control" placeholder="Ingrese el porcentaje de ganancia" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="text-input">C. Producción</label>
                            <div class="col-md-10">
                                <input type="number" v-model="costo_produccion" class="form-control" placeholder="Ingrese el costo de producción" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="text-input">Existencias</label>
                            <div class="col-md-10">
                                <input type="number" v-model="existencias" class="form-control" placeholder="Ingrese existencias" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="text-input">Descripción</label>
                            <div class="col-md-10">
                                <input type="text" v-model="descripcion" class="form-control" placeholder="Ingrese la descripcion" />
                            </div>
                        </div>
                            <div v-show="errorProducto" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error"></div>
                                </div>
                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()" > Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="registrarProducto()" v-if="accion == 1"> Guardar</button>
                    <button type="button" class="btn btn-primary" @click="actualizarProducto()" v-if="accion == 2"> Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
    <!-- Inicio del modal Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none" aria-hidden="true">
        <div class="modal-dialog modal-danger" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Eliminar Producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de eliminar el registro?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="button" @click="eliminarProducto" class="btn btn-danger">
                        Eliminar
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Fin del modal Eliminar -->
</main>
</template>

<script>
// import VueBarcode from "vue-barcode";

export default {
    data() {
        return {
            id_producto: 0,
            porcen_ganancia: "",
            costo_produccion: "",
            existencias: "",
            nombre: "",
            descripcion:"",
            costos_indirectos: "",
            arrayProducto: [],
            modal: 0,
            titulo: "",
            accion: 0,
            errorProducto: 0,
            errorMostrarMsjProducto: [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
            offset: 3,
            criterio: "nombre",
            buscar: "",
        };
    },

    computed: {
    isActived: function () {
        return this.pagination.current_page;
    },
    pagesNumber: function () {
        if (!this.pagination.to) {
        return [];
        }
        var from = this.pagination.current_page - this.offset;
        if (from < 1) {
            from = 1;
        }

        var to = from + this.offset * 2;
        if (to >= this.pagination.last_page) {
            to = this.pagination.last_page;
        }
        var pagesArray = [];
        while (from <= to) {
            pagesArray.push(from);
            from++;
        }
        return pagesArray;
        },
    },
    methods: {
        listarProducto(page, buscar, criterio) {
            let me = this;
            var url = "/producto?page=" + page + "&buscar=" + buscar + "&criterio=" + criterio;
            axios.get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayProducto = respuesta.productos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },

        cambiarPagina(page, buscar, criterio) {
            let me = this;
            //Actualiza  la pagina actual
            me.pagination.current_page = page;
            me.listarProducto(page, buscar, criterio);
        },
        registrarProducto() {
            if (this.validarProducto()) {
                return;
            }
            let me = this;
            axios.post("/producto/registrar", {                
                //    'id':this.id_producto,
                    'nombre': this.nombre,
                    'costos_indirectos': this.costos_indirectos,
                    'porcen_ganancia': this.porcen_ganancia, 
                    'costo_produccion': this.costo_produccion,
                    'existencias': this.existencias,      
                    'descripcion': this.descripcion,   
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarProducto(1, "", "nombre");
                    me.mensaje("¡Se guardó correctamente!");
                })
                .catch(function (error) {
                console.log(error);
                });
        },
        actualizarProducto() {
            if (this.validarProducto()) {
                return;
            }
            let me = this;
            axios.put("/producto/actualizar", {
                    'id':this.id_producto,
                    'nombre': this.nombre,
                    'costos_indirectos': this.costos_indirectos,
                    'porcen_ganancia': this.porcen_ganancia,                  
                    'costo_produccion': this.costo_produccion,
                    'existencias': this.existencias,      
                    'descripcion': this.descripcion,   
            })            
            .then(function (response) {
                me.cerrarModal();
                me.listarProducto(1, "", "nombre");
                me.mensaje("¡Se guardó correctamente!");
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        eliminarProducto(data = []) {
			Swal.fire({
                title: '¿Está seguro de eliminarlo?',
                text: '¡No podrás revertir esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '¡No, cancelar!',
                confirmButtonText: '¡Si, eliminar!',
			}).then(result => {
				if (result.value) {
				let me = this;
				this.id_producto = data["id"];
				axios
					.post("/producto/eliminar", {
					id: this.id_producto
					})
					.then(function(response) {
                        me.listarProducto(1, "", "nombre");
                        me.mensaje("¡Se eliminó correctamente!");
					})
					.catch(function(error) {
					console.log(error);
					});
				} else if (
				    result.dismiss === swal.DismissReason.cancel
				) {
				}
			});
		},
        validarProducto() {
            this.errorProducto = 0;
            this.errorMostrarMsjProducto = [];
                if (!this.nombre) this.errorMostrarMsjProducto.push("(*)El nombre del producto no puede estar vacio");
                // if (this.costo_produccion) this.errorMostrarMsjProducto.push("(*)El costo de producción no puede estar vacío");
                if (!this.descripcion) this.errorMostrarMsjProducto.push("(*)La descripción no puede estar vacía");
                if (!this.costos_indirectos) this.errorMostrarMsjProducto.push("(*)El costo indirecto del producto no puede estar vacio");
                if (this.errorMostrarMsjProducto.length) this.errorProducto = 1;
                return this.errorProducto;
        },
        cerrarModal() {
            this.modal = 0;
            this.titulo = "";;
            this.marca = "";
            this.nombre = "";
            this.precio = "";
            this.costos_indirectos = "";
            this.errorProducto = 0;
        },
        limpiar() {
            this.nombre = "";
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
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "producto": {
                switch (accion) {
                    case "registrar": {
                    this.modal = 1;
                    this.titulo = "Agregar Producto";
                    this.costo_produccion = "";
                    this.porcen_ganancia = "";
                    this.existencias = "";
                    this.costos_indirectos = "";
                    this.descripcion = "";
                    this.accion = 1;
                    break;
                    }
                    case "actualizar": {
                    this.modal = 1;
                    this.titulo = "Editar Producto";
                    this.accion = 2;
                    this.id_producto = data["id"];                 
                    this.nombre = data["nombre"];
                    this.costo_produccion = data["costo_produccion"];
                    this.existencias = data["existencias"];
                    this.descripcion = data["descripcion"];
                    this.porcen_ganancia = data["porcen_ganancia"];
                    this.costos_indirectos = data["costos_indirectos"];
                    break;
                    }
                }
                }
            }
        },
    },
        mounted() {
            console.log("Component mounted.");
            this.listarProducto(1, this.buscar, this.criterio);
        },
        
};
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
</style>
