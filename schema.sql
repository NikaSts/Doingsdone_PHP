CREATE DATABASE doingsdone
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
USE doingsdone;
CREATE TABLE users (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  signed_up TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email     CHAR(128) NOT NULL UNIQUE,
  name      CHAR(64)  NOT NULL UNIQUE,
  password  CHAR(64)  NOT NULL
);
CREATE TABLE projects (
  id      INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT
);
CREATE TABLE tasks (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  name       CHAR(128) NOT NULL,
  project_id INT,
  now_status TINYINT   DEFAULT 0,
  file_link  CHAR(128),
  time_limit TIMESTAMP,
  is_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  is_done    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  user_id    INT
);
