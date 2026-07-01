<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="Log.css">
</head>
<body>
    <?php
    // Подключение к БД
    $conn = new mysqli("localhost", "root", "", "demo_admin");
    
    // Проверка подключения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // Получаем данные из формы - используем имя поля из формы
        $email = $_POST["email"]; // Используем "email" как указано в форме
        $password_input = $_POST["password"] ?? '';
        
        // Проверяем, что поля не пустые
        if(empty($email) || empty($password_input)) {
            $error_message = "Все поля обязательны для заполнения!";
        } else {
            // Хешируем пароль
            $password_hash = password_hash($password_input, PASSWORD_DEFAULT);
            
            // Подготавливаем запрос
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            if ($stmt) {
                $stmt->bind_param("ss", $email, $password_hash);
                // Отправляет SQL-запрос на выполнение в MySQL
                if($stmt->execute()) {
                    // Регистрация успешна
                    $_SESSION['success_message'] = 'Регистрация прошла успешно!';
                    header('Location: login.php');
                    exit;
                } else {
                    $error_message = "Ошибка при регистрации: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $error_message = "Ошибка подготовки запроса: " . $conn->error;
            }
        }
    }
    
    // Закрываем соединение
    $conn->close();
    ?>
    
    <div class="container">
        <div class="separation">
            <div class="gap_space">
                <div class="sign-up_block">
                    <div class="sing-up">Регистрация</div>
                </div>
                
                <div class="justify_input">
                    <div class="input_block">
                        <!-- Вывод ошибок, если есть -->
                        <?php if(isset($error_message)): ?>
                            <div style="color: red; text-align: center; padding: 10px; background: #ffe6e6; border-radius: 5px; margin-bottom: 15px;">
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form class="input_block" method="POST" action="">
                            <!-- Поле для email - имя "username" как в оригинале -->
                            <input class="input_field" type="email" name="email" placeholder="Email" required>
                            
                            <!-- Поле для пароля -->
                            <input class="input_field" type="password" name="password" placeholder="Пароль" required>
                            
                            <div class="btn_sing">
                                <button type="submit" class="btn-signup">Регистрация</button>
                            </div>
                            <div class="line"></div>
                        </form>
                        
                        <div class="googl_sing">
                            <a class="googl_link" href="#">
                                <img src="sing-img/Google.svg" alt="">
                                Войти через Google
                            </a>
                        </div>
                        <div class="googl_sing">
                            <a class="googl_link" href="#">
                                <img src="sing-img/Facebook.svg" alt="">
                                Войти через Facebook
                            </a>
                        </div>
                        <div class="googl_sing">
                            <a class="googl_link" href="#">
                                <img src="sing-img/Apple.svg" alt="">
                                Войти через Apple
                            </a>
                        </div>
                        <div class="end_block">
                            Уже есть аккаунт?
                            <a class='log_in' href='login.php'>Войти</a>
                        </div>
                    </div>
                </div>
                
                <div class="footer">© 2026 Relume</div>
            </div>
        </div>
    </div>
</body>
</html>