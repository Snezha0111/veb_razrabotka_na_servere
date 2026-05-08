<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Лабораторная 3</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='style3.css'>
</head>
<body>
    <div class="container">
        <header>
            <img src="Logo_Polytech_rus_main.jpg" width="200px" alt="Логотип МосПолитеха">
            <p>Лабораторная работа 3</p>
        </header>
        <main>
            <div class="equals">
                <p class="primer">
                    Вариант 1: x + 3 = 7
                </p>
                <p class="answer_primer">
                    Ответ: 
                    <?php
                        function solveEquation($equation) {
                            // Наличие равенства
                            if (strpos($equation, '=') === false) {
                                return ['error' => 'Уравнение должно содержать знак "="'];
                            }
                            
                            // Левая и правая часть
                            list($left_part, $right_part) = explode('=', $equation);
                            
                            // Лишние пробелы
                            $left_part = str_replace(' ', '', $left_part);
                            $right_part = (int)str_replace(' ', '', $right_part);
                            
                            //Оператор в левой части
                            $operators = ['+', '-', '*', '/'];
                            $operator = null;
                            
                            for ($i = 0; $i < count($operators); $i++) {
                                if (strpos($left_part, $operators[$i])) {
                                    $operator = $operators[$i];
                                    break;
                                }
                            }
                            
                            if (!$operator) {
                                return ['error' => 'Оператор не найден'];
                            }
                            
                            // Левая на две части
                            $operands = explode($operator, $left_part);
                            $first = $operands[0];
                            $second = $operands[1];
                            
                            $free_term = null;
                            
                            if (strpos($first, 'x')) {
                                $free_term = (int)$first;
                            } else {
                                $free_term = (int)$second;
                            }
                            
                            // Решение
                            switch ($operator) {
                                case '+':
                                    $result = $right_part - $free_term;
                                    break;
                                case '-':
                                    if (strpos($first, 'x')) {
                                        $result = $free_term - $right_part;
                                    } else {
                                        $result = $right_part + $free_term;
                                    }
                                    break;
                                case '*':
                                    $result = $right_part / $free_term;
                                    break;
                                case '/':
                                    if (strpos($first, 'x')) {
                                        $result = $free_term / $right_part;
                                    } else {
                                        $result = $right_part * $free_term;
                                    }
                                    break;
                                default:
                                    return ['error' => 'Неизвестный оператор'];
                            }
                            return ['x' => $result];
                        }

                        $eq = 'x + 3 = 7';
                        $res = solveEquation($eq);
                        
                        if (isset($res['error'])) {
                            echo 'Ошибка:'. $res["error"];
                        } else {
                            echo 'x = ' .$res["x"] ;
                        }
                    ?>
                </p>
            </div>
        </main>
        <footer>
            <p>Домашняя работа: Solve the equation.</p>
        </footer>
    </div>
    
</body>
</html>
