<div class="app-body">
  <div class="sidebar">
    <nav class="sidebar-nav">
      <ul class="nav">
        <li class="nav-item">
          <a class='nav-link' href='<?=BASE_URL?>'>
            <i class="nav-icon icon-check"></i>
           Dashboard
          </a>
          
        </li>
        
        <?php if(has_role(1)){ ?>
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon icon-check"></i> 
            Reportes
          </a>
          <ul class="nav-dropdown-items">
            <li class='nav-item'>
                <a class='nav-link' href='<?=BASE_URL?>indicator/indicators/reports'>
                  <i class="nav-icon fa fa-list"></i>
                 Reporte por proceso
                </a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='<?=BASE_URL?>indicator/indicators/general_report'>
                  <i class="nav-icon fa fa-list"></i>
                 Reporte General
                </a>
            </li>
          </ul>
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
            <li class="nav-item">
              <a class="nav-link" href="<?=BASE_URL?>indicator/type_processes">
                <i class="nav-icon fa fa-list"></i>
                Tipos de Procesos
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?=BASE_URL?>admin/users">
                <i class="nav-icon fa fa-list"></i>
                Tipos de Indicadores
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?=BASE_URL?>admin/users">
                <i class="nav-icon fa fa-list"></i>
                Empresas
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?=BASE_URL?>admin/users">
                <i class="nav-icon icon-user"></i> 
                Usuarios
              </a>
            </li>
          </ul>
        </li>
        <?php } ?>
        <!-- <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon icon-arrow-down-circle"></i> 
            Indicadores
          </a>
            <ul class="nav-dropdown-items">
              <?=make_link_menu('tbs/input_forms', '<i class="nav-icon fa fa-file-text-o"></i> Formularios</a>', '')?>
              <?=make_link_menu('tbs/transport_input_forms', '<i class="nav-icon fa fa-truck"></i> Transportes</a>', '')?>
              <?=make_link_menu('tbs/input_forms_inspections_products', '<i class="nav-icon fa fa-check-square-o"></i> Inspecciones</a>', '')?>
            </ul>
          </li> -->
          
            </ul>
          </nav>
          <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>