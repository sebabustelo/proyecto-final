<section id="ConfiguracionesList" class="content">

  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header  with-border">
          <h3 class="box-title"> <span class="fa fa-wrench fa-lg"></span> Configuraciones</h3>
          <div class="box-tools pull-right">
            <?php if (!empty($accionesPermitidas['configuraciones']['agregar'])) { ?>
              <a href="/rbac/configuraciones/agregar/" id="agregarConfiguracion" class="btn btn-primary ">
                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText"> Configuracion</span></a>
            <?php } ?>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-md-12 table">
            <?php
            if (isset($configuraciones)) {
              $this->DiticHtml->generateReportTable(
                $configuraciones,
                array(
                  'Configuraciones.clave'              => array('truncate', 'title' => 'Clave'),
                  'Configuraciones.valor'              => array('truncate', 'truncate-length' => 50, 'no-sort', 'title' => 'Valor'),
                  'edit'                          => array(
                    'no-sort',
                    'edit-action' => 'editar',
                    'tooltip'       => 'Editar',
                    'class' => 'pencil'
                  ),
                  'delete'                        => array(
                    'confirm'       => '¿Está seguro de que quiere borrar la configuracion?',
                    'tooltip'       => 'Eliminar',
                    'class'         => 'remove',
                    'delete-action'        => 'eliminar'
                  )
                )
              );
            }
            ?>
            <div class="alert alert-info">
              Aquellas claves cuyos nombres terminen con _enc guardarán sus valores encriptados.<br />
            </div>

            <div class="row">
              <div class=" col-sm-3">
                <div class="info-box bg-blue">
                  <a class="info-box-icon " style="color: white;" href="/rbac/configuraciones/index/1"><i class="ion ion-ios-cloud-download-outline"></i></a>
                  <div class="info-box-content">
                    <span class="info-box-text"> Error Log</a></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span>
                      Descargar archivo de errores de PHP
                    </span>
                  </div>
                </div>
              </div>
              <div class=" col-sm-3">
                <div class="info-box bg-blue">
                  <a class="info-box-icon " style="color: white;" href="/rbac/configuraciones/index/2"><i class="ion ion-ios-cloud-download-outline"></i></a>
                  <div class="info-box-content">
                    <span class="info-box-text"> Debug Log</a></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span>
                      Descargar archivo de Debug de PHP
                    </span>
                  </div>
                </div>
              </div>
              <div class=" col-sm-3">
                <div class="info-box bg-blue">
                  <a class="info-box-icon" style="color: white;" href="/rbac/configuraciones/index/1"><i class="fa fa-eraser"></i></a>
                  <div class="info-box-content">
                    <span class="info-box-text">Limpiar Cache</a></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span>
                      Eliminar los archivos de cache de CAKE
                    </span>
                  </div>
                </div>
              </div>
              <div class=" col-sm-3">
                <div class="info-box bg-blue">
                  <a class="info-box-icon " style="color: white;" href="/rbac/configuraciones/index/2"><i class="fa fa-eraser"></i></a>
                  <div class="info-box-content">
                    <span class="info-box-text">Limpiar Logs</a></span>
                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span>
                      Vaciar contenido de archivos de logs
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        
        <div class="box box-default collapsed-box">
          <div class="box-header with-border">
            <h3 class="box-title">PHP INFO</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <ul>

              <?php
              ob_start();
              phpinfo();
              $pinfo = ob_get_contents();
              ob_end_clean();

              $pinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo);
              //echo $pinfo;
              echo '<pre>' . shell_exec("php -r 'phpinfo();'") . '</pre>';
              ?>
            </ul>
          </div>
        </div>

        <div class="box box-default collapsed-box">
          <div class="box-header with-border">
            <h3 class="box-title">Variables de Entorno Generales</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <ul>
              <?php
              foreach (getenv() as $varname => $varVal) {
                echo '<li>' . $varname . ':' . $varVal . '</li>';
              }
              ?>
            </ul>
          </div>
        </div>


        <div class="box box-default collapsed-box">
          <div class="box-header with-border">
            <h3 class="box-title">Variables de Configuración</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <?php
            echo 'Espacio disponible en disco: ' . intval(disk_free_space("/") / 1024 / 1024) . ' MB';
            echo '<br />APP_NAME:' . env('APP_NAME');
            echo '<br />AMBIENTE:' . env('AMBIENTE');
            echo '<br />DEBUG:';
            if (env('DEBUG')) {
              echo 'true';
            } else {
              echo 'false';
            }
            echo '<br />APP_ENCODING:' . env('APP_ENCODING');
            echo '<br />APP_DEFAULT_LOCALE:' . env('APP_DEFAULT_LOCALE');
            echo '<br />APP_DEFAULT_TIMEZONE:' . env('APP_DEFAULT_TIMEZONE');

            echo '<br />DATABASE_DEFAULT_HOST:' . env('DATABASE_DEFAULT_HOST');
            echo '<br />DATABASE_DEFAULT_PORT:' . env('DATABASE_DEFAULT_PORT');
            echo '<br />DATABASE_DEFAULT_USERNAME:' . env('DATABASE_DEFAULT_USERNAME');
            echo '<br />DATABASE_DEFAULT_PASSWORD:' . env('DATABASE_DEFAULT_PASSWORD');
            echo '<br />DATABASE_DEFAULT_NAME:' . env('DATABASE_DEFAULT_NAME');
            echo '<br />DATABASE_DEFAULT_LOG:' . env('DATABASE_DEFAULT_LOG');
            echo '<br />DATABASE_DEFAULT_ENCODING:' . env('DATABASE_DEFAULT_ENCODING');
            echo '<br />DATABASE_DEFAULT_TIMEZONE:' . env('DATABASE_DEFAULT_TIMEZONE');

            echo '<br />EMAIL_PORT:' . env('EMAIL_PORT');
            echo '<br />EMAIL_HOST:' . env('EMAIL_HOST');
            echo '<br />EMAIL_USERNAME:' . env('EMAIL_USERNAME');
            //echo '<br />EMAIL_PASSWORD:'.env('EMAIL_PASSWORD');
            echo '<br />EMAIL_TRANSPORT:' . env('EMAIL_TRANSPORT');
            echo '<br />EMAIL_TIMEOUT:' . env('EMAIL_TIMEOUT');
            echo '<br />EMAIL_TLS:';
            if (env('EMAIL_TLS')) {
              echo 'true';
            } else {
              echo 'false';
            }
            echo '<br />EMAIL_SSL_VERIFY_PEER:';
            if (env('EMAIL_SSL_VERIFY_PEER')) {
              echo 'true';
            } else {
              echo 'false';
            }
            echo '<br />EMAIL_SSL_PEER_NAME:';
            if (env('EMAIL_SSL_PEER_NAME')) {
              echo 'true';
            } else {
              echo 'false';
            }
            echo '<br />EMAIL_SSL_ALLOW_SELF_SIGNED:';
            if (env('EMAIL_SSL_ALLOW_SELF_SIGNED')) {
              echo 'true';
            } else {
              echo 'false';
            }
            echo '<br />EMAIL_CLIENT:' . env('EMAIL_CLIENT');
            echo '<br />EMAIL_CHARSET:' . env('EMAIL_CHARSET');
            echo '<br />EMAIL_HEADER_CHARSET:' . env('EMAIL_HEADER_CHARSET');
            echo '<br />EMAIL_LOG:';
            if (env('EMAIL_LOG')) {
              echo 'true';
            } else {
              echo 'false';
            }
            echo '<br />EMAIL_DEFAULT_TRANSPORT:' . env('EMAIL_DEFAULT_TRANSPORT');

            echo '<br />LDAP_HOSTNAME:' . env('LDAP_HOSTNAME');
            echo '<br />LDAP_BASE:' . env('LDAP_BASE');
            ?>
          </div>
        </div>


        <div class="box box-default collapsed-box">
          <div class="box-header with-border">
            <h3 class="box-title">$_SERVER</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="box-body">
            <ul>
              <li><?php echo 'HOST REMOTO: ' . gethostbyaddr($_SERVER['REMOTE_ADDR']); ?></li>
              <!--li><?php //echo 'HOST IP REMOTA: ' . gethostbyaddr($_SERVER['HTTP_X_REAL_IP']); 
                      ?></li!-->
              <?php
              foreach ($_SERVER as $varname => $varVal) {
                echo '<li>' . $varname . ':' . $varVal . '</li>';
              }
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
  </div>
  <!-- /.col -->
  </div>
  <!-- /.row -->
</section>



<script type="text/javascript">
  $("#btnLimpiar").on("click", function(e) {
    e.preventDefault();
    /*$('#formConfiguracion')[0].reset();  
    $("#formConfiguracion").trigger("submit");*/
    window.location.href = "/rbac/configuraciones/?inicio=1";
  });
</script>