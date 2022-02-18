  <header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="/indicator/">
      <img class="navbar-brand-full" src="<?=BASE_URL?>public/assets/images/logo_full.png" width="110" height="38" alt="Logo">
      <img class="navbar-brand-minimized" src="<?=BASE_URL?>public/assets/images/logo_small.png" width="30" height="30" alt="Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none">
      <li class="nav-item px-3">
        <a class="nav-link modal" href="#change_company"><b><?=$_SESSION['user']['company_name']?></b></a>
      </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link modal" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <b><?=$_SESSION['user']['username']?></b>
          <img class="img-avatar" src="<?=BASE_URL?>public/assets/images/avatar.jpg" alt="admin@bootstrapmaster.com">
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-header text-center">
            <strong>Cuenta</strong>
          </div>
          <?=make_link('admin/users/change_password', '<i class="fa fa-key"></i> Cambiar Contraseña', 'dropdown-item')?>
          <?=make_link('admin/users/logout', '<i class="fa fa-lock"></i> Cerrar Sesión', 'dropdown-item')?>
        </div>
      </li>
    </ul>
    <!-- <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
      <i class="icon-bell"></i>
      <span id="noti-count" class="badge badge-pill badge-danger"></span>
    </button> -->
    <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
      <span class="navbar-toggler-icon"></span>
    </button>
  </header>

  <div id="change_company" class="modal">
  <form action="<?=BASE_URL?>indicator/users_companies/change_company" method="POST">
    <select name="company">
      <?php foreach ($_SESSION['user']['companies'] as $company) {
        ?>
        <option value="<?=$company['company_id']?>"><?=$company['company']?></option>
        <?php
      } ?>
    </select>
    <input type="submit" value="Cambiar Empresa" class="button dark">
  </form>
</div>

  <?php require 'menu.php' ?>