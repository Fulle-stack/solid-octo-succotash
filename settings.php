<?php
declare(strict_types=1);

require __DIR__ . '/bd.php';
require __DIR__ . '/functions.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$errors = [];
$success = '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: logout.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Валидация email
    if (empty($email)) {
        $errors['email'] = 'Email обязателен';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Некорректный email';
    }

    // Проверяем, не занят ли email другим пользователем
    if (empty($errors['email'])) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
        $stmt->execute(['email' => $email, 'id' => $user_id]); // Исправлено здесь
        if ($stmt->fetch()) {
            $errors['email'] = 'Этот email уже используется';
        }
    }

    // Флаг изменения пароля
    $password_changed = false;
    
    // Если пользователь хочет изменить пароль
    if (!empty($new_password)) {
        $password_changed = true;
        
        if (empty($current_password)) {
            $errors['current_password'] = 'Введите текущий пароль';
        } elseif (!password_verify($current_password, $user['password'])) {
            $errors['current_password'] = 'Неверный текущий пароль';
        }

        if (strlen($new_password) < 3) {
            $errors['new_password'] = 'Пароль должен быть не менее 3 символов';
        } elseif ($new_password !== $confirm_password) {
            $errors['confirm_password'] = 'Пароли не совпадают';
        }
    }

    // Если нет ошибок, обновляем данные
    if (empty($errors)) {
        try {
            // Если указан новый пароль, обновляем email и пароль
            if ($password_changed) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET email = :email, password = :password WHERE id = :id");
                $stmt->execute([
                    'email' => $email, 
                    'password' => $hashed_password, 
                    'id' => $user_id
                ]);
            } else {
                // Обновляем только email (если он изменился)
                if ($email !== $user['email']) {
                    $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = :id");
                    $stmt->execute([
                        'email' => $email, 
                        'id' => $user_id
                    ]);
                }
            }

            $success = 'Настройки успешно сохранены!';
            $user['email'] = $email;

        } catch (PDOException $e) {
            $errors['common'] = 'Ошибка при сохранении: ' . $e->getMessage();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки</title>
    <link rel="stylesheet" href="settings.css">
</head>

<body>
    <div class="container">

        <div class="separation">
            <div class="gap_space">
                <div class="sign-up_block">
                    <div class="sing-up">Настройки</div>
                </div>

                <div class="justify_input">
                    <div class="input_block">
                        <form class="input_block" method="post">

                            <?php if ($success): ?>
                                <div class="success"><?= htmlspecialchars($success) ?></div>
                            <?php endif; ?>

                            <?php if (!empty($errors['common'])): ?>
                                <div class="error"><?= htmlspecialchars($errors['common']) ?></div>
                            <?php endif; ?>

                            <input class="input_field" type="email" name="email" placeholder="Почта" required />
                            <input class="input_field" type="password" name="current_password"
                                placeholder="Текущий пароль" />
                            <?php if (!empty($errors['current_password'])): ?>
                                <div class="error"><?= htmlspecialchars($errors['current_password']) ?></div>
                            <?php endif; ?>
                            <input class="input_field" type="password" name="new_password" placeholder="Новый пароль"
                                required />
                            <?php if (!empty($errors['new_password'])): ?>
                                <div class="error"><?= htmlspecialchars($errors['new_password']) ?></div>
                            <?php endif; ?>
                            <input class="input_field" type="password" name="confirm_password"
                                placeholder="Подтвердите новый пароль" required>
                            <?php if (!empty($errors['confirm_password'])): ?>
                                <div class="error"><?= htmlspecialchars($errors['confirm_password']) ?></div>
                            <?php endif; ?>

                            <button class="btn-signup" type="submit" class="btn">Сохранить изменения</button>

                            <div class="line"></div>
                        </form>

                        <div class="end_block">
                            <a href="user.php" class="back-link">← Вернуться на главную</a>
                        </div>
                    </div>
                </div>
                <div class="footer">© 2026 Relume</div>
            </div>
        </div>
    </div>
</body>

</html>