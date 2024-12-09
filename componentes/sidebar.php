<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="dashboard"> 


              <img alt="image" src="<?php echo $ruta; ?>assets/img/logo-origen-O.png" class="header-logo" /><img class="logo-name2" alt="image" src="<?php echo $ruta; ?>assets/img/logo-origen-O3.png"/></span>


            </a>
          </div>
        
          <ul class="sidebar-menu">
            <li class="menu-header">MENÚ PADD</li>
            <li class="dropdown active">
              <a href="<?php echo $ruta; ?>dashboard.php" class="nav-link"><i data-feather="monitor"></i><span>Panel de Inicio</span></a>
            </li>
            <?php if ($mostrarMenuComercial): ?>
            <li class="dropdown comercial">
              <a href="#" class="menu-toggle nav-link has-dropdown fondo"><i
                  data-feather="briefcase"></i><span>Área Comercial</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo $ruta; ?>ListClientes.php">Clientes</a></li>
                <li><a class="nav-link" href="<?php echo $ruta; ?>ListProductos.php">Productos</a></li>
                <li><a class="nav-link" href="<?php echo $ruta; ?>ListMedios.php">Medios</a></li>
                <li><a class="nav-link" href="<?php echo $ruta; ?>ListAgencia.php">Agencias</a></li>
                <li><a class="nav-link" href="<?php echo $ruta; ?>ListProveedores.php">Proveedores</a></li>
                <li><a class="nav-link" href="<?php echo $ruta; ?>ListSoportes.php">Soportes</a></li>
              </ul>
            </li>
            <?php endif; ?>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown fondo"><i data-feather="pie-chart"></i><span>Planificación de Medios</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo $ruta; ?>ListContratos.php">Contratos</a></li>
  
                <li><a class="nav-link" href="<?php echo $ruta; ?>ListCampaign.php">Campañas</a></li>
                
                <li><a class="nav-link" href="<?php echo $ruta; ?>ListPlanes.php">Planes de Medios</a></li>
                <li><a class="nav-link" href="<?php echo $ruta; ?>ListOrdenes.php">Órdenes de Publicidad</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown fondo"><i data-feather="copy"></i><span>Informaciones</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo $ruta; ?>ListAvisos.php">Mensajes</a></li>
              </ul>
            </li>
            <?php if ($mostrarMenuUsuarios): ?>
            <li class="dropdown users">
              <a href="#" class="menu-toggle nav-link has-dropdown fondo"><i data-feather="user-check"></i><span>Usuarios</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="ListUsuarios.php">Listado de Usuarios</a></li>
              </ul>
            </li>
            <?php endif; ?>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown fondo"><i
                  data-feather="image"></i><span>Mi Perfíl</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="perfil.php">Mis Datos</a></li>
              </ul>
            </li>
          </ul>
        </aside>
      </div>
