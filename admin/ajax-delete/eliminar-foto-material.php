<?php

$folio = filter_input(INPUT_POST, 'folio', FILTER_SANITIZE_SPECIAL_CHARS);

$vowels = "upload/materiales/";
$folio = str_replace($vowels, "", $folio);

unlink('../upload/materiales/'.$folio);