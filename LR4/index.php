<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function isnum($x) {
    if (is_numeric($x)){ 
        return true;
    }
    if (!is_string($x)){ 
        return false;
    }
    if ($x === '') {
        return false;
    }
    return preg_match('/^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/', trim($x));
}

// проверки 
function mysin($x) { return sin(deg2rad(floatval($x))); }
function mycos($x) { return cos(deg2rad(floatval($x))); }
function mytan($x) { return tan(deg2rad(floatval($x))); }
function mysqrt($x) { 
    $x = floatval($x);
    if ($x < 0) return 'Корень из отрицательного числа';
    return sqrt($x); 
}
function myln($x) { 
    $x = floatval($x);
    if ($x <= 0) return 'Логарифм от неположительного числа';
    return log($x); 
}
function mylog($x) { 
    $x = floatval($x);
    if ($x <= 0) return 'Логарифм от неположительного числа';
    return log10($x); 
}
function myfactorial($n) {
    $n = intval($n);
    if ($n < 0) return 'Факториал отрицательного числа';
    if ($n > 170) return INF;
    $f = 1;
    for ($i = 2; $i <= $n; $i++) $f *= $i;
    return $f;
}
function mypow($a, $b) { return pow(floatval($a), floatval($b)); }

// калькулятор
function calculate($expr) {
    $expr = trim($expr);
    if ($expr === '') return 'Ошибка: пустое выражение';
    
    if (isnum($expr)) {
        return floatval($expr);
    }
    
    // p, e
    $expr = str_replace('pi', pi(), $expr);
    $expr = str_replace('e', exp(1), $expr);
    
    // минус
    if (strpos($expr, '-') === 0 && preg_match('/^-(\d+)/', $expr, $m)) {
        $expr = '0' . $expr;
    }
    $expr = preg_replace('/\(-(\d+)\)/', '(0-$1)', $expr);
    $expr = preg_replace('/-\(-(\d+)\)/', '$1', $expr);
    
    
    // sin
    if (preg_match('/sin\(([^()]+)\)/', $expr, $m)) {
        $arg = calculate($m[1]);
        if (!isnum($arg)) return $arg;
        $res = mysin($arg);
        $expr = str_replace($m[0], $res, $expr);
        return calculate($expr);
    }
    // cos
    if (preg_match('/cos\(([^()]+)\)/', $expr, $m)) {
        $arg = calculate($m[1]);
        if (!isnum($arg)) return $arg;
        $res = mycos($arg);
        $expr = str_replace($m[0], $res, $expr);
        return calculate($expr);
    }
    // tan
    if (preg_match('/tan\(([^()]+)\)/', $expr, $m)) {
        $arg = calculate($m[1]);
        if (!isnum($arg)) return $arg;
        $res = mytan($arg);
        $expr = str_replace($m[0], $res, $expr);
        return calculate($expr);
    }
    // корень
    if (preg_match('/sqrt\(([^()]+)\)/', $expr, $m)) {
        $arg = calculate($m[1]);
        if (!isnum($arg)) return $arg;
        $res = mysqrt($arg);
        $expr = str_replace($m[0], $res, $expr);
        return calculate($expr);
    }
    // ln
    if (preg_match('/ln\(([^()]+)\)/', $expr, $m)) {
        $arg = calculate($m[1]);
        if (!isnum($arg)) return $arg;
        $res = myln($arg);
        $expr = str_replace($m[0], $res, $expr);
        return calculate($expr);
    }
    // log
    if (preg_match('/log\(([^()]+)\)/', $expr, $m)) {
        $arg = calculate($m[1]);
        if (!isnum($arg)) return $arg;
        $res = mylog($arg);
        $expr = str_replace($m[0], $res, $expr);
        return calculate($expr);
    }
    
    // факториал
    if (preg_match('/(\d+)!/', $expr, $m)) {
        $res = myfactorial($m[1]);
        $expr = str_replace($m[0], $res, $expr);
        return calculate($expr);
    }
    
    // степень
    if (preg_match('/([0-9.eE+-]+)\^([0-9.eE+-]+)/', $expr, $m)) {
        $res = mypow(floatval($m[1]), floatval($m[2]));
        $expr = str_replace($m[0], $res, $expr);
        return calculate($expr);
    }
    
    // скобки 
    $start = strrpos($expr, '(');
    if ($start !== false) {
        $end = strpos($expr, ')', $start);
        if ($end !== false) {
            $before = substr($expr, 0, $start);
            $inside = substr($expr, $start + 1, $end - $start - 1);
            $after = substr($expr, $end + 1);
            
            $innerResult = calculate($inside);
            if (!isnum($innerResult)) return $innerResult;
            
            $newExpr = $before . $innerResult . $after;
            return calculate($newExpr);
        }
    }
    
    // умножение и деление
    if (preg_match('/([0-9.eE+-]+)([*\/])([0-9.eE+-]+)/', $expr, $m)) {
        $a = floatval($m[1]);
        $b = floatval($m[3]);
        if ($m[2] == '*') {
            $res = $a * $b;
        } else {
            if ($b == 0) return 'Деление на ноль!';
            $res = $a / $b;
        }
        $expr = str_replace($m[0], $res, $expr);
        return calculate($expr);
    }
    
    // сложение и вычитание
    $len = strlen($expr);
    $result = 0;
    $current = '';
    $sign = 1;
    
    for ($i = 0; $i < $len; $i++) {
        $ch = $expr[$i];
        if ($ch == '+') {
            $result += $sign * floatval($current);
            $current = '';
            $sign = 1;
        } elseif ($ch == '-') {
            $result += $sign * floatval($current);
            $current = '';
            $sign = -1;
        } else {
            $current .= $ch;
        }
    }
    $result += $sign * floatval($current);
    
    return $result;
}

//get 
$result = '';
$error = '';
$expression = '';

if (isset($_GET['expr'])) {
    $expression = trim($_GET['expr']);
    if ($expression === '') {
        $error = 'Выражение не задано!';
    } else {
        $res = calculate($expression);
        if (isnum($res)) {
            $result = $res;
            if ($result == floor($result)) $result = floor($result);
            else $result = round($result, 10);
        } else {
            $error = $res;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Калькулятор | Лабораторная работа 4</title>
    <link rel="stylesheet" href="style4.css">
</head>
<body>
    <header>
        <img src="Logo_Polytech_rus_main.jpg" width="200px" alt="Логотип МосПолитеха">
        <p>Лабораторная работа 4</p>
    </header>
    
    <div class="calculator">
        <div class="display-section">
            <div class="expression-display" id="expressionDisplay">0</div>
            <div class="result-label">результат ↓</div>
            <div class="result-display" id="resultDisplay">
                <?php 
                if ($result !== ''){
                    echo $result; 
                }
                elseif ($error !== ''){
                    echo $error;
                } 
                ?>
            </div>
        </div>
        
        <div class="buttons">
            <button class="operator" data-val="sin(">sin</button>
            <button class="operator" data-val="cos(">cos</button>
            <button class="operator" data-val="tan(">tan</button>
            <button class="operator" data-val="sqrt(">√</button>
            <button class="operator" data-val="ln(">ln</button>
            
            <button class="operator" data-val="log(">log</button>
            <button class="operator" data-val="!">x!</button>
            <button class="operator" data-val="^">^</button>
            <button class="operator" data-val="pi">π</button>
            <button class="operator" data-val="e">e</button>
            
            <button class="digit" data-val="7">7</button>
            <button class="digit" data-val="8">8</button>
            <button class="digit" data-val="9">9</button>
            <button class="operator" data-val="(">(</button>
            <button class="operator" data-val=")">)</button>
            
            <button class="digit" data-val="4">4</button>
            <button class="digit" data-val="5">5</button>
            <button class="digit" data-val="6">6</button>
            <button class="operator" data-val="*">×</button>
            <button class="operator" data-val="/">÷</button>
            
            <button class="digit" data-val="1">1</button>
            <button class="digit" data-val="2">2</button>
            <button class="digit" data-val="3">3</button>
            <button class="operator" data-val="-">-</button>
            <button class="operator" data-val="+">+</button>
            
            <button class="digit" data-val="0">0</button>
            <button class="digit" data-val=".">.</button>
            <button class="clear" id="clearBtn">C</button>
            <button class="backspace" id="backspaceBtn">⌫</button>
            <button class="equal" id="equalBtn">=</button>
        </div>
    </div>
    
    <footer>
        Задание для самостоятельной работы "Calculator"
    </footer>
    
    <script src="main4.js"></script>
</body>
</html>