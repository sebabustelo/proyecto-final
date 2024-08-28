<?php

namespace App\View\Helper;

use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\I18n\DateTime;
use Cake\View\View;

class DiticHtmlHelper extends Helper
{
    public $name       = 'DiticHtml';
    public $components = array('Session');
    public array $helpers    = ['Session', 'Paginator', 'Form', 'Text', 'Html'];

    /**
     * Name of the Model (for Pagination with OrderFilterComponent)
     *
     * @var string
     * @access public
     * @default Singularized Controller name
     */
    public $modelName = null;
    /**
     * Name of the Controller (for Pagination with OrderFilterComponent)
     *
     * @var string
     * @access public
     * @default Controller name
     */
    public $controllerName = null;
    /**
     * Id of the element to show/hide while AJAX loading
     *
     * @var string
     * @access public
     * @default '#ajax-loading'
     */
    public $ajaxDiv = '#ajax-loading';
    /**
     * Filters to be added
     *
     * @var array
     * @access public
     */
    public $filters = array();

    /**
     * Pointer to the View Object (to show elements, etc)
     *
     * @var object
     * @access public
     */
    public $view = null;

    /**
     * Initializes TableHelper  for use in the view
     *
     * @return void
     * @access public
     */
    public function initialize(array $config): void
    {
        if (!$this->modelName) {
            //$this->modelName = Inflector::singularize($this->_View->getRequest()->getParam('controller'));
            $this->modelName = $this->_View->getRequest()->getParam('controller');
            $this->controllerName = $this->_View->getRequest()->getParam('controller');
        }
    }

    /**
     * Adds filters to the next call of showFilter().
     * It should be called like a it was a Form->input()
     *
     * @param string $fieldName The field name
     * @param array $options Additional options
     * @return void
     * @access public
     */
    function addFilter($fieldName, $options = array())
    {
        $this->filters[] = array('type' => 'form', 'fieldName' => $fieldName, 'options' => $options);
    }
    /**
     * Adds a filter to the next call of showFilter().
     * It must be used when the input creator is inside an element
     *
     * @param string $element The Element location (relative to views/elements/)
     * @param array $options Additional options and passed vars
     * @return void
     * @access public
     */
    function addFilterElement($element, $options = array())
    {
        $this->filters[] = array('type' => 'element', 'element' => $element, 'options' => $options);
    }
    /**
     * Creates a Filter inside a div with ajax submit and non-ajax clear.
     * Note: use addFilter() before this
     * Requires 2 Elements:
     * /views/elements/general/filter_error.ctp
     * /views/elements/CONTROLLER_NAME/list.ctp
     *
     * @param string $url Url of the clearFilter function
     * @param array $texts Text for the buttons
     * @param string $redirect Additional param of clearFilter to redirect
     * @return Auto echoes the HTML code of the Filter
     * @access public
     */

    function showFilter(
        $type = null,
        $url = 'index',
        $texts = array('filter' => 'Buscar', 'clear' => 'Limpiar'),
        $redirect = '',

    ) {
        if (!empty($this->filters)) { ?>
            <!--div class="filter-box clearfix" -->

            <?php
            if ((!isset($type))) {
                $type = 'GET';
            } else {
                $type = $type;
            }
            // debug($type);die;
            // debug(  $this->modelName  . 'Filter');die;
            echo $this->Form->create(
                null,
                array(
                    'class'    => 'form abox',
                    'id'    => 'formOrderFilter',
                    'type' => $type,
                    'url'    => array(
                        'controller' => $this->controllerName,
                        'action'    => $url,
                        $redirect
                    )
                )
            );
            ?>
            <div class="form-row">
                <?php
                $col_with = intdiv(12, count($this->filters));

                foreach ($this->filters as $filter) {
                    switch ($filter['type']) {

                        case 'element':
                            echo $this->_View->element(
                                $filter['element'],
                                $filter['options']
                            );
                            break;
                        case 'form':
                            //debug($filter);
                            echo $this->Form->control(
                                $filter['fieldName'],
                                $filter['options']
                            );
                            break;
                    }
                }
                ?>
            </div>
            <div class=" form-row">
                <div class='form-group col-md-12 text-center '>
                    <?php if (isset($texts['clear'])) { ?>
                        <button type="button" id="limpiar" class="btn btn-default">
                            <span class="glyphicon glyphicon-trash"></span>
                            Limpiar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php } ?>
                    <button type="submit" id="enviar" class="btn btn-primary">
                        <span class="glyphicon glyphicon-search"></span>
                        Buscar</button>

                    <!--div class="form-group col-md-4"!-->
                    <!--a href="#" id="limpiar" class="btn btn-default" title=""><span class="glyphicon glyphicon-trash"></span> Limpiar</a!-->
                    <?php
                    /*
                                    echo $this->Button(
                                        '<span class="fa fa-search"></span>&nbsp;' . $texts['filter'],
                                        array(
                                            'div'    => false,
                                            'url'    =>  $_SERVER['REQUEST_URI'],
                                            'class'    => 'btn btn-primary',
                                            'id' => 'enviar',

                                            'escapeTitle' => false,
                                        )
                                    );*/
                    ?>
                    <script>
                        $(function() {
                            $('#limpiar').on('click', function() {
                                $('#formOrderFilter').find('input:text, input:password, select, textarea').val('');
                                $('#formOrderFilter').find('input:radio, input:checkbox:not(#activo)').prop('checked', false);
                                document.getElementById("activo").checked = true;

                                $('#formOrderFilter').submit();

                                return false;
                            });
                        });
                    </script>
                    <div id="filterErrors">
                        <?php //echo $this->_View->element('general/filter_error'); 
                        ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        <?php
            // $this->filters = array();
        }
    }

    /**
     * Creates a Form with HtmlHelper that will submit through AJAX
     *
     * @param string $title Title of the Form
     * @param array $options Additional options (see HtmlHelper $options)
     * @return Form html code
     * @access public
     * @see HtmlHelper
     */
    function create($title, $options)
    {
        if ($options == null) {
            $options = array();
        } else {
            if (isset($options['url'])) {
                $url = $options['url'];
            } else {
                $url =  $this->request->getRequestTarget();
            }
        }

        $options = array_merge(
            $options,
            array(
                'onsubmit' => "jQuery.post('" . $url . "',
                jQuery(this).serialize(),
                function(data){
                    jQuery('#" . $this->controllerName . "List').html(data);
                    jQuery('" . $this->ajaxDiv . "').hide();
                }
                );" .
                    "jQuery('" . $this->ajaxDiv . "').show();" .
                    "return false;"
            )
        );
        return $this->Form->create();
    }

    /**
     * Creates a Form Submit button with HtmlHelper that will submit through AJAX
     *
     * @param string $title Title of the Button
     * @param array $options Additional options (see HtmlHelper $options)
     * @return Button html code
     * @access public
     * @see HtmlHelper
     */
    function Submit($title, $options = array())
    {
        $moreOptions = '';
        if ($options == null) {
            $options = array();
        } else {
            if (isset($options['onclick'])) {
                $moreOptions = $options['onclick'];
            }
            if (isset($options['url'])) {
                $url = $options['url'];
            } else {
                $url = $this->_View->getRequest()->getRequestTarget();
            }
        }
        //debug($options);


        $options = array_merge(
            $options,
            array(
                'onclick' =>     $moreOptions . ';' .
                    "jQuery.post('" . $url . "',
			jQuery(this).parents('form:first').serialize(),
			function(data){
				jQuery('#" . $this->modelName . "List').html(data);
				jQuery('" . $this->ajaxDiv . "').hide();
			}
			);" .
                    "jQuery('" . $this->ajaxDiv . "').show();" .
                    "return false;"
            )
        );

        return $this->Form->Submit($title, $options);
    }

    /**
     * Creates a Form Button with type submit with HtmlHelper that will submit through AJAX
     *
     * @param string $title Title of the Button
     * @param array $options Additional options (see HtmlHelper $options)
     * @return Button html code
     * @access public
     * @see HtmlHelper
     */
    function Button($title, $options = array())
    {
        $moreOptions = '';
        if ($options == null) {
            $options = array();
        } else {
            if (isset($options['onclick'])) {
                $moreOptions = $options['onclick'];
            }

            if (isset($options['url'])) {
                $url = $options['url'];
            } else {
                $url = $this->getRequestTarget;
            }
        }

        $options = array_merge(
            $options,
            array(
                'onclick' =>     $moreOptions .
                    "jQuery.post('" . $url . "',
                    jQuery(this).parents('form:first').serialize(),
                    function(data){
                        
                        jQuery('.content').html(data);
                        jQuery('" . $this->ajaxDiv . "').hide();
                    }
                    );" .
                    "jQuery('" . $this->ajaxDiv . "').show();" .
                    "return false;"
            )
        );
        return $this->Form->Button($title, $options);
    }

    public function autocomplete($nombre, $valor, $id, $url, $placeholder = null, $destino1 = null, $destino2 = null, $opciones = null)
    {
        $perfilDefault                 = $this->getView()->getRequest()->getSession()->read('PerfilDefault');
        $accionesPermitidasPorPerfiles = $this->getView()->getRequest()->getSession()->read('RbacAcciones');
        $accionesPermitidas            = $accionesPermitidasPorPerfiles[$perfilDefault];
        $output                        = '';
        if (isset($nombre) && isset($id)) {
            $output = '<input type="text" name="' . $nombre . '" id="' . $id . '" value="' . $valor . '" class="form-control ui-autocomplete-input" placeholder="' . $placeholder . '"/>';
            if ($id) {
                $output .= '<script type="text/javascript">
                $("#' . $id . '").autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "' . $url . '",
                            type: "POST",
                            dataType: "json",
                            data: {' . $nombre . ': request.term},
                            success: function (data) {
                                response($.map(data, function(item) {
                                    return {
                                        label: item.label,
                                        value: item.value
                                    };
                                }));
                            }
                        });
                    },
                    minLength: 1,';
                if (isset($destino1)) {
                    $output .= '
                        select: function(event, ui) {
                            $("#' . $destino1 . ').val(ui.item.label.split(",")[1].trim().split(" ")[0].trim());';
                    if (isset($destino2)) {
                        $output .= '$("#' . $destino2 . ').val(ui.item.label.split(",")[0].trim());';
                    }
                    $output .= '};';
                }
                $output .= '});
                    </script>';
            } else {
                $output = '<script type="text/javascript">$("#' . $id . ').autocomplete("destroy");</script>';
            }
            $this->p($output);
        }
    }

    /**
     * Creates an AJAX link
     *
     * @param string $title Text of the link (see HtmlHelper $title)
     * @param string $href Url to go (see HtmlHelper $href)
     * @param array $options Additional options (see HtmlHelper $options)
     * @param string $confirm String to trigger a Javascript confirm() function (see HtmlHelper $confirm)
     * @return Link html code
     * @access public
     * @see HtmlHelper
     */
    function link($title, $href, $options = array(), $confirm = null)
    {
        if ($options == null) {
            $options = array();
        }

        if ($confirm != null) {
            $options['confirm'] = $confirm;
        }

        return $this->Html->link($title, $href, $options);
    }



    public function wysiwyg($fieldName, $valor, $id, $options)
    {
        $perfilDefault                 = $this->getView()->getRequest()->getSession()->read('PerfilDefault');
        $accionesPermitidasPorPerfiles = $this->getView()->getRequest()->getSession()->read('RbacAcciones');
        $accionesPermitidas            = $accionesPermitidasPorPerfiles[$perfilDefault];
        $output                        = '';
        if ($fieldName) {
            if (!isset($id)) {
                $id = 'wysiwyg';
            }
            $output .= '<div class="' . $id . '">';
            if (isset($options['botones'])) {
                $botones = $options['botones'];
                //if (count($botones)>0) {
                foreach ($botones as $boton) {
                    if ($boton === 'negrita') {
                        $output .= '<a class="btn btn-default" id="negrita"></a>';
                    }
                    if ($boton === 'italica') {
                        $output .= '<a class="btn btn-default" id="italica"></a>';
                    }
                    if ($boton === 'subrayada') {
                        $output .= '<a class="btn btn-default" id="subrayada"></a>';
                    }
                    if ($boton === 'izquierda') {
                        $output .= '<a class="btn btn-default" id="izquierda"></a>';
                    }
                    if ($boton === 'centro') {
                        $output .= '<a class="btn btn-default" id="centro"></a>';
                    }
                    if ($boton === 'derecha') {
                        $output .= '<a class="btn btn-default" id="derecha"></a>';
                    }
                    if ($boton === 'lista') {
                        $output .= '<a class="btn btn-default" id="lista"></a>';
                    }
                    if ($boton === 'listaizquierda') {
                        $output .= '<a class="btn btn-default" id="listaizquierda"></a>';
                    }
                    if ($boton === 'listaderecha') {
                        $output .= '<a class="btn btn-default" id="listaderecha"></a>';
                    }
                    if ($boton === 'aumentar') {
                        $output .= '<a class="btn btn-default" id="aumentar"></a>';
                    }
                    if ($boton === 'achicar') {
                        $output .= '<a class="btn btn-default" id="achicar"></a>';
                    }
                    if ($boton === 'imagen') {
                        $output .= '<a class="btn btn-default" id="imagen"></a>';
                    }
                    if ($boton === 'html') {
                        $output .= '<a class="btn btn-default" id="html"></a>';
                    }
                    if ($boton === 'linea') {
                        $output .= '<a class="btn btn-default" id="linea"></a>';
                    }
                }
                //}
            }

            $output .= '<textarea name="' . $fieldName . '" style="height:600px;" class="form-control" id="' . $id . '" ';
            if (isset($options['cols'])) {
                $output .= 'cols="' . $options['cols'] . '" ';
            }

            if (isset($options['rows'])) {
                $output .= 'rows="' . $options['rows'] . '" ';
            }

            if (isset($options['modo'])) {
                if ($options['modo'] == 'sololectura') {
                    $output .= 'readonly ';
                }

                if ($options['modo'] == 'desactivado') {
                    $output .= 'disabled ';
                }

                if ($options['modo'] == 'oculto') {
                    $output .= 'hidden ';
                }
            }
            $output .= '>';
            if (!empty($valor)) {
                $output .= $valor;
            }

            $output .= '</textarea></div>';

            $output .= "
            <script type='text/javascript'>
                $(function () {

                    $('textarea#{$id}').htmlarea({});";
            if (isset($options['altura'])) {
                $output .= "$('.{$id} iframe').height('" . $options['altura'] . "px');";
            }

            if (isset($options['ancho'])) {
                $output .= "$('.{$id} iframe').width('" . $options['ancho'] . "px');";
            }

            $output .= "
                    $('.{$id} iframe').contents().find('body')
                    .css('font-family','Helvetica')
                    .css('color','#333333')
                    .css('font-size','14px')
                    .css('width','98%')
                    .css('overflow-x','none');
                    $('div.{$id} a#html ,button#html').click(function() {
                        $('#{$id}').htmlarea('toggleHTMLView');
                    });
                    $('div.{$id} a#negrita,button#negrita').click(function() {
                        $('#{$id}').htmlarea('bold');
                    });
                    $('div.{$id} a#italica,button#italica').click(function() {
                        $('#{$id}').htmlarea('italic');
                    });
                    $('div.{$id} a#subrayada,button#subrayada').click(function() {
                        $('#{$id}').htmlarea('underline');
                    });
                    $('div.{$id} a#izquierda,button#izquierda').click(function() {
                        $('#{$id}').htmlarea('justifyLeft');
                    });
                    $('div.{$id} a#centro, button#centro').click(function() {
                        $('#{$id}').htmlarea('justifyCenter');
                    });
                    $('div.{$id} a#derecha, button#derecha').click(function() {
                        $('#{$id}').htmlarea('justifyRight');
                    });
                    $('div.{$id} a#lista,button#lista').click(function() {
                        $('#{$id}').htmlarea('unorderedList');
                    });
                    $('div.{$id} a#listaizquierda,button#listaizquierda').click(function() {
                        $('#{$id}').htmlarea('outdent');
                    });
                    $('div.{$id} a#listaderecha,button#listaderecha').click(function() {
                        $('#{$id}').htmlarea('indent');
                    });
                    $('div.{$id} a#aumentar,button#aumentar').click(function() {
                        $('#{$id}').htmlarea('increaseFontSize');
                    });
                    $('div.{$id} a#achicar,button#achicar').click(function() {
                        $('#{$id}').htmlarea('decreaseFontSize');
                    });
                    $('div.{$id} a#imagen,button#imagen').click(function() {
                        $('#{$id}').htmlarea('image');
                    });
                    $('div.{$id} a#linea,button#linea').click(function() {
                        $('#{$id}').htmlarea('insertHorizontalRule');
                    });
                    $('#{$id}').htmlarea('updateHtmlArea', $('{$id}').val());
                });
            </script>
            ";
            print $output . chr(10);
        }
    }

    /**
     * Creates link to sort through AJAX
     *
     * @param string $title Text of the link (see PaginatorHelper $title)
     * @param string $field Field to order by (see PaginatorHelper $field)
     * @param array $options Additional options (see PaginatorHelper $options)
     * @return Sort link html code
     * @access public
     * @see PaginatorHelper
     */
    function sort($title, $field)
    {

        $view = new View();
        //debug( $view->getRequest());
        $sort = $view->getRequest()->getQuery('sort');
        $direction = $view->getRequest()->getQuery('direction');
        // debug($sort);die;

        // $field_sort = explode('.', $sort);

        // if (isset($this->request->params['paging'][$this->modelName]['options']['order'][$field])) {
        //     $options['class'] = (isset($options['class']) ? $options['class'] : '') . ' current-order';
        // }


        //debug($title);
        //debug($field);
        // die;

        return $this->Paginator->sort($title, $field);
    }

    /**
     * Generates a report table from the $items showing the $rows
     *
     * Accepted values for $rows:
     * array (
     * 		'field',						// Simplest, shows the field value
     * 		'field'	=> $options,		// Field with array of options (see below)
     * 		'action',							// Link to controller/action/ID with image
     * 		'action' 		=> 'Really?',		// Same but with JavaScript Confirm
     * 		'action'		=> array (			// Same but overrides class
     * 			'confirm'	=> 'Really?',
     * 			'class'		=> 'diff_class'
     * )
     *
     * Accepted values for $options:
     * If $options is a string, it will be processed as the only option of an array
     * array (
     *  	'class'			=> 'someClass',		// Class for each td
     *  	'th-class'		=> 'someClass',		// Class for the th
     *      'sort' => true|false               // For Default is false
     *      'type' => number|date|time|datetime|button
     *           	'number' => Will be aligned to the right
     *  	        'date' => Will be aligned to the right and formated to FORMAT_DATE_VIEW
     *   	        'time' => Will be aligned to the right and formated to FORMAT_TIME_VIEW
     *    	        'datetime' => Will be aligned to the right and formated to FORMAT_DATETIME_VIEW
     *              'button' => ['action'=>'url',params=> [] ]
     * 
     *  	'title'			=> 'Diff Title',	// Changes the Row Title (default is humanized field)
     *  	'edit',								// Will make a link to controller/edit/ID
     *  	'edit-action'						// Will edit the action
     *  	'edit-controller					// Will edit the controller
     *  	'admin'								// Specify if the prefix admin should be used or not
     *  	'detail'							// Will make a link to controller/detail/ID
     *  	'truncate',							// Will truncate to the first
     *  											// LIMIT_CHARACTERS_IN_DESCRIPTION_FIELDS characters
     *  	'truncate-length'	=> number			// or number if it's passed
     *  	'truncate-options'	=> $array			// Options for 'truncate'
     *  	'index-from'	=> $array,			// Will echo $array[$value]
     *  	'function'		=> 'someFunction',	// Will echo someFunction($value)
     *  	'sanitize'							// Will echo Sanitize::html($value);
     *  	'sanitize-function'	=> 'function'		// Will call Sanitize::function instead
     *  	'sanitize-options'	=> $array			// Options for 'sanitize'
     *  	'change-status',					// Will show an image with a link
     *      'yes/no',					        // Will show an icon with image yes or no
     *  											// to controller/changeStatus/ID
     *  	'change-status-action',				// Use different action for change-status     
     *  	'thumbnail',						// Show image (path should be relative to webroot)
     *  											// Thumbnailized to width="80"
     * )
     *
     * 'function', 'truncate' and 'sanitize' are called after all others (in this order),
     * so you can mix them
     *
     * @param array $items Data (like from a $model->find('all')) to show
     * @param array $rows List of the rows and options to show
     * @param array $options Extra options
     * @return Auto echo the HTML code
     * @access public
     */
    function generateTable($items, $rows, $options = array())
    {
        $processedRows = array();

        foreach ($rows as $key => $row) {

            //The field can I have nested models
            $fieldModel = explode('.', $key);

            $model = isset($fieldModel[1]) ? $fieldModel[0] : $this->modelName;
            $subModel = isset($fieldModel[2]) ? $fieldModel[1] : '';
            $field = isset($fieldModel[1]) ? $fieldModel[1] : $fieldModel[0];

            $type = isset($row['type']) ? $row['type'] : 'text';

            $defaults = array(
                'model' => $model,
                'subModel'    => $subModel,
                'field'    => $field,
                'type' => $type

            );

            $processedRows[] = array_merge(
                $defaults,
                $row
            );
            //debug($processedRows);

        }

        // debug($processedRows);die;
        ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-ajax">
                <thead>
                    <tr>
                        <?php
                        foreach ($processedRows as $row) {
                            $title = isset($row['title']) ? $row['title'] : Inflector::humanize($row['field']);

                            // debug($row);die;
                        ?>
                            <th <?php
                                if (isset($row['class'])) {
                                    echo 'class="' . $row['class'] . '"';
                                }
                                ?>>
                                <?php

                                if (!$row['sort']) {
                                    echo $title;
                                } else {
                                    //  debug($row);
                                    if (isset($row['subModel'])) {
                                        $field2 =  $row['field'] . "." . $row['subModel'];
                                        debug($field2);
                                        debug($title);
                                        //TODO BUG arreglar orden de paginacion para columnas relacionadas 
                                        echo $this->Paginator->sort($field2, $title, array('Model' => 'DocumentoTipos', 'direction' => 'desc'));
                                        //echo $this->Paginator->sort($field2, $title);
                                        //echo $this->Paginator->sort('documento_tipos.descripcion', 'documento_tipo.descripcion', ['escape' => true]);
                                        // echo $title;
                                        // // Generar el enlace con dirección de ordenamiento 'asc'
                                        // echo $this->Html->link(
                                        //     '>',
                                        //     [
                                        //         'controller' => 'Resoluciones',                                                
                                        //         'action' => 'index',
                                        //         '?' => [
                                        //             'sort' => 'documento_tipo.descripcion', // Campo para ordenar
                                        //             'direction' => 'asc' // Dirección de ordenamiento 'asc'
                                        //         ]
                                        //     ]
                                        // );
                                        // echo $this->Html->link(
                                        //     '<',
                                        //     [
                                        //         'controller' => 'Resoluciones',                                                
                                        //         'action' => 'index',
                                        //         '?' => [
                                        //             'sort' => 'documento_tipo.descripcion', // Campo para ordenar
                                        //             'direction' => 'desc' // Dirección de ordenamiento 'asc'
                                        //         ]
                                        //     ]
                                        // );
                                    } else {
                                        //echo $this->Paginator->sort($row['field'], $title);
                                        //$type = $this->Paginator->sortDir() === 'asc' ? 'up' : 'down';
                                        // debug($this->Paginator->sortDir());
                                        $icon = "<i class='icon-arrow-asc'></i>" . $title;
                                        echo $this->Paginator->sort($row['field'], $title, array('escape' => false));
                                    }
                                }
                                ?>
                            </th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($items as $key => $unit) { ?>
                        <tr class="
                            <?php if (isset($options['tr-class'])) {
                                echo ' ' . $options['tr-class']($unit) . ' ';
                            }
                            if (isset($unit['status']) && !$unit['status']) {

                                echo ' disabled ';
                            }

                            ?>
		                ">
                            <?php

                            foreach ($processedRows as $row) { ?>
                                <td <?php

                                    if (
                                        in_array('number', $row)
                                        || in_array('date', $row)
                                        || in_array('time', $row)
                                        || in_array('datetime', $row)
                                    ) {

                                        echo 'align="right"';
                                    } elseif (
                                        in_array('change-status', $row)
                                        || isset($row['action'])
                                        || in_array('show-status', $row)
                                        || in_array('centered', $row)
                                    ) {

                                        echo 'align="center"';
                                    }
                                    // if (isset($row['class'])) {

                                    //     echo 'class="' . $row['class'] . '"';
                                    // }
                                    ?>>
                                    <?php
                                    //       if ($row['model'] == $this->modelName) {
                                    //debug($unit);
                                    // debug($unit[$row['model']]);
                                    // debug($row);
                                    if (!is_object($unit[$row['model']]) && !is_array($unit[$row['model']])) {
                                        $field =  strval($unit->{$row['field']});
                                        debug("1");
                                    } elseif (is_object($unit[$row['model']])) {
                                        // die;
                                        if ((isset($row['model'])) && isset($unit->{$row['model']}->{$row['field']})) {
                                            $field = $unit->{$row['model']}->{$row['field']};
                                        }
                                        foreach ($unit[$row['model']] as $k => $v) {
                                            if (!empty($field)) {
                                                $field =    $field . "<br>" . $v[$subModel];
                                            } else {
                                                $field =    $v[$subModel];
                                            }
                                        }

                                        // debug("2");
                                    } elseif (is_array($unit[$row['field']])) {
                                        $field = '';
                                        foreach ($unit[$row['field']] as $k => $v) {
                                            if (!empty($field)) {
                                                $field =    $field . "<br>" . $v[$subModel];
                                            } else {
                                                $field =    $v[$subModel];
                                            }
                                        }

                                        // debug("3");
                                    }

                                    $content = $field;

                                    if (isset($row['show-if'])) {
                                        if (!($row['show-if']($unit))) {
                                            $row = array('empty');
                                        }
                                    }
                                    if (in_array('empty', $row)) {
                                        $content = '';
                                    } elseif (in_array('datetime', $row)) {
                                        if ($unit[$row['model']][$row['field']]) {

                                            $date = new DateTime($unit[$row['model']][$row['field']], new \DateTimeZone('America/Argentina/Buenos_Aires'));
                                            $content = $date->format(FORMAT_DATETIME_VIEW);
                                        }
                                    } elseif (in_array('date', $row)) {

                                        $date = new DateTime($unit->{$row['field']});

                                        $content = $date->format(FORMAT_DATE_VIEW);
                                    } elseif (in_array('time', $row)) {
                                        if ($unit[$row['field']]) {
                                            $content = $this->Time->format(
                                                FORMAT_TIME_VIEW,
                                                $unit[$row['field']]
                                            );
                                        }
                                    } elseif (in_array('show-status', $row)) {
                                        $status = 'glyphicon-remove';
                                        if ($unit[$row['field']]) {
                                            $status = 'glyphicon-ok';
                                            if (isset($row['tooltip-on'])) {
                                                $row['tooltip'] = $row['tooltip-on'];
                                            }
                                        } else {
                                            if (isset($row['tooltip-off'])) {
                                                $row['tooltip'] = $row['tooltip-off'];
                                            }
                                        }
                                        if (isset($row['tooltip'])) {
                                            $title = $row['tooltip'];
                                        } else {
                                            $title = "";
                                        }
                                        //$content = $this->view->Html->link(
                                        $content = $this->Html->link(
                                            '',
                                            'javascript:void(0);',
                                            array(
                                                'class'        =>    'glyphicon ' . $status,
                                                'title'        => $title,
                                                'style'        => 'cursor: default;color:black;'
                                            )
                                        );
                                    } elseif (in_array('change-status', $row)) {
                                        $status = 'No';

                                        if ($field) {
                                            $status = 'Si';
                                            if (isset($row['tooltip-on'])) {
                                                $row['tooltip'] = $row['tooltip-on'];
                                            }
                                        } else {
                                            if (isset($row['tooltip-off'])) {
                                                $row['tooltip'] = $row['tooltip-off'];
                                            }
                                        }
                                        $action = 'changeStatus';
                                        if (isset($row['change-status-action'])) {
                                            $action = $row['change-status-action'];
                                        }
                                        if (isset($row['tooltip'])) {
                                            $title = $row['tooltip'];
                                        } else {
                                            $title = Inflector::humanize($action);
                                        }
                                        $extraParam = '';
                                        if (isset($row['extra-param'])) {
                                            $extraParam = $row['extra-param'];
                                        }
                                        // debug( $row);die;
                                        $content = $this->link(
                                            "$status",
                                            array(
                                                'controller' => $this->controllerName,
                                                'action'    => $action
                                                    . '/' . $unit['id'],
                                                $extraParam
                                            ),
                                            array(
                                                'class'        =>    'btn-sm btn-primary ',
                                                'title'        => $title
                                            )
                                        );
                                    } elseif (isset($row['update-text'])) {
                                        $content = $this->Form->input(
                                            $row['model'] . '.'
                                                . $row['field'],
                                            array(
                                                'label'        => false,
                                                'value'        => $unit[$row['model']][$row['field']],
                                                'imageId'    => $unit[$row['model']]['id'],
                                                'class'        => 'update-text'
                                            )
                                        );
                                    } elseif (isset($row['input'])) {
                                        $content = $this->Form->input(
                                            $row['input']['model'] . '.'
                                                . $unit['ContentsFile']['id'] . '.'
                                                . $row['input']['name'],
                                            array(
                                                'label'    => false,
                                                'value'    => $unit['ContentsFile'][$row['input']['name']]
                                            )
                                        );
                                    } elseif (isset($row['action'])) {
                                        // debug(in_array('edit', $row));
                                        // debug($row);
                                        //  die("action");
                                        if (in_array('no-ajax', $row)) {
                                            $html = &$this->view->Html;
                                        } else {
                                            $html = &$this;
                                        }
                                        if (isset($row['target'])) {
                                            $target = $row['target'];
                                        } else {
                                            $target = '_self';
                                        }
                                        if (isset($row['tooltip'])) {
                                            $title = $row['tooltip'];
                                        } else {
                                            if (isset($row['text'])) {
                                                $title = '';
                                            } else {
                                                $title = Inflector::humanize($row['class']);
                                            }
                                        }
                                        $class = '';
                                        if (isset($row['text'])) {
                                            $text = $row['text'];
                                            $class = $row['class'];
                                        } else {
                                            $text = '';
                                            // debug($row);die;
                                            if ($row['action'] == 'edit' || $row['action'] == 'editar') {
                                                $class = 'editar btn btn-success btn-xs ' . $row['class'];
                                            } elseif ($row['action'] == 'delete' or $row['action'] == 'eliminar') {
                                                $class = 'editar btn btn-danger btn-xs ' . $row['class'];
                                            } elseif ($row['action'] == 'view' or $row['action'] == 'ver') {
                                                $class = 'editar btn btn-info btn-xs ' . $row['class'];
                                            } elseif ($row['action'] == 'download' or $row['action'] == 'descargarArchivo' or $row['action'] == 'descargarArchivoPublico') {
                                                $class = 'editar btn btn-default btn-xs ' . $row['class'];
                                            }
                                        }
                                        $extraParam = '';
                                        if (isset($row['extra-param'])) {
                                            $extraParam = $row['extra-param'];
                                        }
                                        //Si se quiere agreagar una accion distinta a la predifinidas  ['delete', 'remove', 'eliminar']
                                        // se lo pone en la etiqueta edit-action o delete-action segun corresponda
                                        if (isset($row['edit-action'])) {
                                            $action = $row['edit-action'];
                                        } elseif (isset($row['delete-action'])) {
                                            $action = $row['delete-action'];
                                        } else {
                                            $action = $row['action'];
                                        }
                                        //debug($_SESSION['vh']);
                                        if (isset($_SESSION['permitidas'][Inflector::underscore($this->controllerName)])) {

                                            $accionesPermitidas = $_SESSION['permitidas'][Inflector::underscore($this->controllerName)];
                                            $actions = ['delete', 'remove', 'eliminar'];
                                            if (
                                                in_array($action, $actions) && isset($accionesPermitidas[$action][$_SESSION['virtualHost']]) &&
                                                ($accionesPermitidas[$action][$_SESSION['virtualHost']])
                                            ) {
                                                if (
                                                    (!isset($row['conditions']) or
                                                        (isset($row['conditions'])
                                                            && (count($unit[$row['conditions']]) == 0))
                                                    )
                                                    && isset($accionesPermitidas[$action][$_SESSION['virtualHost']]) && ($accionesPermitidas[$action][$_SESSION['virtualHost']])
                                                ) {
                                                    // debug($unit);
                                                    if (!isset($unit['deleted'])) {
                                                        $content = $this->Form->postLink(
                                                            '<span class="glyphicon glyphicon-' . $row['class'] . '"></span>',
                                                            [
                                                                'action'    => $action,
                                                                $unit[$row['field']],
                                                                $extraParam
                                                            ],
                                                            [
                                                                'confirm' => "¿Está seguro de eliminar?",
                                                                'class'        => $class,
                                                                'title'        => $title,
                                                                'target'    => $target,
                                                                'escape' => false
                                                            ],
                                                        );
                                                    } else {
                                                        $class = 'recuperar btn btn-warning btn-xs glyphicon glyphicon-refresh';
                                                        $content = $this->Form->postLink(
                                                            '<span "></span>',
                                                            [
                                                                'action'    => "/recover",
                                                                $unit[$row['field']],
                                                                $extraParam
                                                            ],
                                                            [
                                                                'confirm' => "¿Está seguro seguro de a recuperar el area?",
                                                                'class'        => $class,
                                                                'title'        => "Recuperar",
                                                                'target'    => $target,
                                                                'escape' => false
                                                            ],
                                                        );
                                                    }
                                                } else {
                                                    $content = '<a href="javascript:void(0)" class=" btn btn-default btn-xs " title="tiene datos asociados" target="_self"><span class="glyphicon glyphicon-minus"></span></a>';
                                                }
                                            } else {

                                                if (
                                                    (!isset($row['conditions']) or
                                                        (
                                                            (isset($row['conditions'])
                                                                && (count($unit[$row['conditions']]) == 0)
                                                            )
                                                        ))
                                                    // && isset($accionesPermitidas[$action][$_SESSION['virtualHost']]) 
                                                    // && ($accionesPermitidas[$action][$_SESSION['virtualHost']])
                                                ) {
                                                    // debug($unit);
                                                    // debug($row);

                                                    if ($action == 'descargarArchivo' or $action == 'descargarArchivoPublico') {
                                                        if (isset($unit['upload_id']) and (!empty($unit['upload_id']))) {
                                                            $content = $this->link(
                                                                '<span class="glyphicon glyphicon-' . $row['class'] . '"></span>',
                                                                array(
                                                                    'controller' => $this->controllerName,
                                                                    'action'    => $action
                                                                        . '/' . $unit->upload->nombre_archivo,
                                                                    $extraParam
                                                                ),
                                                                array(
                                                                    'class'        => $class,
                                                                    'title'        => $title,
                                                                    'target'    => $target,
                                                                    'escape' => false
                                                                ),
                                                                $row['confirm']
                                                            );
                                                        } else {
                                                            $content =
                                                                '<a href="#" class="editar btn btn-default btn-xs download" title="Sin Documento" target="_self"><span class="glyphicon glyphicon-minus"></span></a>';
                                                        }
                                                    } else {
                                                        $content = $this->link(
                                                            '<span class="glyphicon glyphicon-' . $row['class'] . '"></span>',
                                                            array(
                                                                'controller' => $this->controllerName,
                                                                'action'    => $action
                                                                    . '/' . $unit[$row['field']],
                                                                $extraParam
                                                            ),
                                                            array(
                                                                'class'        => $class,
                                                                'title'        => $title,
                                                                'target'    => $target,
                                                                'escape' => false
                                                            ),
                                                            $row['confirm']
                                                        );
                                                    }
                                                } else {
                                                    //debug($row);
                                                    # code...
                                                    if (isset($accionesPermitidas[$action][$_SESSION['virtualHost']]) && ($accionesPermitidas[$action][$_SESSION['virtualHost']])) {
                                                        $content = '<a href="javascript:void(0)" class="editar btn btn-warning btn-xs " title="tiene resoluciones asociadas" target="_self"><span class="glyphicon glyphicon-minus"></span></a>';
                                                    } else {
                                                        $content = "dd";
                                                    }
                                                    if ($row['html']) {
                                                        $content = $row['html'];
                                                    }
                                                }
                                            }
                                        } else {
                                            debug($unit);
                                            debug($row);
                                            debug($action);
                                            if (
                                                (!isset($row['conditions']) or
                                                    (
                                                        (isset($row['conditions'])
                                                            && (count($unit[$row['conditions']]) == 0)
                                                        )
                                                    ))
                                                // && isset($accionesPermitidas[$action][$_SESSION['virtualHost']]) 
                                                // && ($accionesPermitidas[$action][$_SESSION['virtualHost']])
                                            ) {

                                                if ($action == 'descargarArchivo' or $action == 'descargarArchivoPublico') {

                                                    if (isset($unit['upload_id']) and (!empty($unit['upload_id']))) {
                                                        $content = $this->link(
                                                            '<span class="glyphicon glyphicon-' . $row['class'] . '"></span>',
                                                            array(
                                                                'controller' => $this->controllerName,
                                                                'action'    => $action
                                                                    . '/' . $unit['upload_id'],
                                                                $extraParam
                                                            ),
                                                            array(
                                                                'class'        => $class,
                                                                'title'        => $title,
                                                                'target'    => $target,
                                                                'escape' => false
                                                            ),
                                                            $row['confirm']
                                                        );
                                                    } else {
                                                        $content =
                                                            '<a href="#" class="editar btn btn-default btn-xs download" title="Sin Documento" target="_self"><span class="glyphicon glyphicon-minus"></span></a>';
                                                    }
                                                } else {
                                                    $content = $this->link(
                                                        '<span class="glyphicon glyphicon-' . $row['class'] . '"></span>',
                                                        array(
                                                            'controller' => $this->controllerName,
                                                            'action'    => $action
                                                                . '/' . $unit[$row['field']],
                                                            $extraParam
                                                        ),
                                                        array(
                                                            'class'        => $class,
                                                            'title'        => $title,
                                                            'target'    => $target,
                                                            'escape' => false
                                                        ),
                                                        $row['confirm']
                                                    );
                                                }
                                            } else {
                                                //debug($row);
                                                # code...
                                                if (isset($accionesPermitidas[$action][$_SESSION['virtualHost']]) && ($accionesPermitidas[$action][$_SESSION['virtualHost']])) {
                                                    $content = '<a href="javascript:void(0)" class="editar btn btn-warning btn-xs " title="tiene resoluciones asociadas" target="_self"><span class="glyphicon glyphicon-minus"></span></a>';
                                                } else {
                                                    $content = "dd";
                                                }
                                                if ($row['html']) {
                                                    $content = $row['html'];
                                                }
                                            }
                                        }
                                    } elseif (in_array('edit', $row)) {
                                        //  die("edit");
                                        $action = 'edit';
                                        $controller = $this->controllerName;
                                        //debug($row);die;
                                        if (isset($row['edit-action'])) {
                                            $action = $row['edit-action'];
                                        }
                                        if (isset($row['edit-controller'])) {
                                            $controller = $row['edit-controller'];
                                        }

                                        $opt = array(
                                            'controller' => $controller,
                                            'action'    => $action
                                                . '/' . $unit['id']
                                        );

                                        if (isset($row['admin'])) {
                                            $opt['admin'] = $row['admin'];
                                        }

                                        if ($row['model'] == $this->modelName) {
                                            $u = $unit[$row['field']];
                                        } else {
                                            $m = Inflector::singularize(Inflector::underscore($row['model']));
                                            $u = $unit[$m][$row['field']];
                                        }
                                        // debug($row);
                                        // debug($unit);
                                        //debug($u);die;
                                        $content = $this->Html->link(
                                            "Editar",
                                            $opt,
                                            array(
                                                'escape'    => false
                                            )
                                        );
                                    } elseif (in_array('detail', $row)) {
                                        $content = $this->Html->link(
                                            'Dashboard',
                                            ['controller' => 'Dashboards', 'action' => 'index', '_full' => true]
                                        );
                                    } elseif (in_array('thumbnail', $row)) {
                                        $content = $this->Html->image(
                                            '../' . $unit[$row['model']][$row['field']],
                                            array(
                                                'width'        => 80
                                            )
                                        );
                                    } elseif (isset($row['html'])) {
                                        $content = $row['html'];
                                    } elseif (isset($row['index-from'])) {
                                        if (isset($row['index-from'][$unit[$row['model']][$row['field']]])) {
                                            $content = $row['index-from'][$unit[$row['model']][$row['field']]];
                                        } else {
                                            $content = '';
                                        }
                                    }
                                    //debug($row);
                                    if (isset($row['function'])) {
                                        if ($row['function'] == 'nl2br') {
                                            $content = call_user_func(
                                                $row['function'],
                                                $content
                                            );
                                        } else {
                                            $content = call_user_func(
                                                $row['function'],
                                                $content,
                                                $unit
                                            );
                                        }
                                    }

                                    if (in_array('truncate', $row)) {
                                        # $truncateLength = LIMIT_CHARACTERS_IN_DESCRIPTION_FIELDS;

                                        $truncateLength = 100;
                                        if (isset($row['truncate-length'])) {
                                            $truncateLength = $row['truncate-length'];
                                        }
                                        $truncateOptions = array(
                                            'exact'        => false,
                                            'ending'    => '...'
                                        );
                                        // debug($content);
                                        // if (isset($row['truncate-options'])) {
                                        //    $truncateOptions = $row['truncate-options'];
                                        // }

                                        if (!is_null($content)) {
                                            $content = $this->Text->truncate(
                                                $content,
                                                $truncateLength,
                                                $truncateOptions
                                            );
                                        }
                                    }


                                    echo $content;

                                    ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php }

                    ?>
                </tbody>
                <?php if (in_array('simulate-pagination', $options)) { ?>
                    <tfoot>
                        <tr>
                            <td colspan="<?php echo count($processedRows) ?>">
                                Página 1 de 1 | Total: <?php echo count($data); ?> registros
                            </td>
                        </tr>
                    </tfoot>
                <?php } elseif (!in_array('no-pagination', $options)) { ?>
                    <tfoot>
                        <tr>
                            <td colspan="<?php echo count($processedRows) ?>">

                                <?php //echo $this->_View->element('general/paginator'); 

                                /**
                                 * PAGINACION
                                 * ----------
                                 */

                                $pager_params = $this->Paginator->params();
                                // Change a template
                                $this->Paginator->setTemplates([
                                    'number' => '<li><a class="pag-ajax page-link" href="{{url}}">{{text}}</a></li>',
                                    'first' => '<li><a class="pag-ajax page-link" href="{{url}}">{{text}}</a></li>',
                                    'last' => '<li><a class="pag-ajax page-link" href="{{url}}">{{text}}</a></li>',
                                    'prevActive' => '<li><a class="pag-ajax page-link" href="{{url}}">{{text}}</a></li>',
                                    'nextActive' => '<li><a class="pag-ajax page-link" href="{{url}}">{{text}}</a></li>'
                                ]);
                                $output = '';
                                $output .= '<div class=" text-center">';
                                if ($pager_params['pageCount'] > 1) {
                                    $output .= '<ul class="pagination">';
                                    $output .= '<li>';
                                    $output .= $this->Paginator->first('PRIMERO');
                                    $output .= $this->Paginator->prev('ANTERIOR');
                                    $output .= '</li>';
                                    $output .= '<li>';
                                    $output .= $this->Paginator->numbers();
                                    $output .= '</li>';
                                    $output .= '<li>';
                                    $output .= $this->Paginator->next('SIGUIENTE');
                                    $output .= $this->Paginator->last('ULTIMO');
                                    $output .= '</li>';
                                    $output .= '</ul>';

                                    $total = "Página: " . $this->Paginator->counter('{{page}} de {{pages}}, mostrando {{current}} registros
                                     de {{count}}');
                                    $output .= '<div align="center">' . $total . '</div>';
                                    $output .= '</div>';
                                    $output .= '<div class="clear"><br /></div>';
                                }
                                // $output .= '<div id="divDialog" title="Basic dialog">

                                //</div>';
                                if (isset($div)) {
                                    $output .= $div;
                                }
                                if (!isset($options['response'])) {
                                    $options['response'] = ".content-wrapper";
                                }

                                /**
                                 * CODIGOS DE JAVASCRIPT
                                 * --------------------
                                 */
                                //debug($session->read( $accionesPermitidas));
                                $output .= '<script type="text/javascript">
                               // $(document).ready(function() {
                               
                                        $(".pag-ajax").on( "click", function(event) {

                                            //$(".table-ajax").loading();
                                            window.history.pushState("object or string", "Paginacion", $(this).attr("href"));
                                            event.preventDefault();
                                            fetch( $(this).attr("href"), {
                                                method: "GET",                        
                                                headers: {
                                                    "X-Requested-With": "XMLHttpRequest"
                                                }
                                            })
                                            .then(response => response.text())
                                            .then((response) => {
                                                
                                                //jQuery("#accordion").show();
                                                
                                                jQuery("' . $options['response'] . '").html(response);
                                                //console.log(response)
                                            })
                                            .catch(function(err) {
                                                console.log(err);
                                                fetch( "https://cake5-rbac.local/rbac/rbac_usuarios/login", {
                                                    method: "GET",                        
                                                    headers: {
                                                        "X-Requested-With": "XMLHttpRequest"
                                                    }
                                                })
                                                .then((response)=> response.text())
                                                .then((response) => {
                                                    jQuery("#divDialog").html(response)
                                                    $("#myModal").modal("show")
                                                }) 
                                            })
                                        }) 
                               // })
                                    </script>';

                                echo $output;

                                ?>
                            </td>
                        </tr>
                    </tfoot>
                <?php } ?>
            </table>
        </div>
    <?php
    }

    function generateReportTable($data, $rows, $options = array())
    {
        $processedRows = array();


        foreach ($rows as $key => $row) {

            if (is_numeric($key)) {
                $row = explode('.', $row);
                if (count($row) == 2) {
                    $processedRows[] = array(
                        'model' => $row[0],
                        'field'    => $row[1]
                    );
                } else {
                    $processedRows[] = array(
                        'model'        => $this->modelName,
                        'field'        => 'id',
                        'title'        => '',
                        'confirm'    => null,
                        'action'    => $row[0],
                        'class'        => $row[0],
                        'no-sort'
                    );
                }
            } else {
                $key = explode('.', $key);

                if (count($key) > 1) {

                    $model = isset($key[1]) ? $key[0] : $this->modelName;
                    $field = isset($key[1]) ? $key[1] : $key[0];

                    if (isset($key[2])) {
                        $subfield = $key[2];
                        $defaults = array(
                            'model' => $model,
                            'field'    => $field,
                            'subfield'    => $subfield
                        );
                    } else {
                        $defaults = array(
                            'model' => $model,
                            'field'    => $field
                        );
                    }
                    $row = is_array($row) ? $row : array($row);
                    $processedRows[] = array_merge(
                        $defaults,
                        $row
                    );
                } else {
                    $confirm = null;
                    if (is_array($row)) {
                        $confirm = isset($row['confirm']) ? $row['confirm'] : null;
                    } else {
                        $row = array();
                    }

                    $processedRows[] = array_merge(
                        array(
                            'model'        => $this->modelName,
                            'field'        => 'id',
                            'title'        => '',
                            'confirm'    => $confirm,
                            'action'    => $key[0],
                            'class'        => (is_array($row) && isset($row['class'])) ? $row['class'] : $key[0],
                            'no-sort'
                        ),
                        $row
                    );
                }
            }
        }

    ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-ajax">
                <thead>
                    <tr>
                        <?php

                        foreach ($processedRows as $row) {
                            $title = isset($row['title']) ? $row['title'] : Inflector::humanize($row['field']);

                        ?>
                            <th <?php
                                if (isset($row['th-class'])) {
                                    echo 'class="' . $row['th-class'] . '"';
                                }
                                ?>>
                                <?php
                                //debug(in_array('no-sort', $row));

                                if (in_array('no-sort', $row)) {
                                    echo $title;
                                } else {

                                    if (isset($row['subfield'])) {
                                        $field2 =  $row['field'] . "." . $row['subfield'];
                                        // debug($field2);
                                        // debug($title);
                                        //TODO BUG arreglar orden de paginacion para columnas relacionadas 
                                        echo $this->Paginator->sort($field2, $title, array('Model' => 'DocumentoTipos', 'direction' => 'desc'));
                                        //echo $this->Paginator->sort($field2, $title);
                                        //echo $this->Paginator->sort('documento_tipos.descripcion', 'documento_tipo.descripcion', ['escape' => true]);
                                        // echo $title;
                                        // // Generar el enlace con dirección de ordenamiento 'asc'
                                        // echo $this->Html->link(
                                        //     '>',
                                        //     [
                                        //         'controller' => 'Resoluciones',                                                
                                        //         'action' => 'index',
                                        //         '?' => [
                                        //             'sort' => 'documento_tipo.descripcion', // Campo para ordenar
                                        //             'direction' => 'asc' // Dirección de ordenamiento 'asc'
                                        //         ]
                                        //     ]
                                        // );
                                        // echo $this->Html->link(
                                        //     '<',
                                        //     [
                                        //         'controller' => 'Resoluciones',                                                
                                        //         'action' => 'index',
                                        //         '?' => [
                                        //             'sort' => 'documento_tipo.descripcion', // Campo para ordenar
                                        //             'direction' => 'desc' // Dirección de ordenamiento 'asc'
                                        //         ]
                                        //     ]
                                        // );
                                    } else {
                                        //echo $this->Paginator->sort($row['field'], $title);
                                        //$type = $this->Paginator->sortDir() === 'asc' ? 'up' : 'down';
                                        // debug($this->Paginator->sortDir());

                                        $icon = "<i class='icon-arrow-asc'></i>" . $title;
                                        echo $this->Paginator->sort($row['field'], $title, array('escape' => false));
                                    }
                                }
                                ?>
                            </th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($data as $key => $unit) { ?>
                        <tr class="
                            <?php if (isset($options['tr-class'])) {
                                echo ' ' . $options['tr-class']($unit) . ' ';
                            }
                            if (isset($unit['status']) && !$unit['status']) {

                                echo ' disabled ';
                            }

                            ?>
		                ">
                            <?php

                            foreach ($processedRows as $row) { ?>
                                <td <?php

                                    if (
                                        in_array('number', $row)
                                        || in_array('date', $row)
                                        || in_array('time', $row)
                                        || in_array('datetime', $row)
                                    ) {

                                        //echo 'align="right"';
                                    } elseif (
                                        in_array('change-status', $row)
                                        || isset($row['action'])
                                        || in_array('show-status', $row)
                                        || in_array('centered', $row)
                                    ) {

                                        // echo 'align="center"';
                                    }
                                    if (isset($row['class'])) {

                                        echo 'class="' . $row['class'] . '"';
                                    }
                                    ?>>
                                    <?php
                                    //debug($row);
                                    // debug($unit[$row['field']]);die;
                                    //       if ($row['model'] == $this->modelName) {
                                    if (!is_object($unit[$row['field']]) && !is_array($unit[$row['field']])) {
                                        $field =  strval($unit->{$row['field']});
                                        // debug();
                                    } elseif (is_object($unit[$row['field']])) {
                                        //debug("2");die;
                                        if ((isset($row['subfield'])) && isset($unit->{$row['field']}->{$row['subfield']})) {
                                            $field = $unit->{$row['field']}->{$row['subfield']};
                                        }

                                        foreach ($unit[$row['field']] as $k => $v) {
                                            if (!empty($field)) {
                                                $field =    $field . "<br>" . $v[$subfield];
                                            } else {
                                                $field =    $v[$subfield];
                                            }
                                        }
                                    } elseif (is_array($unit[$row['field']])) {
                                        //debug($subfield);
                                        // debug("2");die;
                                        $field = '';
                                        foreach ($unit[$row['field']] as $k => $v) {
                                            if (!empty($field)) {
                                                $field =    $field . "<br>" . $v[$subfield];
                                            } else {
                                                $field =    $v[$subfield];
                                            }
                                        }

                                        // debug("3");
                                    }

                                    $content = $field;

                                    if (isset($row['show-if'])) {
                                        if (!($row['show-if']($unit))) {
                                            $row = array('empty');
                                        }
                                    }
                                    if (in_array('empty', $row)) {
                                        $content = '';
                                    } elseif (in_array('datetime', $row)) {
                                        if ($unit[$row['model']][$row['field']]) {

                                            $date = new DateTime($unit[$row['model']][$row['field']], new \DateTimeZone('America/Argentina/Buenos_Aires'));
                                            $content = $date->format(FORMAT_DATETIME_VIEW);
                                        }
                                    } elseif (in_array('date', $row)) {

                                        $date = new DateTime($unit->{$row['field']});

                                        $content = $date->format(FORMAT_DATE_VIEW);
                                    } elseif (in_array('time', $row)) {
                                        if ($unit[$row['field']]) {
                                            $content = $this->Time->format(
                                                FORMAT_TIME_VIEW,
                                                $unit[$row['field']]
                                            );
                                        }
                                    } elseif (in_array('show-status', $row)) {
                                        $status = 'glyphicon-remove';
                                        if ($unit[$row['field']]) {
                                            $status = 'glyphicon-ok';
                                            if (isset($row['tooltip-on'])) {
                                                $row['tooltip'] = $row['tooltip-on'];
                                            }
                                        } else {
                                            if (isset($row['tooltip-off'])) {
                                                $row['tooltip'] = $row['tooltip-off'];
                                            }
                                        }
                                        if (isset($row['tooltip'])) {
                                            $title = $row['tooltip'];
                                        } else {
                                            $title = "";
                                        }
                                        //$content = $this->view->Html->link(
                                        $content = $this->Html->link(
                                            '',
                                            'javascript:void(0);',
                                            array(
                                                'class'        =>    'glyphicon ' . $status,
                                                'title'        => $title,
                                                'style'        => 'cursor: default;color:black;'
                                            )
                                        );
                                    } elseif (in_array('change-status', $row)) {
                                        $status = 'No';

                                        if ($field) {
                                            $status = 'Si';
                                            if (isset($row['tooltip-on'])) {
                                                $row['tooltip'] = $row['tooltip-on'];
                                            }
                                        } else {
                                            if (isset($row['tooltip-off'])) {
                                                $row['tooltip'] = $row['tooltip-off'];
                                            }
                                        }
                                        $action = 'changeStatus';
                                        if (isset($row['change-status-action'])) {
                                            $action = $row['change-status-action'];
                                        }
                                        if (isset($row['tooltip'])) {
                                            $title = $row['tooltip'];
                                        } else {
                                            $title = Inflector::humanize($action);
                                        }
                                        $extraParam = '';
                                        if (isset($row['extra-param'])) {
                                            $extraParam = $row['extra-param'];
                                        }
                                        // debug( $row);die;
                                        $content = $this->link(
                                            "$status",
                                            array(
                                                'controller' => $this->controllerName,
                                                'action'    => $action
                                                    . '/' . $unit['id'],
                                                $extraParam
                                            ),
                                            array(
                                                'class'        =>    'btn-sm btn-primary ',
                                                'title'        => $title
                                            )
                                        );
                                    } elseif (isset($row['update-text'])) {
                                        $content = $this->Form->input(
                                            $row['model'] . '.'
                                                . $row['field'],
                                            array(
                                                'label'        => false,
                                                'value'        => $unit[$row['model']][$row['field']],
                                                'imageId'    => $unit[$row['model']]['id'],
                                                'class'        => 'update-text'
                                            )
                                        );
                                    } elseif (isset($row['input'])) {
                                        $content = $this->Form->input(
                                            $row['input']['model'] . '.'
                                                . $unit['ContentsFile']['id'] . '.'
                                                . $row['input']['name'],
                                            array(
                                                'label'    => false,
                                                'value'    => $unit['ContentsFile'][$row['input']['name']]
                                            )
                                        );
                                    } elseif (isset($row['action'])) {
                                        // debug(in_array('edit', $row));
                                        // debug($row);
                                        //  die("action");
                                        if (in_array('no-ajax', $row)) {
                                            $html = &$this->view->Html;
                                        } else {
                                            $html = &$this;
                                        }
                                        if (isset($row['target'])) {
                                            $target = $row['target'];
                                        } else {
                                            $target = '_self';
                                        }
                                        if (isset($row['tooltip'])) {
                                            $title = $row['tooltip'];
                                        } else {
                                            if (isset($row['text'])) {
                                                $title = '';
                                            } else {
                                                $title = Inflector::humanize($row['class']);
                                            }
                                        }
                                        $class = '';
                                        if (isset($row['text'])) {
                                            $text = $row['text'];
                                            $class = $row['class'];
                                        } else {
                                            $text = '';
                                            // debug($row);die;
                                            if ($row['action'] == 'edit' || $row['action'] == 'editar') {
                                                $class = 'editar btn btn-success btn-xs ' . $row['class'];
                                            } elseif ($row['action'] == 'delete' or $row['action'] == 'eliminar') {
                                                $class = 'editar btn btn-danger btn-xs ' . $row['class'];
                                            } elseif ($row['action'] == 'view' or $row['action'] == 'ver') {
                                                $class = 'editar btn btn-info btn-xs ' . $row['class'];
                                            } elseif ($row['action'] == 'download' or $row['action'] == 'descargarArchivo' or $row['action'] == 'descargarArchivoPublico') {
                                                $class = 'editar btn btn-default btn-xs ' . $row['class'];
                                            }
                                        }
                                        $extraParam = '';
                                        if (isset($row['extra-param'])) {
                                            $extraParam = $row['extra-param'];
                                        }
                                        //Si se quiere agreagar una accion distinta a la predifinidas  ['delete', 'remove', 'eliminar']
                                        // se lo pone en la etiqueta edit-action o delete-action segun corresponda
                                        if (isset($row['edit-action'])) {
                                            $action = $row['edit-action'];
                                        } elseif (isset($row['delete-action'])) {
                                            $action = $row['delete-action'];
                                        } else {
                                            $action = $row['action'];
                                        }

                                        if (isset($_SESSION['permitidas'][Inflector::underscore($this->controllerName)])) {
                                           
                                            $accionesPermitidas = $_SESSION['permitidas'][Inflector::underscore($this->controllerName)];
                                            $actions = ['delete', 'remove', 'eliminar'];
                                            if (
                                                in_array($action, $actions) && isset($accionesPermitidas[$action][$_SESSION['virtualHost']]) &&
                                                ($accionesPermitidas[$action][$_SESSION['virtualHost']])
                                            ) {
                                               
                                                if (
                                                    (!isset($row['conditions']) or
                                                        (isset($row['conditions'])
                                                            && (count($unit[$row['conditions']]) == 0))
                                                    )
                                                    && isset($accionesPermitidas[$action][$_SESSION['virtualHost']]) && ($accionesPermitidas[$action][$_SESSION['virtualHost']])
                                                ) {                                                    
                                                    if (!isset($unit['deleted'])) {
                                                        $content = $this->Form->postLink(
                                                            '<span class="glyphicon glyphicon-' . $row['class'] . '"></span>',
                                                            [
                                                                'action'    => $action,
                                                                $unit[$row['field']],
                                                                $extraParam
                                                            ],
                                                            [
                                                                'confirm' => "¿Está seguro de eliminar?",
                                                                'class'        => $class,
                                                                'title'        => $title,
                                                                'target'    => $target,
                                                                'escape' => false
                                                            ],
                                                        );
                                                    }
                                                } else {
                                                    $content = '<a href="javascript:void(0)" class=" btn btn-default btn-xs " title="tiene datos asociados" target="_self"><span class="glyphicon glyphicon-minus"></span></a>';
                                                }
                                            } else {
                                                // debug($action);
                                                // debug((!isset($row['conditions']) or
                                                //     (
                                                //         (isset($row['conditions'])
                                                //             && (count($unit[$row['conditions']]) == 0)
                                                //         )
                                                //     )));
                                                // debug($_SESSION['virtualHost']);
                                                // debug(isset($accionesPermitidas[$action][$_SESSION['virtualHost']]) );
                                                // debug(($accionesPermitidas[$action][$_SESSION['virtualHost']]));
                                                // debug($action);
                                                // debug($accionesPermitidas);
                                               
                                                if (
                                                    (!isset($row['conditions']) or
                                                        (
                                                            (isset($row['conditions'])
                                                                && (count($unit[$row['conditions']]) == 0)
                                                            )
                                                        ))
                                                    && isset($accionesPermitidas[$action][$_SESSION['virtualHost']])
                                                    && ($accionesPermitidas[$action][$_SESSION['virtualHost']])
                                                ) {

                                                    if ($action == 'descargarArchivo' or $action == 'descargarArchivoPublico') {

                                                        if (isset($unit->uploads) and (count($unit->uploads) > 0)) {
                                                            $content = $this->link(
                                                                '<span class="glyphicon glyphicon-' . $row['class'] . '"></span>',
                                                                array(
                                                                    'controller' => $this->controllerName,
                                                                    'action'    => $action
                                                                        . '/' . $unit->id,
                                                                    $extraParam
                                                                ),
                                                                array(
                                                                    'class'        => $class,
                                                                    'title'        => $title,
                                                                    'target'    => $target,
                                                                    'escape' => false
                                                                ),
                                                                $row['confirm']
                                                            );
                                                        } else {
                                                            $content =
                                                                '<a href="#" class="editar btn btn-default btn-xs download" title="Sin Documento" target="_self"><span class="glyphicon glyphicon-minus"></span></a>';
                                                        }
                                                    } else {

                                                        $content = $this->link(
                                                            '<span class="glyphicon glyphicon-' . $row['class'] . '"></span>',
                                                            array(
                                                                'controller' => $this->controllerName,
                                                                'action'    => $action
                                                                    . '/' . $unit[$row['field']],
                                                                $extraParam
                                                            ),
                                                            array(
                                                                'class'        => $class,
                                                                'title'        => $title,
                                                                'target'    => $target,
                                                                'escape' => false
                                                            ),
                                                            $row['confirm']
                                                        );
                                                    }
                                                } else {

                                                    # code...
                                                    if (isset($accionesPermitidas[$action][$_SESSION['virtualHost']]) && ($accionesPermitidas[$action][$_SESSION['virtualHost']])) {
                                                        $content = '<a href="javascript:void(0)" class="editar btn btn-warning btn-xs " title="tiene resoluciones asociadas" target="_self"><span class="glyphicon glyphicon-minus"></span></a>';
                                                    } else {
                                                        $content = "dd";
                                                    }
                                                    if ($row['html']) {
                                                        $content = $row['html'];
                                                    }
                                                }
                                            }
                                        } else {
                                            debug($row['conditions']);die;
                                            if (
                                                (!isset($row['conditions']) or
                                                    (
                                                        (isset($row['conditions'])
                                                            && (count($unit[$row['conditions']]) == 0)
                                                        )
                                                    ))
                                                // && isset($accionesPermitidas[$action][$_SESSION['virtualHost']]) 
                                                // && ($accionesPermitidas[$action][$_SESSION['virtualHost']])
                                            ) {

                                                if ($action == 'descargarArchivo' or $action == 'descargarArchivoPublico') {
                                                  
                                                    if (isset($unit['uploads']) and (count($unit['uploads']) > 0)) {
                                                        //if (count($unit['uploads']) == 1) {
                                                            $content = $this->link(
                                                                '<span class="glyphicon glyphicon-' . $row['class'] . '"></span>',
                                                                array(
                                                                    'controller' => $this->controllerName,
                                                                    'action'    => $action
                                                                        . '/' . $unit->id,
                                                                    $extraParam
                                                                ),
                                                                array(
                                                                    'class'        => $class,
                                                                    'title'        => $title,
                                                                    'target'    => $target,
                                                                    'escape' => false
                                                                ),
                                                                $row['confirm']
                                                            );
                                                        // } else {
                                                        //     //zip archivo
                                                        //     debug(isset($unit['uploads']) and (count($unit['uploads']) > 0));
                                                        //     die;
                                                        // }
                                                    } else {
                                                        $content =
                                                            '<a href="#" class="editar btn btn-default btn-xs download" title="Sin Documento" target="_self"><span class="glyphicon glyphicon-minus"></span></a>';
                                                    }
                                                } else {
                                                    $content = $this->link(
                                                        '<span class="glyphicon glyphicon-' . $row['class'] . '"></span>',
                                                        array(
                                                            'controller' => $this->controllerName,
                                                            'action'    => $action
                                                                . '/' . $unit[$row['field']],
                                                            $extraParam
                                                        ),
                                                        array(
                                                            'class'        => $class,
                                                            'title'        => $title,
                                                            'target'    => $target,
                                                            'escape' => false
                                                        ),
                                                        $row['confirm']
                                                    );
                                                }
                                            } else {
                                                //debug($row);
                                                # code...
                                                if (isset($accionesPermitidas[$action][$_SESSION['virtualHost']]) && ($accionesPermitidas[$action][$_SESSION['virtualHost']])) {
                                                    $content = '<a href="javascript:void(0)" class="editar btn btn-warning btn-xs " title="tiene resoluciones asociadas" target="_self"><span class="glyphicon glyphicon-minus"></span></a>';
                                                } else {
                                                    $content = "dd";
                                                }
                                                if ($row['html']) {
                                                    $content = $row['html'];
                                                }
                                            }
                                        }
                                    } elseif (in_array('edit', $row)) {
                                        //  die("edit");
                                        $action = 'edit';
                                        $controller = $this->controllerName;
                                        //debug($row);die;
                                        if (isset($row['edit-action'])) {
                                            $action = $row['edit-action'];
                                        }
                                        if (isset($row['edit-controller'])) {
                                            $controller = $row['edit-controller'];
                                        }

                                        $opt = array(
                                            'controller' => $controller,
                                            'action'    => $action
                                                . '/' . $unit['id']
                                        );

                                        if (isset($row['admin'])) {
                                            $opt['admin'] = $row['admin'];
                                        }

                                        if ($row['model'] == $this->modelName) {
                                            $u = $unit[$row['field']];
                                        } else {
                                            $m = Inflector::singularize(Inflector::underscore($row['model']));
                                            $u = $unit[$m][$row['field']];
                                        }

                                        $content = $this->Html->link(
                                            $u,
                                            $opt,
                                            array(
                                                'escape'    => false
                                            )
                                        );
                                    } elseif (in_array('detail', $row)) {
                                        $content = $this->Html->link(
                                            'Dashboard',
                                            ['controller' => 'Dashboards', 'action' => 'index', '_full' => true]
                                        );
                                    } elseif (in_array('thumbnail', $row)) {
                                        $content = $this->Html->image(
                                            '../' . $unit[$row['model']][$row['field']],
                                            array(
                                                'width'        => 80
                                            )
                                        );
                                    } elseif (isset($row['html'])) {
                                        $content = $row['html'];
                                    } elseif (isset($row['index-from'])) {
                                        if (isset($row['index-from'][$unit[$row['model']][$row['field']]])) {
                                            $content = $row['index-from'][$unit[$row['model']][$row['field']]];
                                        } else {
                                            $content = '';
                                        }
                                    }
                                    //debug($row);
                                    if (isset($row['function'])) {
                                        if ($row['function'] == 'nl2br') {
                                            $content = call_user_func(
                                                $row['function'],
                                                $content
                                            );
                                        } else {
                                            $content = call_user_func(
                                                $row['function'],
                                                $content,
                                                $unit
                                            );
                                        }
                                    }

                                    if (in_array('truncate', $row)) {
                                        # $truncateLength = LIMIT_CHARACTERS_IN_DESCRIPTION_FIELDS;

                                        $truncateLength = 100;
                                        if (isset($row['truncate-length'])) {
                                            $truncateLength = $row['truncate-length'];
                                        }
                                        $truncateOptions = array(
                                            'exact'        => false,
                                            'ending'    => '...'
                                        );
                                        // debug($content);
                                        // if (isset($row['truncate-options'])) {
                                        //    $truncateOptions = $row['truncate-options'];
                                        // }

                                        if (!is_null($content)) {
                                            $content = $this->Text->truncate(
                                                $content,
                                                $truncateLength,
                                                $truncateOptions
                                            );
                                        }
                                    }


                                    echo $content;

                                    ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php }

                    ?>
                </tbody>
                <?php if (in_array('simulate-pagination', $options)) { ?>
                    <tfoot>
                        <tr>
                            <td colspan="<?php echo count($processedRows) ?>">
                                Página 1 de 1 | Total: <?php echo count($data); ?> registros
                            </td>
                        </tr>
                    </tfoot>
                <?php } elseif (!in_array('no-pagination', $options)) { ?>
                    <tfoot>
                        <tr>
                            <td colspan="<?php echo count($processedRows) ?>">

                                <?php //echo $this->_View->element('general/paginator'); 

                                /**
                                 * PAGINACION
                                 * ----------
                                 */

                                $pager_params = $this->Paginator->params();
                                // Change a template
                                $this->Paginator->setTemplates([
                                    'number' => '<li><a class="pag-ajax page-link" href="{{url}}">{{text}}</a></li>',
                                    'first' => '<li><a class="pag-ajax page-link" href="{{url}}">{{text}}</a></li>',
                                    'last' => '<li><a class="pag-ajax page-link" href="{{url}}">{{text}}</a></li>',
                                    'prevActive' => '<li><a class="pag-ajax page-link" href="{{url}}">{{text}}</a></li>',
                                    'nextActive' => '<li><a class="pag-ajax page-link" href="{{url}}">{{text}}</a></li>'
                                ]);
                                $output = '';
                                $output .= '<div class=" text-center">';
                                if ($pager_params['pageCount'] > 1) {
                                    $output .= '<ul class="pagination">';
                                    $output .= '<li>';
                                    $output .= $this->Paginator->first('PRIMERO');
                                    $output .= $this->Paginator->prev('ANTERIOR');
                                    $output .= '</li>';
                                    $output .= '<li>';
                                    $output .= $this->Paginator->numbers();
                                    $output .= '</li>';
                                    $output .= '<li>';
                                    $output .= $this->Paginator->next('SIGUIENTE');
                                    $output .= $this->Paginator->last('ULTIMO');
                                    $output .= '</li>';
                                    $output .= '</ul>';

                                    $total = "Página: " . $this->Paginator->counter('{{page}} de {{pages}}, mostrando {{current}} registros
                                     de {{count}}');
                                    $output .= '<div align="center">' . $total . '</div>';
                                    $output .= '</div>';
                                    $output .= '<div class="clear"><br /></div>';
                                }
                                // $output .= '<div id="divDialog" title="Basic dialog">

                                //</div>';
                                if (isset($div)) {
                                    $output .= $div;
                                }
                                if (!isset($options['response'])) {
                                    $options['response'] = ".content-wrapper";
                                }

                                /**
                                 * CODIGOS DE JAVASCRIPT
                                 * --------------------
                                 */
                                //debug($session->read( $accionesPermitidas));
                                $output .= '<script type="text/javascript">
                               // $(document).ready(function() {
                               
                                        $(".pag-ajax").on( "click", function(event) {

                                            //$(".table-ajax").loading();
                                            window.history.pushState("object or string", "Paginacion", $(this).attr("href"));
                                            event.preventDefault();
                                            fetch( $(this).attr("href"), {
                                                method: "GET",                        
                                                headers: {
                                                    "X-Requested-With": "XMLHttpRequest"
                                                }
                                            })
                                            .then(response => response.text())
                                            .then((response) => {
                                                
                                                //jQuery("#accordion").show();
                                                
                                                jQuery("' . $options['response'] . '").html(response);
                                                //console.log(response)
                                            })
                                            .catch(function(err) {
                                                console.log(err);
                                                fetch( "https://cake5-rbac.local/rbac/rbac_usuarios/login", {
                                                    method: "GET",                        
                                                    headers: {
                                                        "X-Requested-With": "XMLHttpRequest"
                                                    }
                                                })
                                                .then((response)=> response.text())
                                                .then((response) => {
                                                    jQuery("#divDialog").html(response)
                                                    $("#myModal").modal("show")
                                                }) 
                                            })
                                        }) 
                               // })
                                    </script>';

                                echo $output;

                                ?>
                            </td>
                        </tr>
                    </tfoot>
                <?php } ?>
            </table>
        </div>
<?php
    }
}
