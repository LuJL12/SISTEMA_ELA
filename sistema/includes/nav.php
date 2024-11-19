
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="./images/user.png" alt="User Image">
            <div>
            <p class="app-sidebar__user-name"><?php echo $_SESSION['rol_name'] ?></p>
            <p class="app-sidebar__user-designation"><?php echo $_SESSION['nombres']; ?></p>
            <p class="app-sidebar__user-designation"><?php echo $_SESSION['apellidos']; ?></p>
            </div>
        </div>
        
        <ul class="app-menu">
        <?php if($_SESSION['rol'] == 1) { ?>
            <li><a class="app-menu__item" href="./index.php"><i class="app-menu__icon fa fa-school"></i><span class="app-menu__label">Dashboard</span></a></li>
            <li class="treeview">
                <a class="app-menu__item" href="#" data-toggle="treeview"> 
                <i class="app-menu__icon fa fa-users"></i>
                <span class="app-menu__label">Usuarios</span>
                <i class="treeview-indicator fa fa-angle-right"></i> 
                </a>
                <ul class="treeview-menu">
                <li><a class="treeview-item" href="lista_usuarios.php"><i class="app-menu__icon fa fa-user-secret"></i>Lista de Usuarios</a></li>
                </ul> 
            </li>
            <?php } ?>
            
            <li class="treeview">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-folder-open"></i>
                <span class="app-menu__label">Documentos</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                <li><a class="treeview-item" href="lista_documentos.php"><i class="icon fa fa-file"></i>Mis documentos</a></li>
                </ul>
            </li>
            
            <li class="treeview">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fas fa-chalkboard-teacher"></i>
                <span class="app-menu__label">Act. de notas / aplazadas</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                <li><a class="treeview-item" href="lista_actasnotas.php"><i class="icon fa fa-circle-o"></i>Actas de notas </a></li>
                <li><a class="treeview-item" href="lista_actasaplazadas.php"><i class="icon fa fa-circle-o"></i>Actas aplazadas</a></li>
                </ul>
            </li>
            <li>
                <a class="app-menu__item" href="#">
                <i class="app-menu__icon far fa-file-pdf"></i>
                <span class="app-menu__label">Reportes</span>
                </a>
            </li>
            <li>
                <a class="app-menu__item" href="logout.php">
                <i class="app-menu__icon fa fa-sign-out fa-lg"></i>
                <span class="app-menu__label">Logout</span>
                </a>
            </li> 
        </ul>
    </aside> 