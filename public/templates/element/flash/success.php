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
<!-- <div class="message success" onclick="this.classList.add('hidden')"><?= $message ?></div>-->

<div class="content">

    <div class="alert alert-success" onclick="this.classList.add('hidden')"><?= $message ?></div>
</div>