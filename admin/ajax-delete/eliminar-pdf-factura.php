<?php

$folio = filter_input(INPUT_POST, 'folio', FILTER_SANITIZE_SPECIAL_CHARS);

$vowels = "pdf/facturas/";
$folio = str_replace($vowels, "", $folio);

unlink('../pdf/facturas/'.$folio);