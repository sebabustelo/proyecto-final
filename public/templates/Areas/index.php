<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Area> $areas
 */
?>
<section id="AreasList" class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header  with-border">
          <h3 class="box-title"> <span class="fa fa-search fa-lg"></span> Buscador</h3>
          <div class="box-tools pull-right">

            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <?php
          $this->DiticHtml->addFilter(
            'codigo',
            [
              'label'    => false,
              'placeholder'    => 'Código',
              'class' => 'form-control',
              'templates' => [
                'inputContainer' => '<div class="form-group col-md-5">{{content}}</div>'
              ],
              'value' => (isset($filters['codigo'])) ? $filters['codigo'] : ''
              // 'div'	=> false
            ]
          );

          $this->DiticHtml->addFilter(
            'descripcion',
            [
              'label'    => false,
              'placeholder'    => 'Descripción',
              'class' => 'form-control',

              'templates' => [
                'inputContainer' => '<div class="form-group col-md-5">{{content}}</div>'
              ],
              'value' => (isset($filters['descripcion'])) ? $filters['descripcion'] : ''
              // 'div'	=> false
            ]
          );

          $options['class'] = 'col-sm-2';
          $options['checked'] =  (!isset($filters['activo'])) ? 'checked' : (($filters['activo']) ? 'checked' : '');
          $options['style'] = "";

          $this->DiticHtml->addFilterElement(
            'custom_fields/checkbox',
            [
              'type' => 'checkbox',
              'class' => 'form-control',
              'options' => $options,
            ]
          );


          echo $this->DiticHtml->showFilter();
          ?>
          <div class="panel-body ">
            <span class="label label-info  "> <i class="fa fa-info-circle" aria-hidden="true"></i> Por defecto se muestran las Áreas Activas.</span>
          </div>
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
          <h3 class="box-title"> <span class="fa fa-sitemap fa-lg"></span>&nbsp;Áreas</h3>
          <div class="box-tools pull-right">
            <?php if (!empty($accionesPermitidas['areas']['add'])) { ?>
              <a href="/areas/add" id="addArea" class="btn btn-primary ">
                <span class="glyphicon glyphicon-plus-sign"></span> <span class="buttonText">Nueva Área</span></a>
            <?php } ?>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <?php
          if (isset($areas) and count($areas) > 0) {
            $this->DiticHtml->generateReportTable(
              $areas,
              array(
                'Areas.codigo'              => array('truncate', 'title' => 'Código'),
                'Areas.descripcion'              => array('truncate', 'truncate-length' => 50,  'title' => 'Descripción'),
                'Areas.resoluciones.titulo'              => array('function' => 'cantidadResoluciones', 'title' => 'Resoluciones'),
                'view' => array(
                  'tooltip'       => 'ver',
                  'class' => 'eye-open',
                ),
                'edit'                          => array(
                  'no-sort',
                  'edit-action' => 'edit',
                  'tooltip'       => 'Editar',
                  'class' => 'pencil',

                ),
                'delete'                        => array(
                  'confirm'       => '¿Está seguro de que quiere borrar la configuracion?',
                  'tooltip'       => 'Eliminar',
                  'class'         => 'remove',
                  'delete-action'        => 'delete',
                  'conditions' => 'resoluciones'
                  //Si tiene asociado resoluciones no muestra la opcion de eliminar

                )
              )
            );
          } else {
          ?>
            <div class="panel-body text-center ">
              <span class="label label-danger  col-md-12"> <i class="fa fa-times-circle" aria-hidden="true"></i>No se encontraron resultados que coincidan con el criterio de búsqueda.</span>
            </div>
          <?php } ?>

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
function cantidadResoluciones($content, $unit)
{

  if (isset($unit['resoluciones'][0]['cantidad'])) {
    echo  '<button class="btn btn-default" type="button"> Asociadas  <span class="badge btn">' . ($unit['resoluciones'][0]['cantidad']) . '</span></button>';
  } else {
    echo  '<button class="btn btn-default" type="button">
    Asociadas  <span class="badge btn">0</span>
  </button>';
  }
}
?>