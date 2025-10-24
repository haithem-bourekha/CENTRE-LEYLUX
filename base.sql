CREATE DATABASE training_system;
USE training_system;

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT NOT NULL,
    photo VARCHAR(255),
    audio VARCHAR(255),
    telegram_link VARCHAR(255)
);

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    status ENUM('not_confirmed', 'confirmed', 'refused') DEFAULT 'not_confirmed'
);

CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT,
    course_id INT,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);