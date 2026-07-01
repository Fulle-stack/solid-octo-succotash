<?php

declare(strict_types=1); // Строгая типезация

require __DIR__ . '/bd.php';
require __DIR__ . '/functions.php';

$errors = [];
$massage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка на загруску файла и наличие ошибок
    if (!isset($_FILES['csv']) || $_FILES['csv']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Файл не загружен';
    } else {
        $tmp = $_FILES['csv']['tmp_name'];
        $fp = fopen($tmp, 'r');

        if (!$fp) {
            $errors[] = 'Не удалось открыть файл';
        } else {
            $pdo->beginTransaction();
            try {
                $header = fgetcsv($fp);
                if (!$header || count($header) < 4) {
                    throw new RuntimeException('Неверный формат scv не верный формат или мало колонок');
                }

                $insert = $pdo->prepare('
                    INSERT INTO student(full_name, email, group_name, course)
                    VALUES (:full_name, :email, :group_name, :course)
                    ON DUPLICATE KEY UPDATE
                        full_name = VALUES(full_name),
                        group_name = VALUES(group_name),
                        course = VALUES(course)
                ');



                $count = 0;

                while (($row = fgetcsv($fp)) !== false) {
                    $row = array_map('trim', $row);
                    if (count($row) < 4) {
                        continue;
                    }

                    [$full_name, $email, $group_name, $course] = $row;

                    [$valErrors, $clean] = validate_student([
                        'full_name' => $full_name,
                        'email' => $email,
                        'group_name' => $group_name,
                        'course' => $course
                    ]);



                    if ($valErrors) {
                        continue;
                    }

                    $insert->execute($clean);
                    $count++;
                }

                $pdo->commit();
                $massage = "Импорт успешно завершон Добавлено строк {$count}";
            } catch (Throwable $e) {
                $pdo->rollBack();
                $errors[] = $e->getMessage();
            } finally {
                fclose($fp);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Импорт CSV</title>
    <link rel="stylesheet" href="import-file.css">
</head>

<body>
    <div class="container">
        <h1>Импорт CSV</h1>
        <div class="block_btn">
            <p><a class="back_btn" href="index.php">
                    < Назад</a>
            </p>
        </div>

        <?php if ($massage): ?>
            <div style="color:green;"><?= h($massage) ?></div>
        <?php endif; ?>

        <?php foreach ($errors as $e): ?>
            <div style="color:red;"><?= h($e) ?></div>
        <?php endforeach; ?>

        <p class="text_prompt">Формат CSV: <code>full_name, email, group_name, course</code></p>

        <form action="" method="post" enctype="multipart/form-data" class="form-file">
            <label for="file-upload" class="custom-file-upload">
                <i class="fa-cloud-upload"><img class="img_download" src="download_32px_ffffff.svg"
                        alt="download"></i>Выберите файл
            </label>
            <input class="file-input" id="file-upload" type="file" name="csv" accept=".csv,text/csv"
                style="display: none;">
            <button class="back_btn-1" type="submit">Загрузить</button>
        </form>
    </div>
    <script src="script.js"></script>
</body>

</html>