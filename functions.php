<?php

declare(strict_types=1); // Строгая типезация

// защита от SQL ИНЕКЦИЙ юезопастный ввод
function h(string $s): string
{
    return htmlspecialchars( // Превращает спецсиволы в html сущности
        $s, // исходная строка
        ENT_QUOTES | ENT_SUBSTITUTE, //ЭКРАНИРОВАНИЕ КАВЫЧИК и замена битых символов
        'UTF-8' //Кодировка
    );
}
// Принемаем массив POST, Возвращение массив [errors. cleandata]

// валидация формы
function validate_student(array $data): array
{
    $errors = [];
    // берем full_name если нет то пусто очищаем от пробелов по бокам
    $full_name = trim((string) ($data['full_name'] ?? ''));

    $email = trim((string) ($data['email'] ?? ''));

    $group_name = trim((string) ($data['group_name'] ?? ''));

    $course = trim((string) ($data['course'] ?? ''));



    if ($full_name === "" || mb_strlen($full_name) < 3) {
        $errors['full_name'] = 'Фио должно быть не короче 3 символов';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Не верный email';
    }

    if ($group_name === "" || mb_strlen($group_name) < 2) {
        $errors['group_name'] = 'Группа должна быть не короче 2 символов';
    }

     if ($group_name === "" || mb_strlen($group_name) < 1) {
        $errors['course'] = 'курс должна быть не короче 1 символа';
    }

    return [
        $errors,
        [
            'full_name' => $full_name,
            'email' => $email,
            'group_name' => $group_name,
            'course' => $course,
            
        ]
    ];

}

?>