CREATE USER 'kiara'@'localhost' IDENTIFIED BY 'k6RLi5oKgfO6nwGY';
GRANT USAGE ON *.* TO 'kiara'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `kiara`.* TO 'kiara'@'localhost';
FLUSH PRIVILEGES;
