<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход - <?php echo $hospital_name; ?></title>
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
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 <?php echo $hospital_name; ?></h1>
        <p>Вход в систему</p>
    </div>

    <nav>
        <a href="index.php">Главная</a>
        <a href="login.php">Вход</a>
        <a href="register.php">Регистрация</a>
    </nav>

    <div class="container">
        <h2>🔐 Вход в систему</h2>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            try {
                $db = getDB();
                $stmt = $db->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    
                    log_action("Успешный вход пользователя: $username");
                    header("Location: dashboard.php");
                    exit();
                } else {
                    echo '<div class="message error">Неверное имя пользователя или пароль</div>';
                    log_action("Неудачная попытка входа: $username");
                }
            } catch(PDOException $e) {
                echo '<div class="message error">Ошибка входа: ' . $e->getMessage() . '</div>';
            }
        }
        ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Имя пользователя:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Войти</button>
        </form>
        
        <p style="text-align: center; margin-top: 20px;">
            Нет аккаунта? <a href="register.php">Зарегистрируйтесь здесь</a>
        </p>
    </div>
</body>
</html>
