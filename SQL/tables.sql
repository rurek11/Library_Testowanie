USE books_db;

CREATE TABLE authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    nationality VARCHAR(100),
    books_written INT DEFAULT 0,
    books_owned INT DEFAULT 0
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author_id INT NOT NULL,
    year INT,
    genre VARCHAR(100),
    FOREIGN KEY (author_id) REFERENCES authors(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);