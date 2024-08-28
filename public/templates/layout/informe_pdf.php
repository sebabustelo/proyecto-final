<?php
header("Content-type: application/pdf");
header( "Content-Disposition: inline; filename=".$archivo.".pdf" );
$this->fetch('content');
?>