INSERT INTO users (email, name, password) VALUES ('costya@mail.ru', 'Константин', 'secret');
INSERT INTO users (email, name, password) VALUES ('petya@mail.ru', 'Петя', 'figa');
INSERT INTO users (email, name, password) VALUES ('sonya@mail.ru', 'Соня', 'dulya');

INSERT INTO projects ( name, author_id) VALUES ('Входящие', 1), ('Учеба', 1), ('Работа', 1), ('Домашние', 1), ('Авто', 1);
INSERT INTO projects ( name, author_id) VALUES ('Входящие', 2), ('Учеба', 2), ('Работа', 2), ('Домашние', 2), ('Авто', 2);
INSERT INTO projects ( name, author_id) VALUES ('Входящие', 3), ('Учеба', 3), ('Работа', 3), ('Домашние', 3), ('Авто', 3);

INSERT INTO tasks (name, date_completion, done, project_id,  author_id) VALUES
('Собеседование в IT компании', '2018-12-01', 0, 3, 1),
('Выполнить тестовое задание', '2018-12-25', 0,  3, 1),
('Сделать задание первого раздела', '2018-12-21', 1,  2, 1),
('Встреча с другом', '2018-12-22', false,  1, 1),
('Купить корм для кота', null, false,  4, 1),
('Заказать пиццу', null, false,  4, 1);

INSERT INTO tasks (name, date_completion, done, project_id,  author_id) VALUES
('Собеседование в IT компании', '2018-12-10', 0, 3, 2),
('Выполнить тестовое задание', '2018-12-26', 0,  3, 2),
('Сделать задание первого раздела', '2018-12-21', 1,  2, 2),
('Встреча с другом', '2018-12-23', false,  1, 2),
('Купить корм для кота', '2018-12-24', false,  4, 2),
('Заказать пиццу', null, false,  4, 2);

INSERT INTO tasks (name, date_completion, done, project_id,  author_id) VALUES
('Собеседование в IT компании', '2018-12-01', 0, 3, 3),
('Выполнить тестовое задание', '2018-12-25', 0,  3, 3),
('Сделать задание первого раздела', '2018-12-21', 1,  2, 3),
('Встреча с другом', '2018-12-22', false,  1, 3),
('Купить корм для кота', null, false,  4, 3),
('Заказать пиццу', '2018-12-26', false,  4, 3);