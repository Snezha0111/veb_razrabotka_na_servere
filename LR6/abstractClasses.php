<?php
abstract class HumanAbstract
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract public function getGreetings(): string;
    abstract public function getMyNameIs(): string;

    public function introduceYourself(): string
    {
        return $this->getGreetings() . '! ' . $this->getMyNameIs() . ' ' . $this->getName() . '.';
    }
}

class RussianHuman extends HumanAbstract
{
    public function getGreetings(): string
    {
        return 'Привет';
    }

    public function getMyNameIs(): string
    {
        return 'Меня зовут';
    }
}

class EnglishHuman extends HumanAbstract
{
    public function getGreetings(): string
    {
        return 'Hello';
    }

    public function getMyNameIs(): string
    {
        return 'My name is';
    }
}

$russian = new RussianHuman('Иван');
$english = new EnglishHuman('John');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Абстрактный класс</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="Logo_Polytech_rus_main.jpg" alt="Логотип">
        <p>Лабораторная работа №6 - Абстрактный класс</p>
    </header>

    <main>
        <div class="task-block">
            <p class="name_task">Абстрактный класс Human</p>
            <p><?php echo $russian->introduceYourself() ?></p>
            <p><?php echo $english->introduceYourself() ?></p>
        </div>
    </main>

    <footer>Задание для самостоятельной работы "ООП в PHP"</footer>
</body>
</html>