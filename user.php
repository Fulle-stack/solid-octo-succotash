<?php
declare(strict_types=1);

session_start();

// Проверяет, существует ли в сессии переменная user_id
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Проверка авторизации
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    header('Location: index.php');
    exit;
}

// 3. Подключаемся к базе данных
require __DIR__ . '/bd.php';

// 4. Получаем email пользователя из сессии
$user_email = $_SESSION['email'] ?? '';

// 5. Ищем студента по этому email
$student_data = null;

if (!empty($user_email)) {
    try {
        // Подготовленный запрос для безопасности
        $stmt = $pdo->prepare("SELECT * FROM student WHERE email = ? LIMIT 1");
        $stmt->execute([$user_email]);
        $student_data = $stmt->fetch();
    } catch (Exception $e) {
        // Если ошибка - можно записать в лог
        error_log("Ошибка при поиске студента: " . $e->getMessage());
    }
}

// 6. Получаем имя для приветствия
$user_name = 'Пользователь';
if ($student_data && isset($student_data['full_name'])) {
    $user_name = $student_data['full_name'];
} elseif (isset($_SESSION['email'])) {
    $user_name = $_SESSION['email'];
}

// 7. Получаем долги студента
$debts = [];

// Проверяем: есть ли данные студента?
if ($student_data && isset($student_data['id'])) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM debt WHERE student_id = ? ORDER BY created_at DESC");
        $stmt->execute([$student_data['id']]);
        $debts = $stmt->fetchAll();
    } catch (Exception $e) {
        error_log("Ошибка при получении долгов: " . $e->getMessage());
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользовательская панель</title>
    <link rel="stylesheet" href="user.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Личный кабинет студента</h1>
            <div class="user-info">
                <div class="user-name">
                    Здравствуйте, <?= htmlspecialchars($user_name) ?>
                </div>
                <div class="button_out">
                    <a class="btn-logout" href="logout.php" class="btn-logout">Выход</a>
                    <a class="btn-logout" href="settings.php" class="btn-logout"><svg xmlns="http://www.w3.org/2000/svg"
                            width="32" height="32" viewBox="0 0 32 32">
                            <path fill="currentColor"
                                d="M27 16.76v-1.53l1.92-1.68A2 2 0 0 0 29.3 11l-2.36-4a2 2 0 0 0-1.73-1a2 2 0 0 0-.64.1l-2.43.82a11.35 11.35 0 0 0-1.31-.75l-.51-2.52a2 2 0 0 0-2-1.61h-4.68a2 2 0 0 0-2 1.61l-.51 2.52a11.48 11.48 0 0 0-1.32.75l-2.38-.86A2 2 0 0 0 6.79 6a2 2 0 0 0-1.73 1L2.7 11a2 2 0 0 0 .41 2.51L5 15.24v1.53l-1.89 1.68A2 2 0 0 0 2.7 21l2.36 4a2 2 0 0 0 1.73 1a2 2 0 0 0 .64-.1l2.43-.82a11.35 11.35 0 0 0 1.31.75l.51 2.52a2 2 0 0 0 2 1.61h4.72a2 2 0 0 0 2-1.61l.51-2.52a11.48 11.48 0 0 0 1.32-.75l2.42.82a2 2 0 0 0 .64.1a2 2 0 0 0 1.73-1l2.28-4a2 2 0 0 0-.41-2.51ZM25.21 24l-3.43-1.16a8.86 8.86 0 0 1-2.71 1.57L18.36 28h-4.72l-.71-3.55a9.36 9.36 0 0 1-2.7-1.57L6.79 24l-2.36-4l2.72-2.4a8.9 8.9 0 0 1 0-3.13L4.43 12l2.36-4l3.43 1.16a8.86 8.86 0 0 1 2.71-1.57L13.64 4h4.72l.71 3.55a9.36 9.36 0 0 1 2.7 1.57L25.21 8l2.36 4l-2.72 2.4a8.9 8.9 0 0 1 0 3.13L27.57 20Z" />
                            <path fill="currentColor"
                                d="M16 22a6 6 0 1 1 6-6a5.94 5.94 0 0 1-6 6Zm0-10a3.91 3.91 0 0 0-4 4a3.91 3.91 0 0 0 4 4a3.91 3.91 0 0 0 4-4a3.91 3.91 0 0 0-4-4Z" />
                        </svg>Настройки </a>
                </div>
            </div>
        </div>

        <div class="welcome-section">
            <h2 class="welcome-title">Добро пожаловать!</h2>
            <?php
            if ($student_data) {
                ?>
                <div class="cards">
                    <div class="card_block" data-id="<?= htmlspecialchars((string) $student_data['id']) ?>">
                        <div class="card__element"><img class="avatar__img" src="admin-img/avatar.png" alt=""></div>
                        <div class="card__element">id <?= htmlspecialchars((string) $student_data['id']) ?></div>
                        <div class="card__element">ФИО <?= htmlspecialchars($student_data['full_name']) ?></div>
                        <div class="card__element">Email <?= htmlspecialchars($student_data['email']) ?></div>
                        <div class="card__element">Группа <?= htmlspecialchars($student_data['group_name']) ?></div>
                        <div class="card__element">Курс <?= htmlspecialchars((string) $student_data['course']) ?></div>
                        <div class="card__element">Создан <?= htmlspecialchars($student_data['created_at']) ?></div>

                        <button class="edit-btn" onclick="openDebtModal()">Задолженности
                            <?php if (!empty($debts)): ?>
                                <span class="debt-count"><?= count($debts) ?></span>
                            <?php endif; ?>
                        </button>
                    </div>

                </div>
                <?php
            } else {
                ?>
                <!-- Сообщение если карточка не найдена -->
                <div class="no-card-message">
                    <h3>Карточка студента не найдена</h3>
                    <p>Ваш аккаунт не привязан к карточке студента.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div id="debtModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-modal" onclick="closeDebtModal()">&times;</span>
            <h2>Мои задолженности</h2>

            <?php if (!empty($debts)): ?>
                <div class="debts-list">
                    <?php foreach ($debts as $debt): ?>
                        <div class="debt-item 
                <?php
                if ($debt['status'] === 'не сдана')  // Проверяем: статус равен "не сдана"?
                    echo 'status-not-passed'; // Если ДА - выводим этот класс
                elseif ($debt['status'] === 'в процессе')
                    echo 'status-in-process'; // Если НЕТ, проверяем: статус "в процессе"?
                else
                    echo 'status-fixed';
                ?>">

                            <div class="debt-header">
                                <h3><?= htmlspecialchars($debt['subject_name']) ?></h3>
                                <span class="debt-type"><?= htmlspecialchars($debt['debt_type']) ?></span>
                            </div>

                            <div class="debt-details">
                                <div class="debt-info">
                                    <span class="label">Семестр:</span>
                                    <span class="value"><?= htmlspecialchars((string) $debt['semester'] ?? '-') ?></span>
                                </div>

                                <div class="debt-info">
                                    <span class="label">Статус:</span>
                                    <span class="status-badge 
                            <?php
                            if ($debt['status'] === 'не сдана')
                                echo 'badge-danger';
                            elseif ($debt['status'] === 'в процессе')
                                echo 'badge-warning';
                            else
                                echo 'badge-success';
                            ?>">
                                        <?= htmlspecialchars($debt['status']) ?>
                                    </span>
                                </div>

                                <div class="debt-info">
                                    <span class="label">Дата создания:</span>
                                    <span class="value"><?= htmlspecialchars($debt['created_at']) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-debts">
                    <p>У вас нет задолженностей! 🎉</p>
                </div>
            <?php endif; ?>

            <div class="modal-footer">
                <button class="btn-close" onclick="closeDebtModal()">Закрыть</button>
            </div>
        </div>
    </div>

    <script src="modal.js"></script>
</body>

</html>