CREATE DATABASE IF NOT EXISTS hospital_db;
USE hospital_db;
 
-- пользаки
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 
-- врачи
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    room VARCHAR(20),
    phone VARCHAR(20),
    email VARCHAR(100)
);
 
-- пациенты
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    medical_card VARCHAR(20) UNIQUE NOT NULL,
    birth_date DATE,
    diagnosis TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);
 
-- данные
INSERT INTO users (username, password, email, role) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@hospital.local', 'admin'),
('user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user1@mail.com', 'user');
 
-- доп
 
INSERT INTO doctors (name, specialization, room, phone, email) VALUES 
('Доктор Иванов А.В.', 'Терапевт', '101', '+7 (495) 111-11-11', 'ivanov@hospital.local'),
('Доктор Петрова М.С.', 'Хирург', '205', '+7 (495) 222-22-22', 'petrova@hospital.local'),
('Доктор Сидоров П.К.', 'Кардиолог', '156', '+7 (495) 333-33-33', 'sidorov@hospital.local'),
('Доктор Козлова Е.В.', 'Педиатр', '304', '+7 (495) 444-44-44', 'kozlova@hospital.local');
 
INSERT INTO patients (full_name, medical_card, birth_date, diagnosis, created_by) VALUES 
('Иванов Иван Иванович', 'MC-001', '1985-03-15', 'Гипертония', 1),
('Петрова Мария Сергеевна', 'MC-002', '1990-07-22', 'ОРВИ', 1),
('Сидоров Алексей Петрович', 'MC-003', '1978-11-30', 'Гастрит', 1);
