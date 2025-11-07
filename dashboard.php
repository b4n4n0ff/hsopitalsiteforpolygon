<?php 
include 'config.php';
requireAuth();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет - <?php echo $hospital_name; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f5f5f5; }
        .header { background: #2c80b9; color: white; padding: 20px; text-align: center; }
        nav { background: #1a5a8a; padding: 15px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; padding: 10px; }
        nav a:hover { background: #2c80b9; border-radius: 5px; }
        .container { max-width: 1000px; margin: 20px auto; padding: 30px; background: white; border-radius: 10px; }
        .user-info { background: #e8f5e9; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .admin-panel { background: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 <?php echo $hospital_name; ?></h1>
        <p>Личный кабинет</p>
    </div>

    <nav>
        <a href="index.php">Главная</a>
        <a href="dashboard.php">Личный кабинет</a>
        <a href="appointments.php">Запись на прием</a>
        <a href="doctor_search.php">Поиск врачей</a>
        <?php if (isAdmin()): ?>
            <a href="patient_search.php">Поиск пациентов</a>
        <?php endif; ?>
        <a href="logout.php" style="color: #ff6b6b;">Выйти</a>
    </nav>

    <div class="container">
        <div class="user-info">
            <h2>👋 Добро пожаловать, <?php echo $_SESSION['username']; ?>!</h2>
            <p>Ваша роль: <strong><?php echo $_SESSION['role']; ?></strong></p>
        </div>
        
        <?php if (isAdmin()): ?>
            <div class="admin-panel">
    		<h3>⚙️ Панель администратора</h3>
    		<p>У вас есть доступ к специальным функциям:</p>
    		<ul>
        	    <li><a href="patient_search.php">🔍 Поиск пациентов</a> - с расширенной диагностикой</li>
    		</ul>
	    </div>
        <?php else: ?>
            <div style="background: #e3f2fd; padding: 15px; border-radius: 8px;">
                <h3>ℹ️ Обычный пользователь</h3>
                <p>Вы можете записываться на прием и просматривать основную информацию.</p>
                <p>Для доступа к расширенным функциям обратитесь к администратору.</p>
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 30px;">
            <h3>📋 Доступные действия:</h3>
            <ul>
                <li><a href="appointments.php">📅 Запись на прием</a></li>
                <?php if (isAdmin()): ?>
                    <li><a href="patient_search.php">🔍 Поиск пациентов (только для admin)</a></li>
                    <li><a href="vulnerable_search.php">👥 Поиск пользователей (только для admin)</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>
</html>
