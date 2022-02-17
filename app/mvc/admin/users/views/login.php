<form method="POST">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h1>Login</h1>
                <p class="text-muted">SIG Indicadores</p>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-user"></i>
                    </span>
                  </div>
                  <input class="form-control" name="username" type="text" placeholder="Username">
                </div>
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-lock"></i>
                    </span>
                  </div>
                  <input class="form-control" name="password" type="password" placeholder="Password">
                </div>
                <div class="row">
                  <div class="col-5">
                  	<input class="btn btn-primary px-4" type="submit" value="Login">
                  </div>
                  <div class="col-7 text-right">
                  	<a href="#bad" class="modal">¿Olvidaste tu contraseña?</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="card text-white py-5 d-md-down-none" style="width:44%; background: #182227; border: 0px">
              <div class="card-body">
                  <div class="text-center" style="line-height: 200px">
                    <img src="<?=BASE_URL?>public/assets/images/logo_full_2.png" width="280" class="img-responsive">
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</form>

<div id="bad" class="modal">
	<center><h3>Pues que mal :/</h3></center>
</div>
<script>
	/* CLEAR DATA GRID */
	var arr = [];
	for (var i = 0; i < localStorage.length; i++)
	{
		if (localStorage.key(i).substring(0,19) == 'DataTables_datagrid')
		{
			arr.push(localStorage.key(i));
		}
	}

	for (var i = 0; i < arr.length; i++)
	{
		localStorage.removeItem(arr[i]);
	}

	document.cookie = "init_notification =; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
</script>
