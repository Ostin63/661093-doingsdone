INSERT INTO users (email, name, password) VALUES ('costya@mail.ru', 'Константин', 'secret');

INSERT INTO projects ( name, author_id) VALUES ('Входящие', 1), ('Учеба', 1), ('Работа', 1), ('Домашние', 1), ('Авто', 1);

INSERT INTO tasks (name, date_completion, done, project_id,  author_id) VALUES
('Собеседование в IT компании', '2018-12-01', 0, 3, 1),
('Выполнить тестовое задание', '2018-12-25', 0,  3, 1),
('Сделать задание первого раздела', '2018-12-21', 1,  2, 1),
('Встреча с другом', '2018-12-22', false,  1, 1),
('Купить корм для кота', null, false,  4, 1),
('Заказать пиццу', null, false,  4, 1);