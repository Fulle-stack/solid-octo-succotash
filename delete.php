<?php

declare(strict_types=1); // Строгая типезация

// Эти строки подключают файлы с настройками базы данных
require __DIR__.'/bd.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    exit('Неверный ID');
}

$stmt = $pdo->prepare("DELETE FROM student WHERE id=:id");
$stmt->execute(["id" => $id]);

header('Location: index.php');

exit;
?>