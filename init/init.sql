-- create the databases
CREATE DATABASE IF NOT EXISTS library;

-- create the users for each database
CREATE USER 'user'@'%' IDENTIFIED BY 'pass';
GRANT CREATE, ALTER, INDEX, LOCK TABLES, REFERENCES, UPDATE, DELETE, DROP, SELECT, INSERT ON `library`.* TO 'user'@'%';

FLUSH PRIVILEGES;