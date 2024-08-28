<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Resolucione> $resoluciones
 */

//debug($resoluciones);
?>

<section id="BuscarResolucionesList" class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header  with-border">
          <h3 class="box-title"> <span class="fa fa-search-plus fa-lg"></span> Búsqueda</h3>
          <div class="box-tools pull-right">

            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <?php

          $this->DiticHtml->addFilter(
            'id',
            [
              'label'    => 'id',
              // 'placeholder'    => 'Proyecto',
              'class' => 'form-control',
              'templates' => [
                'inputContainer' => '<div class="form-group col-md-3 " style="display:none;">{{content}}</div>'
              ],
              'value' => (isset($id)) ? $id : null,
            ]
          );

          $this->DiticHtml->addFilter(
            'expediente',
            [
              'label'    => 'Expediente',
              //'placeholder'    => 'Expediente',
              'class' => 'form-control',
              'templates' => [
                'inputContainer' => '<div class="form-group col-md-3 ">{{content}}</div>'
              ],
              'value' => (isset($filters['expediente'])) ? $filters['expediente'] : '',
            ]
          );

          $this->DiticHtml->addFilter(
            'proyecto',
            [
              'label'    => 'Proyecto',
              // 'placeholder'    => 'Proyecto',
              'class' => 'form-control',
              'templates' => [
                'inputContainer' => '<div class="form-group col-md-3 ">{{content}}</div>'
              ],
              'value' => (isset($filters['proyecto'])) ? $filters['proyecto'] : '',
            ]
          );


          $this->DiticHtml->addFilter(
            'titulo',
            [
              'label'    => 'Título',
              //'placeholder'    => 'Título',
              'class' => 'form-control',
              'templates' => [
                'inputContainer' => '<div class="form-group col-md-3">{{content}}</div>'
              ],
              'value' => (isset($filters['titulo'])) ? $filters['titulo'] : '',
            ]
          );

          $this->DiticHtml->addFilter(
            'numero',
            [
              'label'    => 'Número',
              //'placeholder'    => 'Nro.',
              'class' => 'form-control',
              'templates' => [
                'inputContainer' => '<div class="form-group col-md-1 ">{{content}}</div>'
              ],
              'value' => (isset($filters['numero'])) ? $filters['numero'] : '',
            ]
          );

          $anio_actual = date("Y");
          $anio_inicial = 1990;
          for ($anio = $anio_actual; $anio >= $anio_inicial; $anio--) {
            $anios[$anio] = $anio;
          }


          $options['name'] = 'anio';
          $options['id'] = 'anio';
          $options['list'] = $anios;
          $options['selected'] =  (isset($filters['anio'])) ? $filters['anio'] : [];
          $options['numberDisplayed'] = 2;
          $options['title'] = 'Año';
          $options['empty'] = 'Año/s';
          $options['class'] = 'col-sm-2';

          $this->DiticHtml->addFilterElement(
            'custom_fields/multiselect',
            [
              'class' => 'form-control',
              'options' => $options,
            ]
          );

          $options['name'] = 'organismos';
          $options['id'] = 'organismo-id';
          $options['list'] = $organismos;
          $options['selected'] =  (isset($filters['organismos']['_ids'])) ? $filters['organismos']['_ids'] : [];
          $options['numberDisplayed'] = 12;
          $options['title'] = 'Organismos';
          $options['empty'] = 'Seleccione el/los organismo/s';
          $options['class'] = 'col-sm-4';

          $this->DiticHtml->addFilterElement(
            'custom_fields/multiselect',
            [
              'class' => 'form-control',
              'options' => $options,
            ]
          );

          $options['name'] = 'areas';
          $options['id'] = 'areas';
          $options['list'] = $areas;
          $options['selected'] =  (isset($filters['areas']['_ids'])) ? $filters['areas']['_ids'] : [];
          $options['numberDisplayed'] = 12;
          $options['title'] = 'Área/s de Origen';
          $options['empty'] = 'Seleccione el/las área/s          ';
          $options['class'] = 'col-sm-4';

          $this->DiticHtml->addFilterElement(
            'custom_fields/multiselect',
            [
              'class' => 'form-control',
              'options' => $options,
            ]
          );

          $options['name'] = 'documento_tipos';
          $options['id'] = 'documento_tipos';
          $options['list'] = $documentoTipos;
          $options['selected'] =  (isset($filters['documento_tipos']['_ids'])) ? $filters['documento_tipos']['_ids'] : [];
          $options['numberDisplayed'] = 12;
          $options['title'] = 'Tipo de Documento';
          $options['empty'] = 'Seleccione el/los documento/s ';
          $options['class'] = 'col-sm-4';

          $this->DiticHtml->addFilterElement(
            'custom_fields/multiselect',
            [
              // 'label'    => ['class'=>'btn btn-default btn-group'],
              //  'checked'    => (!isset($filters['activo'])) ? 'checked' : (($filters['activo']) ? 'checked' : ''),
              'class' => 'form-control',
              'options' => $options,
              'templates' => [
                'inputContainer' => '<div class="form-group col-md-4">{{content}}</div>'
              ],
              'type' => 'date_range',
            ]
          );

          $options['name'] = 'cargos';
          $options['id'] = 'cargos';
          $options['list'] = $cargos;
          $options['selected'] =  (isset($filters['cargos']['_ids'])) ? $filters['cargos']['_ids'] : [];
          $options['numberDisplayed'] = 12;
          $options['title'] = 'Cargos';
          $options['empty'] = 'Seleccione el/los cargo/s    ';
          $options['class'] = 'col-sm-4';

          $this->DiticHtml->addFilterElement(
            'custom_fields/multiselect',
            [
              'class' => 'form-control',
              'options' => $options,
            ]
          );

          $options['name'] = 'firmantes';
          $options['id'] = 'firmantes';
          $options['list'] = $funcionarios;
          $options['selected'] =  (isset($filters['firmantes']['_ids'])) ? $filters['firmantes']['_ids'] : [];
          $options['numberDisplayed'] = 12;
          $options['title'] = 'Firmantes';
          $options['empty'] = 'Seleccione el/los funcionario/s ';
          $options['class'] = 'col-sm-4';

          $this->DiticHtml->addFilterElement(
            'custom_fields/multiselect',
            [
              'label'    => 'Título',
              'class' => 'form-control',
              'options' => $options,
              'type' => 'date_range',
            ]
          );


          $options['name'] = 'palabras_claves';
          $options['id'] = 'palabras_claves';
          $options['list'] = $palabras_claves;
          $options['selected'] =  (isset($filters['palabras_claves']['_ids'])) ? $filters['palabras_claves']['_ids'] : [];
          $options['numberDisplayed'] = 12;
          $options['title'] = 'Palabras Claves';
          $options['empty'] = 'Seleccione el/las palabras/s';
          $options['class'] = 'col-sm-4';

          $this->DiticHtml->addFilterElement(
            'custom_fields/multiselect',
            [
              'class' => 'form-control',
              'options' => $options,
            ]
          );

          if (isset($filters['fecha_firma'])) {
            $fechas = explode(' - ', $filters['fecha_firma']);
          }

          $this->DiticHtml->addFilterElement(
            'custom_fields/date_range',
            [
              'class' => 'form-control',
              'templates' => [
                'inputContainer' => '<div class="form-group col-md-2">{{content}}</div>'
              ],
              'type' => 'date_range',
              'startDate' => (isset($fechas[0])) ? $fechas[0] : '',
              'endDate' => (isset($fechas[1])) ? $fechas[1] : '',
            ]
          );

          $options['class'] = 'col-sm-2';
          $options['checked'] =  (!isset($filters['activo'])) ? 'checked' : (($filters['activo']) ? 'checked' : '');
          //$options['style'] = '';
          $options['titulo'] = '&nbsp;';

          $this->DiticHtml->addFilterElement(
            'custom_fields/checkbox',
            [
              'type' => 'checkbox',
              'class' => 'form-control',
              'options' => $options,

            ]
          );


          $texts = array('filter' => 'Buscar');
          echo $this->DiticHtml->showFilter('GET', 'buscarResolucionAsociada', $texts);
          ?>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>

  <div class="row" id="listadoResoluciones">
    <?php echo $this->element('resoluciones/listadoResoluciones'); ?>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

<script>
  $(function() {
    $('#limpiar').on('click', function(e) {
      e.preventDefault();
      $('#formOrderFilter').find('input:text, input:password, select, textarea').val('');
      $('#formOrderFilter').find('input:radio, input:checkbox:not(#activo)').prop('checked', false);
      document.getElementById("activo").checked = true;
      var today = new Date();
      $('#fecha_firma')
        .data('daterangepicker')
        .setStartDate(today.getDate() - 60);
      $('#fecha_firma')
        .data('daterangepicker')
        .setEndDate(today);
      $('#fecha_firma')
        .data('daterangepicker')
        .updateCalendars();
      var divParaEliminar = document.getElementById("resolucionesAsociadas");
      // Eliminar el div
      if (divParaEliminar) {
        divParaEliminar.remove();
      }

      return false;
    });
  });
</script>