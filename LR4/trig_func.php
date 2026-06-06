<?php

function evaluateTrig($funcName, $angle) {
    $radians = deg2rad($angle);

    if (function_exists($funcName)) {
        return $funcName($radians);
    } else {
        throw new InvalidArgumentException("Тригонометрическая функция '$funcName' не поддерживается.");
    }
}
?>