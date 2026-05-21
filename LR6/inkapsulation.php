<?php
class Cat
{
    private string $name;
    private string $color;

    public function __construct(string $name, string $color)
    {
        $this->name = $name;
        $this->color = $color;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function sayHello(): string
    {
        return "Мяу! Меня зовут {$this->name}. Я {$this->color} цвета.";
    }
}

$cat = new Cat('Эльфик', 'черного');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Класс Cat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="Logo_Polytech_rus_main.jpg" alt="Логотип">
        <p>Лабораторная работа №6 - Инкапсуляция</p>
    </header>

    <main>
        <div class="task-block">
            <p class="name_task">Класс Cat <p>
            <p><?php echo $cat->sayHello() ?></p>
            <p>Цвет кошки: <?php echo $cat->getColor() ?></p>
        </div>
    </main>

    <footer>Задание для самостоятельной работы "ООП в PHP"</footer>
</body>
</html>