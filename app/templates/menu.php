<div class="app-body">
  <div class="sidebar">
    <nav class="sidebar-nav">
      <ul class="nav">
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon icon-check"></i>
            Dashboard
          </a>
          <ul class="nav-dropdown-items">
            <li class="nav-item">
              <a class="nav-link" href="<?=BASE_URL?>">
                <i class="nav-icon fa fa-check"></i> 
                Activos
              </a>
            </li>
            <?php if(has_role(1)){ ?>
              <?=make_link_menu('indicator/deleted_records', '<i class="nav-icon fa fa-minus"></i> Eliminados</a>', '')?>
            <?php } ?>
          </ul>
        </li>
        <?php if(has_role(1)){ ?>
          <li class="nav-item">
            <a class="nav-link" href="<?=BASE_URL?>indicator/indicators/reports">
              <i class="nav-icon icon-check"></i> 
              Reportes
            </a>
          </li>
          <?php if(has_role(1)){ ?>
            <li class="nav-item">
              <a class="nav-link modal" href="#" id="analisismodal_show">
                <i class="nav-icon icon-check"></i> 
                Analisis
              </a>
            </li>
          <?php } ?>
          <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
              <i class="nav-icon icon-wrench"></i> 
              Configuración
            </a>
            <ul class="nav-dropdown-items">

              <?=make_link_menu('indicator/type_processes', '<i class="nav-icon fa fa-list"></i> Tipos de Procesos</a>', '')?>
              <?=make_link_menu('indicator/types', '<i class="nav-icon fa fa-list"></i> Tipos de Indicadores</a>', '')?>
              <?=make_link_menu('indicator/processes', '<i class="nav-icon fa fa-list"></i>Procesos</a>', '')?>
              <?=make_link_menu('indicator/companies', '<i class="nav-icon fa fa-list"></i> Empresas</a>', '')?>
              <li class="nav-item">
                <a class="nav-link" href="<?=BASE_URL?>admin/users">
                  <i class="nav-icon icon-user"></i> 
                  Usuarios
                </a>
              </li>
            </ul>
          </li>
        <?php } ?>
      </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
  </div>