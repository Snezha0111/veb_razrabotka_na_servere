<?php
class Lesson
{
    protected string $title;
    protected string $text;
    protected string $homework;

    public function __construct(string $title, string $text, string $homework)
    {
        $this->title = $title;
        $this->text = $text;
        $this->homework = $homework;
    }
}

class PaidLesson extends Lesson
{
    private float $price;

    public function __construct(string $title, string $text, string $homework, float $price)
    {
        parent::__construct($title, $text, $homework);
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}

$paidLesson = new PaidLesson(
    'Урок о наследовании в PHP',
    'Лол, кек, чебурек',
    'Ложитесь спать, утро вечера мудренее',
    99.90
);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PaidLesson</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="Logo_Polytech_rus_main.jpg" alt="Логотип">
        <p>Лабораторная работа №6 - Наследование</p>
    </header>

    <main>
        <div class="task-block">
            <p class="name_task">Класс PaidLesson</p>
            <p>Создан объект PaidLesson:</p>
            <pre><?php var_dump($paidLesson); ?></pre>
        </div>
    </main>

    <footer>Задание для самостоятельной работы "ООП в PHP"</footer>
</body>
</html>