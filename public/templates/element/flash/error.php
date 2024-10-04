<?php

/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<!-- <div class="message error" onclick="this.classList.add('hidden');"><?= $message ?></div>-->
<div class="content">
    <div class="alert alert-danger" onclick="this.classList.add('hidden')"><span class=" "> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?= $message ?></div>
</div>
