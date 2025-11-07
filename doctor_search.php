<?php 
include 'config.php';
requireAuth(); 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Поиск врачей - <?php echo $hospital_name; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f5f5f5; }
        .header { background: #2c80b9; color: white; padding: 20px; text-align: center; }
        nav { background: #1a5a8a; padding: 15px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; padding: 10px; }
        nav a:hover { background: #2c80b9; border-radius: 5px; }
        .container { max-width: 1000px; margin: 20px auto; padding: 30px; background: white; border-radius: 10px; }
        .search-form { background: #e3f2fd; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #2c80b9; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #1a5a8a; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #2c80b9; color: white; }
        .warning { background: #fff3cd; color: #856404; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .user-info { background: #e8f5e9; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 <?php echo $hospital_name; ?></h1>
        <p>Поиск врачей</p>
    </div>
 
    <nav>
        <a href="index.php">Главная</a>
        <a href="dashboard.php">Личный кабинет</a>
        <a href="doctor_search.php">Поиск врачей</a>
        <a href="appointments.php">Запись на прием</a>
        <?php if (isAdmin()): ?>
            <a href="patient_search.php">Поиск пациентов</a>
        <?php endif; ?>
        <a href="logout.php" style="color: #ff6b6b;">Выйти</a>
    </nav>
 
    <div class="container">
        <div class="user-info">
            <strong>Пользователь:</strong> <?php echo $_SESSION['username']; ?> 
            | <strong>Роль:</strong> <?php echo $_SESSION['role']; ?>
        </div>
 
        <h2>👨‍⚕️ Поиск врачей</h2>
        <p>Найдите врача по имени или специализации</p>
 
        <div class="search-form">
            <form method="GET" action="">
                <div class="form-group">
                    <label for="search">Имя врача или специализация:</label>
                    <input type="text" id="search" name="search" 
                           value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" 
                           placeholder="Введите имя врача или специализацию">
                </div>
                <button type="submit">Найти врача</button>
            </form>
        </div>
 
        <?php
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            
            echo "<h3>Результаты поиска для: \"" . htmlspecialchars($search) . "\"</h3>";
            
            try {
                $db = getDB();
                
                // sql иъекция
                $query = "SELECT id, name, specialization, room, phone, email FROM doctors WHERE name LIKE '%$search%' OR specialization LIKE '%$search%'";
                
                echo "<div class='warning'>";
                echo "<strong>Выполняемый SQL запрос:</strong><br>";
                echo "<code>$query</code>";
                echo "</div>";
                
                $result = $db->query($query);
                
                if ($result->rowCount() > 0) {
                    echo "<table>";
                    echo "<tr><th>ID</th><th>Имя врача</th><th>Специализация</th><th>Кабинет</th><th>Телефон</th><th>Email</th></tr>";
                    
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['specialization']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['room']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                } else {
                    echo "<p>Врачи не найдены.</p>";
                }
                
            } catch(PDOException $e) {
                echo "<div class='warning'>Ошибка запроса: " . $e->getMessage() . "</div>";
            }
            
            log_action("Поиск врачей: $search", $_SESSION['user_id']);
        }
        ?>
        
    </div>
</body>
</html>
