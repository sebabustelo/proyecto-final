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
<!-- <div class="message" onclick="this.classList.add('hidden');"><?= $message ?></div>-->
<div class="content">
    <div class="alert alert-info" onclick="this.classList.add('hidden')"><?= $message ?></div>
</div>