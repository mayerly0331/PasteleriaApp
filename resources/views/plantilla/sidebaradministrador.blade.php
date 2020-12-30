<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
            <li class="nav-title">
                <i class="fa fa-home"></i> GENERAL
            </li>
            <li class="nav-item nav-dropdown">
                    <li @click="menu=1" class="nav-item" >
                        <a class="nav-link" href="#"><i class="icon-user"></i> Clientes</a>
                    </li>
            </li>
            <li class="nav-item nav-dropdown">
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cubes"></i> Productos</a>
                    </li>
            </li>
            <li class="nav-item nav-dropdown">
                    <li @click="menu=8" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cart-plus"></i> Encargos</a>
                    </li>                      
            </li>   
            <li class="nav-item nav-dropdown">
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-basket-loaded"></i> Ventas</a>
                    </li>    
            </li>        
            <li class="nav-item nav-dropdown">
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-group"></i> Empleados</a>
                    </li>                                
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
