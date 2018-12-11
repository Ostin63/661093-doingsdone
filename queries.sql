INSERT INTO users (email, name, password, token) VALUES ('costya@mail.ru', 'Константин', 'secret', "");
INSERT INTO users (email, name, password, token) VALUES ('petya@mail.ru', 'Петя', 'figa', "");
INSERT INTO users (email, name, password, token) VALUES ('sonya@mail.ru', 'Соня', 'Соня', "");

INSERT INTO projects ( name, author_id) VALUES ('Входящие', 1), ('Учеба', 1), ('Работа', 1), ('Домашние', 1), ('Авто', 1);
INSERT INTO projects ( name, author_id) VALUES ('Входящие', 2), ('Учеба', 2), ('Работа', 2), ('Домашние', 2), ('Авто', 2);
INSERT INTO projects ( name, author_id) VALUES ('Входящие', 3), ('Учеба', 3), ('Работа', 3), ('Домашние', 3), ('Авто', 3);

INSERT INTO tasks (name, date_completion, done, project_id) VALUES
('Собеседование в IT компании', '2018-12-01', 0, 3),
('Выполнить тестовое задание', '2018-12-25', 0,  3),
('Сделать задание первого раздела', '2018-12-21', 1,  2),
('Встреча с другом', '2018-12-22', false,  1),
('Купить корм для кота', null, false,  4),
('Заказать пиццу', null, false,  4);

INSERT INTO tasks (name, date_completion, done, project_id) VALUES
('Собеседование в IT компании', '2018-12-10', 0, 8),
('Выполнить тестовое задание', '2018-12-26', 0,  8),
('Сделать задание первого раздела', '2018-12-21', 1,  7),
('Встреча с другом', '2018-12-23', false,  6),
('Купить корм для кота', '2018-12-24', false,  9),
('Заказать пиццу', null, false,  9);

INSERT INTO tasks (name, date_completion, done, project_id) VALUES
('Собеседование в IT компании', '2018-12-01', 0, 13),
('Выполнить тестовое задание', '2018-12-25', 0,  13),
('Сделать задание первого раздела', '2018-12-21', 1,  12),
('Встреча с другом', '2018-12-22', false,  11),
('Купить корм для кота', null, false,  14),
('Заказать пиццу', '2018-12-26', false,  14);

//получить список из всех проектов для одного пользователя
SELECT *  FROM projects WHERE  author_id = 1

//получить список из всех задач для одного проекта
SELECT *  FROM tasks WHERE  project_id = 3

//пометить задачу как выполненную
UPDATE tasks SET done = 1 WHERE id = 2

//получить все задачи для завтрашнего дня
SELECT *  FROM tasks WHERE date_completion BETWEEN '2018-11-28' AND '2018-11-29'

//обновить название задачи по её идентификатору
UPDATE tasks SET name = 'Купить кота' WHERE id = 4
