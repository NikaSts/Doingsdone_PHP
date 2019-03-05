CREATE DATABASE doingsdone
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
USE doingsdone;
CREATE TABLE users
(
  id        INT AUTO_INCREMENT PRIMARY KEY,
  signed_up DATETIME DEFAULT current_timestamp NOT NULL,
  email     CHAR(128)                          NOT NULL UNIQUE,
  name      CHAR(64)                           NOT NULL,
  password  CHAR(64)                           NOT NULL
);
CREATE TABLE projects
(
  id      INT AUTO_INCREMENT PRIMARY KEY,
  name    CHAR(30) NOT NULL,
  user_id INT      NOT NULL
);
CREATE TABLE tasks
(
  id         INT AUTO_INCREMENT PRIMARY KEY,
  name       CHAR(128) NOT NULL,
  project_id INT,
  now_status ENUM ('0', '1') DEFAULT '0',
  file_link  CHAR(255),
  time_limit DATETIME,
  is_created DATETIME DEFAULT current_timestamp NOT NULL,
  is_done    DATETIME,
  user_id    INT       NOT NULL
);
CREATE UNIQUE INDEX users_email ON users (email);
CREATE INDEX projects_name ON projects (name);
CREATE INDEX user_id ON projects (user_id);
CREATE INDEX user_id ON tasks (user_id);
CREATE INDEX tasks_name ON tasks (name);
CREATE INDEX tasks_now_status ON tasks (now_status);
CREATE INDEX tasks_time_limit ON tasks (time_limit);
CREATE INDEX tasks_is_done ON tasks (is_done);

