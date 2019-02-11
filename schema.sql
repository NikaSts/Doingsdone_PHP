CREATE DATABASE doingsdone
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
USE doingsdone;
CREATE TABLE users (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  SIGNED_UP TIMESTAMP DEFAULT current_timestamp NOT NULL,
  email     CHAR(128) NOT NULL UNIQUE,
  name      CHAR(64) NOT NULL UNIQUE,
  password  CHAR(64) NOT NULL
);
CREATE TABLE projects (
  id      INT AUTO_INCREMENT PRIMARY KEY,
  name    CHAR(30) NOT NULL UNIQUE,
  user_id INT NOT NULL
);
CREATE TABLE tasks (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  name       CHAR(128) NOT NULL,
  project_id INT,
  now_status ENUM ('0', '1') DEFAULT '0',
  file_link  CHAR,
  time_limit TIMESTAMP,
  is_created DATETIME NOT NULL,
  is_done    DATETIME,
  user_id    INT NOT NULL
);
CREATE INDEX users_signed_up ON users (signed_up);
CREATE UNIQUE INDEX users_email ON users (email);
CREATE UNIQUE INDEX users_name ON users (name);
CREATE INDEX tasks_name ON tasks (name);
CREATE INDEX projects_name ON projects (name);
CREATE INDEX tasks_now_status ON tasks (now_status);
CREATE INDEX tasks_time_limit ON tasks (time_limit);
CREATE INDEX tasks_is_created ON tasks (is_created);
CREATE INDEX tasks_is_done ON tasks (is_done);

