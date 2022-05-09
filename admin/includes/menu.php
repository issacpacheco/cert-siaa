<style>	
	.left-nav-label {
		margin-top: 2px;
	}
    .essubmenu{
        width: 225px;
        color: rgba(255,255,255,1);
        font-weight: 600;
        font-size: 13.5px;
        line-height: 25px;
        padding: 11px 15px 12px 15px;
        margin: 6px 0 0 10px;
    }
    .white{
        color: #fff;
    }
	</style>
	<div class="navigation">
        <a class="navbar-brand">
            <i class="fas fa-bars text-primary left-nav-toggle pull-right vcentered"></i>
        </a>
        <ul class="nav primary">
			<li class="">
                <a href="./">
                    <i class="fas fa-home"></i>
                    <span>Panel administrativo</span>
                </a>
            </li>
            <?php if($_SESSION['nivel'] == 1){ ?>
			<li>
                <a href="#submenuAccessos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-user-check"></i>
                    <span>Accesos</span>
                </a>
                <ul class="collapse nav primary essubmenu" id="submenuAccessos">
                    <?php if($_SESSION['nivel'] == 99 || $_SESSION['nivel'] == 1){ ?>
                    <li>
                        <a onclick="getPageMenu('pr-grupos')">
                        <i class="fas fa-users-class white"></i>
                            <span class="white">Grupos</span>
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a onclick="getPageMenu('pr-usuarios')">
                            <i class="fas fa-users white"></i>
                            <span class="white">Usuarios</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#submenuAlmancen" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-warehouse"></i>
                    <span>Almacen</span>
                </a>
                <ul class="collapse nav primary essubmenu" id="submenuAlmancen">
                    <li>
                        <a onclick="getPageMenu('pr-categorias')">
                            <i class="fas fa-cubes white"></i>
                            <span class="white">Categorias</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="getPageMenu('pr-materiales')">
                            <i class="fas fa-ballot-check white"></i>
                            <span class="white">Lista de materiales</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="getPageMenu('pr-entradas-salidas')">
                            <i class="fas fa-ballot-check white"></i>
                            <span class="white">Entradas/Salidas</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="getPageMenu('pr-transferencia')">
                            <i class="fas fa-exchange white"></i>
                            <span class="white">Transferencias</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <?php if($_SESSION['nivel'] == 2){ ?>
            <li>
                <a onclick="getPageMenu('pr-solicitudes')">
                    <i class="fas fa-clipboard-list-check"></i>
                    <span>Solicitudes</span>
                </a>
            </li>
            <?php } ?>
            <!-- <li>
                <a href="activos">
                    <i class="fas fa-file-chart-line"></i>
                    <span>Reportes</span>
                </a>
            </li> -->
		</ul>
		

        <div class="time text-center">
            <h5 class="current-time2">&nbsp;</h5>
            <h5 class="current-time">&nbsp;</h5>
        </div>
    </div>