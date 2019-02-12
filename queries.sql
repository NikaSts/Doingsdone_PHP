INSERT INTO users VALUES (NULL, now(), 'babai@mail.ru', 'Babai', '1234abcd');
INSERT INTO users VALUES (NULL, now(), 'grosss@mail.ru', 'Grosss', '54aa31a');
INSERT INTO users VALUES (NULL, now(), 'momentos@mail.ru', 'Momentos', '564738ac');

INSERT INTO projects VALUES (NULL, 'Входящие', 1);
INSERT INTO projects VALUES (NULL, 'Учеба', 1);
INSERT INTO projects VALUES (NULL, 'Работа', 3);
INSERT INTO projects VALUES (NULL, 'Домашние дела', 2);
INSERT INTO projects VALUES (NULL, 'Авто', 3);

INSERT INTO tasks VALUES (NULL, 'Собеседование в IT компании', 3, NULL, NULL, '2019-12-01 23:59:59', now(), NULL, 3);
INSERT INTO tasks VALUES (NULL, 'Выполнить тестовое задание', 3, NULL, NULL, '2019-12-25 23:59:59', now(), NULL, 3);
INSERT INTO tasks VALUES (NULL, 'Сделать задание первого раздела', 2, NULL, NULL, '2019-12-21 23:59:59', now(), NULL, 1);
INSERT INTO tasks VALUES (NULL, 'Встреча с другом', 1, NULL, NULL, '2019-12-22 23:59:59', now(), NULL, 1);
INSERT INTO tasks VALUES (NULL, 'Купить корм для кота', 4, NULL, NULL, NULL, now(), NULL, 2);
INSERT INTO tasks VALUES (NULL, 'Заказать пиццу', 4, NULL, NULL, NULL, now(), NULL, 2);


-- получить список из всех проектов для пользователя Momentos
SELECT * FROM projects WHERE user_id = 3;

-- получить список из всех задач для проекта 'Входящие';
SELECT * FROM tasks WHERE project_id = 1;

-- пометить задачу 'Встреча с другом' как выполненную
UPDATE tasks SET now_status = 1 WHERE id = 4;

-- обновить название задачи 'Купить корм для кота' по её идентификатору
UPDATE tasks SET name = 'Купить диван' WHERE id = 5;
