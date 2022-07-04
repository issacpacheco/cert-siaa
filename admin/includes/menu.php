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
            <?php if($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 99){ ?>
            <?php if($_SESSION['nivel'] == 1){ ?>
			<li>
                <a href="#submenuAccessos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-user-check"></i>
                    <span>Accesos</span>
                </a>
                <ul class="collapse nav primary essubmenu" id="submenuAccessos">
                    <li>
                        <a onclick="getPageMenu('pr-grupos')">
                        <i class="fas fa-users-class white"></i>
                            <span class="white">Grupos</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="getPageMenu('pr-usuarios')">
                            <i class="fas fa-users white"></i>
                            <span class="white">Usuarios</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <li>
                <a href="#submenuAlmancen" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-warehouse"></i>
                    <span>Almacen</span>
                </a>
                <ul class="collapse nav primary essubmenu" id="submenuAlmancen">
                    <?php if($_SESSION['nivel'] == 1){ ?>
                    <li>
                        <a onclick="getPageMenu('pr-categorias')">
                            <i class="fas fa-cubes white"></i>
                            <span class="white">Categorias</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="getPageMenu('pr-bodeguitas')">
                            <i class="fas fa-warehouse-alt white"></i>
                            <span class="white">Bodeguitas</span>
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a onclick="getPageMenu('pr-materiales')">
                            <i class="fas fa-barcode-alt white"></i>
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
                            <span class="white"> Transferencias</span>
                        </a>
                    </li>
                    <?php if($_SESSION['area'] == 6){ ?>
                    <li>
                        <a onclick="getPageMenu('pr-proyectos')"> 
                            <i class="fas fa-project-diagram white"></i>
                            <span class="white"> Proyectos</span>
                        </a>
                    </li>  
                    <?php } ?>
                    <?php if($_SESSION['area'] == 3){ ?>
                    <li>
                        <a onclick="getPageMenu('pr-departamentos')"> 
                            <i class="fas fa-project-diagram white"></i>
                            <span class="white"> Aulas/Departamentos</span>
                        </a>
                    </li>  
                    <?php } ?>
                </ul>
            </li>
            <li>
                <a href="#submenuAdmon" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-cabinet-filing"></i>
                    <span>Administración</span>
                </a>
                <ul class="collapse nav primary essubmenu" id="submenuAdmon">
                    <li>
                        <a onclick="getPageMenu('pr-facturas')">
                            <i class="fas fa-abacus white"></i>
                            <span class="white"> Facturas</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a onclick="getPageMenu('pr-facturas')">
                            <i class="fas fa-abacus white"></i>
                            <span class="white"> Proyectos</span>
                        </a>
                    </li> -->
                </ul>
            </li>
            <!-- <li>
                <a href="#submenuAdmonVehicular" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-cabinet-filing"></i>
                    <span>Administración vrhicular</span>
                </a>
                <ul class="collapse nav primary essubmenu" id="submenuAdmonVehicular">
                    <li>
                        <a onclick="getPageMenu('pr-tr-combustibles')">
                            <i class="fas fa-abacus white"></i>
                            <span class="white"> Combustible</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="getPageMenu('pr-tr-gastos-adicionales')">
                            <i class="fas fa-abacus white"></i>
                            <span class="white"> Gastos adicionales</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="getPageMenu('pr-tr-incidentes')">
                            <i class="fas fa-abacus white"></i>
                            <span class="white"> Incidentes</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="getPageMenu('pr-tr-mantenimento')">
                            <i class="fas fa-abacus white"></i>
                            <span class="white"> Manteninmiento</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="getPageMenu('pr-tr-panel-vehicular')">
                            <i class="fas fa-abacus white"></i>
                            <span class="white"> Panel vehicular</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="getPageMenu('pr-tr-vehiculo')">
                            <i class="fas fa-abacus white"></i>
                            <span class="white"> Vehiculos</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a onclick="getPageMenu('pr-facturas')">
                            <i class="fas fa-abacus white"></i>
                            <span class="white"> Proyectos</span>
                        </a>
                    </li> -->
                </ul>
            </li> -->
            <li>
                <a href="#submenuSeptup" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
                <ul class="collapse nav primary essubmenu" id="submenuSeptup">
                    <li>
                        <a onclick="universalLoad(this)" data-postload="0" data-returnpage="pr-inicio" data-form="" data-page="perfil" data-carpeta="ajax-edit" data-load="contenedor" data-valores="" data-id="<?php echo $_SESSION['id_admin']; ?>">
                            <i class="fas fa-user-cog white"></i>
                            <span class="white"> Preferencias</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <?php if($_SESSION['nivel'] == 2){ ?>
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
                        <a onclick="getPageMenu('pr-bodeguitas')">
                            <i class="fas fa-warehouse-alt white"></i>
                            <span class="white">Bodeguitas</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="getPageMenu('pr-materiales')">
                            <i class="fas fa-barcode-alt white"></i>
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
            <?php if($_SESSION['nivel'] == 3){ ?>
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
            <h5 class="current-time2 white">&nbsp;</h5>
            <h5 class="current-time white">&nbsp;</h5>
        </div>
    </div>