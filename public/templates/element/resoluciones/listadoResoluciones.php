<div class="col-xl-12">
  <div class="box box-primary">
    <div class="box-header  with-border">
      <h3 class="box-title"> <span class="fa fa fa-book fa-lg"></span>&nbsp;Registros</h3>
      <div class="box-tools pull-right">

        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="col-xl-12 table" id="resolucionesAsociadas">
        <?php
        // debug($resoluciones);
        // //debug({{count}})
        if (isset($resoluciones) and count($resoluciones) > 0) {
          if (count($resoluciones) > 5) {
            echo ' <pre class="label label-info">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            Total de Resultados ' . count($resoluciones) . ' .</pre><br><br>';
          }

          $this->DiticHtml->generateReportTable(
            $resoluciones,
            array(       
              'Resoluciones.titulo'              => array('class' => 'col-md-4', 'truncate', 'truncate-length' => 150, 'title' => 'Título'),       
              'Resoluciones.documento_tipo.descripcion'              => array('no-sort','class' => 'col-md-4', 'truncate', 'title' => 'Tipo Documento'),              
              'Resoluciones.numeroAnio'              => array('no-sort','function' => 'numeroAnio', 'title' => 'Nro/Anio'),          
              'Resoluciones.fecha'              => array('no-sort','class' => 'col-md-1', 'date', 'title' => 'Fecha'),
              'Resoluciones.area.codigo'              => array('no-sort','class' => 'col-md-1', 'text', 'title' => 'Área de Origen'),
              'Resoluciones.cargos_funcionario.funcionario.full_name'                 => array('no-sort','class' => 'col-md-3', 'function' => 'funcionario', 'title' => 'Cargo/Firmante'),

              //'Resoluciones.titulo'              => array('class' => 'col-md-5', 'truncate', 'truncate-length' => 150, 'title' => 'Título'),
              //   'Resoluciones.palabras_clave.palabra'              => array('truncate', 'title' => 'Palabra/s'),


              'modificado'                          => array(
                'no-sort',
                'edit-action' => '#',
                'tooltip'       => 'Modificado por',
                'html' => '<button class="modificado-por btn btn-primary"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Modificado por</button>'

              ),
              'modificada'                          => array(
                'no-sort',
                'edit-action' => '#',
                'tooltip'       => 'Modificada',
                'html' => '<button class="modificado-a btn btn-primary"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Modificada a</button>'

              ),
            
            ),
            array('response' => '#listadoResoluciones')
            // array('no-pagination')
          );

        ?>
        
        <?php
        } elseif (isset($resoluciones)) {
        ?>
          <div class="panel panel-default">
            <div class="panel-body ">
              <pre class="label label-danger">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                No se encontraron resultados que coincidan con el/los filtros de búsqueda.</pre>
              </h3>
            </div>
          </div>
        <?php } else { ?>
          <div class="panel panel-default">
            <div class="panel-body ">
              <pre class="label label-info">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                Debe aplicar algún filtro para realizar la búsqueda.</pre>
              </h3>
            </div>
          </div>

        <?php } ?>

      </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>

<?php
function numeroAnio($content, $unit)
{
  echo  '<span class="badge ">' . ($unit['numero'] . '/' . $unit['anio']) . '</span>';
}


function funcionario($content, $unit)
{
  //debug($unit);
  $id = (isset($unit['id'])) ? $unit['id'] : "";
  echo '<input type="hidden" name="ids_[]" value="' . $id . '">';
  if (isset($unit['cargos_funcionario']['cargo']['descripcion'])) {
    echo   ($unit['cargos_funcionario']['cargo']['descripcion'] . '<br> ' . $unit['cargos_funcionario']['funcionario']['full_name']) ;
  } else {
    echo  '<span class="badge btn-warning ">Sin Cargo/s asignados<br>Sin Firmante asignado</span>';
  }
}

function input($content, $unit)
{
}

?>

<script>
  // Obtener todos los enlaces con la clase 'modificado-por'
  const botonModificadoPor = document.querySelectorAll('.modificado-por');

  // Iterar sobre los enlaces y agregar un event listener a cada uno
  botonModificadoPor.forEach(boton => {
    boton.addEventListener('click', (e) => {
      e.preventDefault();
      var confirmacion = confirm("¿Estás seguro de asociar que la resolucion como 'modifico por'?");

      // Comprobar si el usuario confirmó
      if (confirmacion) {
        // Si el usuario confirmó, agrego la resolucion a la lista        
        const fila = boton.closest('tr');
        const filaClonada = fila.cloneNode(true);

        filaClonada.deleteCell(5)
        filaClonada.deleteCell(5)

        let primerInput = filaClonada.querySelector('input')
        primerInput.name = 'resolucion_relacionadas_modificada[][resolucion_modificadora_id]';
        //primerInput.id = 'resolucion_relacionadas_modificada[]';

        const tablaDestinoCompleta = document.getElementById('tablaDestino');

        // Verificar si existe el tbody
        let tbody = tablaDestinoCompleta.querySelector('tbody');
        if (!tbody) {
          // Si no existe, crear el tbody
          tbody = document.createElement('tbody');
          // Agregar el tbody a la tabla
          tablaDestinoCompleta.appendChild(tbody);
        }

        // Crear nueva celda para el botón "Eliminar"
        const celdaEliminar = document.createElement('td');

        // Agregar botón "Eliminar" a la fila clonada
        const botonEliminar = document.createElement('button');
        //botonEliminar.textContent = 'Eliminar';
        var iconoEliminar = document.createElement("span");
        iconoEliminar.className = "glyphicon glyphicon-remove";
        // Agrega el icono como hijo del botón
        botonEliminar.appendChild(iconoEliminar);

        botonEliminar.classList.add('btn-sm', 'btn-danger', 'eliminar-fila');
        botonEliminar.addEventListener('click', () => {
          var tbody = filaClonada.parentNode;
          var filasRestantes = tbody.querySelectorAll('tr').length;

          // Si no quedan más filas, eliminar también el thead
          if (filasRestantes === 1) {
            var tabla = tbody.closest('table');
            tabla.querySelector('thead').remove();
          }
          // Eliminar la fila al hacer clic en el botón "Eliminar"
          filaClonada.remove();
        });

        celdaEliminar.appendChild(botonEliminar);
        filaClonada.appendChild(celdaEliminar);

        // Seleccionar todos los elementos con el nombre "resolucion_relacionadas_modificada[][resolucion_modificadora_id]" en la tabla destino
        let inputsRelacionesAsociadasIds = document.querySelectorAll('input[name="resolucion_relacionadas_modificada[][resolucion_modificadora_id]"]');
        // // Iterar sobre los elementos seleccionados      
        filaExiste = false;
        inputsRelacionesAsociadasIds.forEach(function(input) {
          if (input.value == primerInput.value) {
            filaExiste = true;
          }
        });

        // Si la fila no existe, agregarla a la tabla de destino
        if (!filaExiste) {
          const nuevaCelda = document.createElement('td');
          nuevaCelda.textContent = 'Modificado Por';

          // Agregar la nueva celda al principio de la fila
          filaClonada.insertBefore(nuevaCelda, filaClonada.firstChild);

          tbody.appendChild(filaClonada);
          clonarTH()
          alert("Resolucion agregada")
        } else {
          alert('La fila ya está en la tabla de destino.');
        }
      }


    });

  });

  const botonModificadoA = document.querySelectorAll('.modificado-a');

  // Iterar sobre los enlaces y agregar un event listener a cada uno
  botonModificadoA.forEach(boton => {
    boton.addEventListener('click', (e) => {
      e.preventDefault();

      var confirmacion = confirm("¿Estás seguro de asociar que la resolucion como 'modifica'?");

      // Comprobar si el usuario confirmó
      if (confirmacion) {

        const fila = boton.closest('tr');
        const filaClonada = fila.cloneNode(true);
        filaClonada.deleteCell(5)
        filaClonada.deleteCell(5)

        let primerInput = filaClonada.querySelector('input')
        primerInput.name = 'resolucion_relacionadas_modificadora[][resolucion_modificada_id]';
        // primerInput.id = 'resolucion_relacionadas_modificadora[]';


        const tablaDestinoCompleta = document.getElementById('tablaDestino');

        // Verificar si existe el tbody
        let tbody = tablaDestinoCompleta.querySelector('tbody');
        if (!tbody) {
          // Si no existe, crear el tbody
          tbody = document.createElement('tbody');
          // Agregar el tbody a la tabla
          tablaDestinoCompleta.appendChild(tbody);
        }

        // Crear nueva celda para el botón "Eliminar"
        const celdaEliminar = document.createElement('td');

        // Agregar botón "Eliminar" a la fila clonada
        const botonEliminar = document.createElement('button');
        //botonEliminar.textContent = 'Eliminar';
        var iconoEliminar = document.createElement("span");
        iconoEliminar.className = "glyphicon glyphicon-remove";
        // Agrega el icono como hijo del botón
        botonEliminar.appendChild(iconoEliminar);
        botonEliminar.classList.add('btn-sm', 'btn-danger', 'eliminar-fila');
        botonEliminar.addEventListener('click', () => {
          // Eliminar la fila al hacer clic en el botón "Eliminar"
          filaClonada.remove();
        });
        celdaEliminar.appendChild(botonEliminar);
        filaClonada.appendChild(celdaEliminar);

        // Seleccionar todos los elementos con el nombre "resolucion_relacionadas_modificada[][resolucion_modificadora_id]" en la tabla destino
        let inputsRelacionesAsociadasIds = document.querySelectorAll('input[name="resolucion_relacionadas_modificadora[][resolucion_modificada_id]"]');
        // // Iterar sobre los elementos seleccionados      
        filaExiste = false;
        inputsRelacionesAsociadasIds.forEach(function(input) {
          if (input.value == primerInput.value) {
            filaExiste = true;
          }
        });

        // Si la fila no existe, agregarla a la tabla de destino
        if (!filaExiste) {
          const nuevaCelda = document.createElement('td');
          nuevaCelda.textContent = 'Modificado A';

          // Agregar la nueva celda al principio de la fila
          filaClonada.insertBefore(nuevaCelda, filaClonada.firstChild);

          tbody.appendChild(filaClonada);
          clonarTH()
          alert("Resolucion agregada")
        } else {
          alert('La fila ya está en la tabla de destino.');
        }
      }

    });


  });

  function clonarTH() {
    // Obtener la tabla original y la fila de encabezado, que esta en el primer elemento con la clase 'table-ajax'
    const tablaOriginal = document.getElementsByClassName("table-ajax")[0];
    
    const thOriginal = tablaOriginal.querySelector("thead tr");

    // Verificar si la tabla de destino tiene un <thead>, si no, agregar uno
    if (!tablaDestino.querySelector('thead')) {
      // Crear un nuevo elemento <thead> y una nueva fila de encabezado
      const nuevoThead = document.createElement('thead');
      const nuevaFilaEncabezado = document.createElement('tr');

      // Clonar la celda de encabezado original
      const thClonado = thOriginal.cloneNode(true);

      // Crear una nueva celda (<th>) con el texto deseado
      const nuevaCelda = document.createElement('th');
      nuevaCelda.textContent = 'Resolución Relacionada';

      // Agregar la nueva celda al principio de la fila de encabezado clonada
      thClonado.insertBefore(nuevaCelda, thClonado.firstChild);

      // Agregar la fila de encabezado clonada al nuevo <thead>
      nuevoThead.appendChild(thClonado);

      // Agregar el nuevo <thead> a la tabla de destino
      tablaDestino.appendChild(nuevoThead);
    }
  }
</script>