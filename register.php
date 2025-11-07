<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация - <?php echo $hospital_name; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f5f5f5; }
        .header { background: #2c80b9; color: white; padding: 20px; text-align: center; }
        nav { background: #1a5a8a; padding: 15px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; padding: 10px; }
        nav a:hover { background: #2c80b9; border-radius: 5px; }
        .container { max-width: 500px; margin: 20px auto; padding: 30px; background: white; border-radius: 10px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #2c80b9; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; width: 100%; }
        button:hover { background: #1a5a8a; }
        .message { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 <?php echo $hospital_name; ?></h1>
        <p>Регистрация нового пользователя</p>
    </div>

    <nav>
        <a href="index.php">Главная</a>
        <a href="login.php">Вход</a>
        <a href="register.php">Регистрация</a>
    </nav>

    <div class="container">
        <h2>📝 Регистрация</h2>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $email = trim($_POST['email']);
            
            if (empty($username) || empty($password)) {
                echo '<div class="message error">Заполните все обязательные поля</div>';
            } else {
                try {
                    $db = getDB();
                    
                    // проверка сущ пользователяч
                    $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
                    $stmt->execute([$username]);
                    
                    if ($stmt->fetch()) {
                        echo '<div class="message error">Пользователь с таким именем уже существует</div>';
                    } else {
                        // хеширование пароля
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        
                        // само создание пользователя
                        $stmt = $db->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
                        $stmt->execute([$username, $hashed_password, $email]);
                        
                        echo '<div class="message success">✅ Регистрация успешна! <a href="login.php">Войдите в систему</a></div>';
                        log_action("Зарегистрирован новый пользователь: $username");
                    }
                } catch(PDOException $e) {
                    echo '<div class="message error">Ошибка регистрации: ' . $e->getMessage() . '</div>';
                }
            }
        }
        ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Имя пользователя *:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>
            
            <div class="form-group">
                <label for="password">Пароль *:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Зарегистрироваться</button>
        </form>
        
        <p style="text-align: center; margin-top: 20px;">
            Уже есть аккаунт? <a href="login.php">Войдите здесь</a>
        </p>
    </div>
</body>
</html>
