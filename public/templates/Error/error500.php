<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Database\StatementInterface $error
 * @var string $message
 * @var string $url
 */

use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

if (Configure::read('debug')) :
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.php');

    $this->start('file');
?>
    <?php if (!empty($error->queryString)) : ?>
        <p class="notice">
            <strong>SQL Query: </strong>
            <?= h($error->queryString) ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
    <?php endif; ?>
    <?php if ($error instanceof Error) : ?>
        <?php $file = $error->getFile() ?>
        <?php $line = $error->getLine() ?>
        <strong>Error in: </strong>
        <?= $this->Html->link(sprintf('%s, line %s', Debugger::trimPath($file), $line), Debugger::editorUrl($file, $line)); ?>
    <?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

    $this->end();
endif;
?>


<!-- Main content -->
<section class="content">

    <div class="error-page">


        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i>¡Ups! Algo salió mal.</h3>

            <p>
            Estamos trabajando para solucionarlo de inmediato.
            Mientras tanto, puedes intentar <a href="<?php echo $this->Url->build('pages/home'); ?>">volver al panel</a>.
            </p>


        </div>
    </div>
    <!-- /.error-page -->

</section>
<!-- /.content -->
