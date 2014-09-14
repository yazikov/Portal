insert into sex(name) values ('Мужской');
insert into sex(name) values ('Женский');

insert into category(name) values ('Красота');
insert into category(name) values ('Здоровье');
insert into category(name) values ('Спорт');

insert into role(name) values('Администратор');
insert into role(name) values('Пользователь');

insert into user(login,password,fio,email,id_sex,id_role) values('admin', 'admin', 'Языков Н.В.','admin@admin.ru', 1,1);