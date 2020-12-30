<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
            <li class="nav-title">
                <i class="icon-bag"></i> GENERAL
            </li>
            <li class="nav-item nav-dropdown">
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cart-arrow-down"></i> Ventas</a>
                    </li>
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-user"></i>Clientes</a>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <li @click="menu=8" class="nav-item">
                            <a class="nav-link" href="#"><i class="fa fa-cart-plus"></i> Encargos</a>
                        </li>                      
                </li>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
