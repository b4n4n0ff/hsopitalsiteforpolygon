<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Поиск пациентов - Городская больница №1</title>
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
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #2c80b9; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #1a5a8a; }
        .results { margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #2c80b9; color: white; }
        .debug-panel { background: #fff3cd; padding: 15px; border-radius: 5px; margin-top: 20px; border-left: 4px solid #ffc107; }
        .warning { background: #fff3cd; color: #856404; padding: 10px; border-radius: 5px; margin: 10px 0; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 Городская больница №1</h1>
        <p>Поиск пациентов в базе данных</p>
    </div>

    <nav>
        <a href="index.php">Главная</a>
        <a href="appointments.php">Запись на прием</a>
        <a href="patient_search.php">Поиск пациентов</a>
    </nav>

    <div class="container">
        <h2>🔍 Поиск пациентов</h2>
        <p>Поиск пациентов по ФИО или номеру медицинской карты</p>

        <div class="search-form">
            <form method="GET" action="">
                <div class="form-group">
                    <label for="search_query">ФИО пациента или номер карты:</label>
                    <input type="text" id="search_query" name="search_query" 
                           value="<?php echo htmlspecialchars($_GET['search_query'] ?? ''); ?>" 
                           placeholder="Введите ФИО или номер медицинской карты">
                </div>
                
                <button type="submit">Найти пациента</button>
                
                <!-- Скрытая функция для администраторов -->
                <div style="margin-top: 15px; font-size: 0.9em;">
                    <label>
                        <input type="checkbox" name="debug" value="true" 
                               <?php echo isset($_GET['debug']) ? 'checked' : ''; ?>>
                        Режим отладки (для администраторов)
                    </label>
                </div>
            </form>
        </div>

        <?php
        // Создаем файл с тестовыми данными пациентов если его нет
        if (!file_exists('patient_database.txt')) {
            file_put_contents('patient_database.txt', 
                "Иванов Иван Иванович|MC-001|1985-03-15|Гипертония\n" .
                "Петрова Мария Сергеевна|MC-002|1990-07-22|ОРВИ\n" .
                "Сидоров Алексей Петрович|MC-003|1978-11-30|Гастрит\n"
            );
        }

        if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
            $search_query = $_GET['search_query'];
            $debug_mode = isset($_GET['debug']) && $_GET['debug'] === 'true';

            echo "<div class='results'>";
            echo "<h3>Результаты поиска для: \"" . htmlspecialchars($search_query) . "\"</h3>";

            if ($debug_mode) {
                echo "<div class='warning'>";
                echo "⚠️ <strong>Включен режим отладки</strong> - отображаются системные команды";
                echo "</div>";
                
                echo "<div class='debug-panel'>";
                echo "<h4>🔧 Отладочная информация:</h4>";
                echo "<pre>Выполняемая команда: grep -i \"$search_query\" patient_database.txt</pre>";
                
                // КРИТИЧЕСКАЯ УЯЗВИМОСТЬ - Command Injection
                system("grep -i \"$search_query\" patient_database.txt 2>&1");
                
                echo "</div>";
            } else {
                // Обычный режим поиска
                echo "<table>";
                echo "<tr><th>ФИО</th><th>Номер карты</th><th>Дата рождения</th><th>Диагноз</th></tr>";
                
                // Имитация поиска в базе данных
                $fake_patients = [
                    ["Иванов Иван Иванович", "MC-001", "1985-03-15", "Гипертония"],
                    ["Петрова Мария Сергеевна", "MC-002", "1990-07-22", "ОРВИ"],
                    ["Сидоров Алексей Петрович", "MC-003", "1978-11-30", "Гастрит"]
                ];
                
                $found = false;
                foreach ($fake_patients as $patient) {
                    if (stripos($patient[0], $search_query) !== false || 
                        stripos($patient[1], $search_query) !== false) {
                        echo "<tr>";
                        foreach ($patient as $data) {
                            echo "<td>$data</td>";
                        }
                        echo "</tr>";
                        $found = true;
                    }
                }
                
                if (!$found) {
                    echo "<tr><td colspan='4' style='text-align: center;'>Пациенты не найдены</td></tr>";
                }
                echo "</table>";
            }

            echo "</div>";
        }
        ?>
    </div>
</body>
</html>