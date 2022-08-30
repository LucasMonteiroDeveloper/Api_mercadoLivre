<?php
function debug($string) {
    $return = "<pre>".print_r($string)."</pre>";
    return $return;
}

function somar($x, $y) {
    $resultado = $x * $y;
    return $resultado;
}
?>