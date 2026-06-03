<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="/KP_Guseva/style.css">
</head>
<body>

<div class="container">
    <header class="header">
        <div class="header-content">
            <h1><a href="/KP_Guseva/">📖 Книжная полка</a></h1>
            <div class="user-menu">
                <?php if (!empty($user)): ?>
                    <span class="user-name">Привет, <?= htmlspecialchars($user->getNickname()) ?></span>
                    <a href="/KP_Guseva/users/logout" class="logout-btn">Выйти</a>
                <?php else: ?>
                    <a href="/KP_Guseva/users/login" class="login-btn">Вход</a>
                    <a href="/KP_Guseva/users/register" class="register-btn">Регистрация</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="main">