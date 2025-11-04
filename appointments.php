<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Запись на прием - Городская больница №1</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f5f5f5; }
        .header { background: #2c80b9; color: white; padding: 20px; text-align: center; }
        nav { background: #1a5a8a; padding: 15px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; padding: 10px; }
        nav a:hover { background: #2c80b9; border-radius: 5px; }
        .container { max-width: 800px; margin: 20px auto; padding: 30px; background: white; border-radius: 10px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #2c80b9; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #1a5a8a; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 Городская больница №1</h1>
        <p>Запись на прием к врачу</p>
    </div>

    <nav>
        <a href="index.php">Главная</a>
        <a href="appointments.php">Запись на прием</a>
        <a href="patient_search.php">Поиск пациентов</a>
    </nav>

    <div class="container">
        <h2>📅 Запись на прием</h2>
        <p>Заполните форму для записи на прием к специалисту</p>

        <form method="POST" action="">
            <div class="form-group">
                <label for="fullname">ФИО пациента:</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>

            <div class="form-group">
                <label for="birthdate">Дата рождения:</label>
                <input type="date" id="birthdate" name="birthdate" required>
            </div>

            <div class="form-group">
                <label for="phone">Телефон:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="doctor">Выбор врача:</label>
                <select id="doctor" name="doctor" required>
                    <option value="">-- Выберите специалиста --</option>
                    <option value="therapist">Терапевт</option>
                    <option value="surgeon">Хирург</option>
                    <option value="pediatrician">Педиатр</option>
                    <option value="dentist">Стоматолог</option>
                    <option value="cardiologist">Кардиолог</option>
                </select>
            </div>

            <div class="form-group">
                <label for="date">Желаемая дата приема:</label>
                <input type="date" id="date" name="date" required>
            </div>

            <div class="form-group">
                <label for="symptoms">Жалобы/симптомы:</label>
                <textarea id="symptoms" name="symptoms" rows="4"></textarea>
            </div>

            <button type="submit">Записаться на прием</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'];
            $birthdate = $_POST['birthdate'];
            $phone = $_POST['phone'];
            $doctor = $_POST['doctor'];
            $date = $_POST['date'];
            $symptoms = $_POST['symptoms'];

            echo "<div class='success'>";
            echo "<h3>✅ Запись успешно оформлена!</h3>";
            echo "<p><strong>Пациент:</strong> $fullname</p>";
            echo "<p><strong>Врач:</strong> $doctor</p>";
            echo "<p><strong>Дата приема:</strong> $date</p>";
            echo "<p>Наш администратор свяжется с вами для подтверждения записи.</p>";
            echo "</div>";

            // Логируем запись
            $log_entry = date('Y-m-d H:i:s') . " | Запись: $fullname | Врач: $doctor | Дата: $date\n";
            file_put_contents('appointments.log', $log_entry, FILE_APPEND);
        }
        ?>
    </div>
</body>
</html>