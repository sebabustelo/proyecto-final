<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Resolucione> $resoluciones
 */

//debug($resoluciones);
?>

<section id="ResolucionesList" class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header  with-border">
          <h3 class="box-title"> <span class="fa fa-search-plus fa-lg"></span> Buscador</h3>
          <div class="box-tools pull-right">

            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <?php
           $this->DiticHtml->addFilter(
            'titulo',
            [
              'label'    => 'Título',
              'placeholder'    => 'Título',
              'class' => 'form-control',
              'templates' => [
                'inputContainer' => '<div class="form-group col-md-4">{{content}}</div>'
              ],
              'value' => (isset($filters['titulo'])) ? $filters['titulo'] : '',
            ]
          );

          $this->DiticHtml->addFilter(
            'expediente',
            [
              'label'    => 'Expediente',
              'placeholder'    => 'Expediente',
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
              'placeholder'    => 'Proyecto',
              'class' => 'form-control',
              'templates' => [
                'inputContainer' => '<div class="form-group col-md-3 ">{{content}}</div>'
              ],
              'value' => (isset($filters['proyecto'])) ? $filters['proyecto'] : '',
            ]
          );

          $this->DiticHtml->addFilter(
            'numero',
            [
              'label'    => 'Número',
              'placeholder'    => 'Nro.',
              'class' => 'form-control',
              'templates' => [
                'inputContainer' => '<div class="form-group col-md-1 ">{{content}}</div>'
              ],
              'value' => (isset($filters['numero'])) ? $filters['numero'] : '',
            ]
          );

          $this->DiticHtml->addFilter(
            'anio',
            [
              'label'    => 'Año',
              'placeholder'    => 'Año',
              'templates' => [
                'inputContainer' => '<div class="form-group col-md-1">{{content}}</div>'
              ],
              'class' => 'form-control',
              'value' => (isset($filters['anio'])) ? $filters['anio'] : ''
            ]
          );
         
        

          $options['name'] = 'organismos';
          $options['id'] = 'organismo-id';
          $options['list'] = $organismos;
          $options['selected'] =  (isset($filters['organismos']['_ids'])) ? $filters['organismos']['_ids'] : [];
          $options['numberDisplayed'] = 12;
          $options['title'] = 'Organismos';
          $options['empty'] = 'Seleccione el/los organismo/s que desea filtrar  ';
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
          $options['title'] = 'Áreas de Origen';
          $options['empty'] = 'Seleccione el/las área/s que desea filtrar  ';
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
          $options['empty'] = 'Seleccione el/los documento/s que desea filtrar  ';
          $options['class'] = 'col-sm-4';

          $this->DiticHtml->addFilterElement(
            'custom_fields/multiselect',
            [
              'label'    => 'Título',
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
          $options['numberDisplayed'] = 1;
          $options['title'] = 'Cargos';
          $options['empty'] = 'Seleccione los cargos que desea filtrar  ';
          $options['class'] = 'col-sm-4 divCargos';

          $this->DiticHtml->addFilterElement(
            'custom_fields/multiselect-cargo',
            [
              'class' => 'form-control',
              'options' => $options,
            ]
          );

          $options['name'] = 'firmantes';
          $options['id'] = 'firmantes';
          $options['list'] = $funcionarios;
          $options['selected'] =  (isset($filters['firmantes']['_ids'])) ? $filters['firmantes']['_ids'] : [];
          $options['numberDisplayed'] = 1;
          $options['title'] = 'Firmantes';
          $options['empty'] = 'Seleccione el/los funcionario/s que desea filtrar  ';
          $options['class'] = 'col-sm-4 divFirmantes';

          $this->DiticHtml->addFilterElement(
            'custom_fields/multiselect-firmante',
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
          $options['empty'] = 'Seleccione el/las palabras/s que desea filtrar  ';
          $options['class'] = 'col-sm-4';

          $this->DiticHtml->addFilterElement(
            'custom_fields/multiselect',
            [
              'label'    => 'Título',
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
          $options['titulo'] = '&nbsp;';
          //$options['style'] = 'margin-top:38px;';

          $this->DiticHtml->addFilterElement(
            'custom_fields/checkbox',
            [
              'type' => 'checkbox',
              'class' => 'form-control',
              'options' => $options,
            ]
          );
          echo $this->DiticHtml->showFilter('GET', 'busqueda');
          ?>
          <?php if ($resolucionesContador > 10000) { ?>
            <div class="panel-body " style="clear: both;">
              <span class="label label-info  "> <i class="fa fa-info-circle" aria-hidden="true"></i> Debe refinar más la búsqueda para exportar los resultados.</span>
            </div>
          <?php } ?>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header  with-border">
          <h3 class="box-title"> <span class="fa fa fa-book fa-lg"></span>&nbsp;Resultados</h3>
          <div class="box-tools pull-right">
              <?php if (isset($resolucionesContador) && $resolucionesContador <= 10000  && $resolucionesContador > 0) { ?>
                <button id="exportar" class="btn btn-success ">
                  <span class="glyphicon glyphicon-download"></span> <span class="buttonText">Exportar</span></button>
                <script>
                  document.getElementById("exportar").addEventListener("click", function() {
                    // Obtener el formulario
                    var form = document.getElementById("formOrderFilter");
                    // Cambiar el atributo action del formulario para que lleve los filtros por get a la accion exportar que lo necesita para generar el excel.
                    form.action = "/resoluciones/exportar";
                    // Enviar el formulario
                    form.submit();
                  });
                </script>
              <?php } ?>            
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="col-md-12 table">
            <?php
            //debug($resoluciones);
            if (isset($resoluciones) and count($resoluciones) > 0) {
              $this->DiticHtml->generateReportTable(
                $resoluciones,
                array(
                  'Resoluciones.titulo'              => array('no-sort', 'class' => 'col-md-4', 'truncate', 'truncate-length' => 150, 'title' => 'Título'),
                  'Resoluciones.documento_tipo.descripcion'              => array('no-sort', 'class' => 'col-md-4', 'truncate', 'title' => 'Tipo Documento'),
                  'Resoluciones.numeroAnio'              => array('no-sort', 'function' => 'numeroAnio', 'title' => 'Nro/Año'),
                  'Resoluciones.fecha'              => array('no-sort', 'class' => 'col-md-1', 'date', 'title' => 'Fecha'),
                  'Resoluciones.area.codigo'              => array('no-sort', 'class' => 'col-md-1', 'text', 'title' => 'Área'),
                  'Resoluciones.cargos_funcionario.funcionario.full_name'                 => array('no-sort', 'class' => 'col-md-3', 'function' => 'funcionario', 'title' => 'Cargo/Firmante'),
                  'Resoluciones.palabras_clave.palabra'              => array('no-sort', 'truncate', 'title' => 'Palabra/s clave'),
                  'descargarArchivoPublico'                          => array(
                    'no-sort',
                    'edit' => 'descargarArchivoPublico',
                    'tooltip'       => 'Descargar Documento',
                    //'html'=> '<a href="/resoluciones/descargar-archivo/72544" class="editar btn btn-primary btn-xs download" title="Descargar Documento" target="_self"><span class="glyphicon glyphicon-download"></span></a>',
                    'class' => 'download',


                  ),

                  'view'                          => array(
                    //'no-sort',
                    'edit-action' => 'viewPublic',
                    'tooltip'       => 'Ver',
                    'class' => 'eye-open',


                  ),
                  // 'edit'                          => array(
                  //   'no-sort',
                  //   'edit-action' => 'edit',
                  //   'tooltip'       => 'Editar',
                  //   'class' => 'pencil',

                  // ),
                  // 'delete'                        => array(
                  //   'confirm'       => '¿Está seguro de que quiere borrar la configuracion?',
                  //   'tooltip'       => 'Eliminar',
                  //   'class'         => 'remove',
                  //   'delete-action'        => 'delete',
                  //Si tiene asociado resoluciones no muestra la opcion de eliminar

                  //)
                ),
                array('response' => '.wrapper')
              );
            } elseif (isset($resoluciones)) {
            ?>
              <div class="panel-body text-center ">
                <span class="label label-danger  col-md-12"> <i class="fa fa-times-circle" aria-hidden="true"></i>No se encontraron resultados que coincidan con el criterio de búsqueda.</span>
              </div>
            <?php } else { ?>
              <div class="panel-body text-center ">
                <span class="label label-info  col-md-12"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                  Debe aplicar algún filtro para realizar la búsqueda.</span>
              </div>

            <?php } ?>

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



<?php
function numeroAnio($content, $unit)
{
  echo  '<span class="badge ">' . ($unit['numero'] . '/' . $unit['anio']) . '</span>';
}


function funcionario($content, $unit)
{
  $id = (isset($unit['id'])) ? $unit['id'] : "";
  echo '<input type="hidden" name="ids_[]" value="' . $id . '">';
  if (isset($unit['cargos_funcionario']['cargo']['descripcion'])) {
    echo ($unit['cargos_funcionario']['cargo']['descripcion'] . '<br> ' . $unit['cargos_funcionario']['funcionario']['full_name']);
  } else {
    echo  '<span class="badge btn-default ">Sin Cargo/s asignados<br>Sin Firmante asignado</span>';
  }
}
?>