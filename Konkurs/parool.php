<?php
$parool='opilane';
$sool='vagavagatekst';
$krypt=crypt($parool,$sool);
echo $krypt;