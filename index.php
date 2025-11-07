<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Городская больница №1</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f5f5f5; }
        .header { background: #2c80b9; color: white; padding: 20px; text-align: center; }
        nav { background: #1a5a8a; padding: 15px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; padding: 10px; }
        nav a:hover { background: #2c80b9; border-radius: 5px; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background: white; border-radius: 10px; }
        .emergency { background: #ffebee; border-left: 4px solid #f44336; padding: 15px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 Городская больница №1</h1>
        <p>Мы заботимся о вашем здоровье</p>
    </div>

    <nav>
        <a href="index.php">Главная</a>
        <a href="login.php">Вход</a>
        <a href="register.php">Регистрация</a>
    </nav>

    <div class="container">
        <h2>Добро пожаловать в нашу больницу</h2>
        
        <div class="emergency">
            <strong>📞 Скорая помощь: 103</strong>
            <p>Круглосуточная экстренная медицинская помощь</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 30px;">
            <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
                <h3>🕒 Режим работы</h3>
                <p><strong>Поликлиника:</strong> 8:00 - 20:00</p>
                <p><strong>Стационар:</strong> круглосуточно</p>
                <p><strong>Регистратура:</strong> 8:00 - 18:00</p>
            </div>

            <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
                <h3>📋 Услуги</h3>
                <ul>
                    <li>Терапия</li>
                    <li>Хирургия</li>
                    <li>Педиатрия</li>
                    <li>Стоматология</li>
                    <li>Диагностика</li>
                </ul>
            </div>
        </div>

        <div style="margin-top: 30px; background: #e8f5e9; padding: 20px; border-radius: 8px;">
            <h3>👨‍⚕️ Наши врачи</h3>
            <p>В нашей больнице работают высококвалифицированные специалисты с многолетним опытом работы.</p>
        </div>
    </div>
</body>
</html>
