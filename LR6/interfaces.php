<?php
interface CalculateSquare
{
    public function calculateSquare(): float;
}

class Rectangle implements CalculateSquare
{
    private float $width;
    private float $height;

    public function __construct(float $width, float $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function calculateSquare(): float
    {
        return $this->width * $this->height;
    }
}

class Circle implements CalculateSquare
{
    private float $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function calculateSquare(): float
    {
        return pi() * pow($this->radius, 2);
    }
}

class SomeOtherClass
{
    
}

function printSquareInfo($object)
{
    if ($object instanceof CalculateSquare) {
        $className = get_class($object);
        $square = $object->calculateSquare();
        echo "Объект класса {$className} имеет площадь: " . round($square, 2) . "<br>";
    } else {
        $className = get_class($object);
        echo "Объект класса {$className} не реализует интерфейс CalculateSquare.<br>";
    }
}

$rect = new Rectangle(4, 5);
$circle = new Circle(3);
$other = new SomeOtherClass();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CalculateSquare</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="Logo_Polytech_rus_main.jpg" alt="Логотип">
        <p>Лабораторная работа №6 - Интерфейсы в php </p>
    </header>

    <main>
        <div class="task-block">
            <p class="name_task">Интерфейс CalculateSquare</p>
            <p><?php printSquareInfo($rect); ?></p>
            <p><?php printSquareInfo($circle); ?></p>
            <p><?php printSquareInfo($other); ?></p>
        </div>
    </main>

    <footer>Задание для самостоятельной работы "ООП в PHP"</footer>
</body>
</html>