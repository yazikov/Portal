create table sex(
    id int(11) AUTO_INCREMENT,
    name varchar(512) NOT NULL,
    PRIMARY KEY(id)
);
create table image(
    id int(11) AUTO_INCREMENT,
    name varchar(512) NOT NULL,
    PRIMARY KEY(id)
);
create table category(
    id int(11) AUTO_INCREMENT,
    name varchar(512) NOT NULL,
    PRIMARY KEY(id)
);
create table role(
    id int(11) AUTO_INCREMENT,
    name varchar(512) NOT NULL,
    PRIMARY KEY(id)
);
create table service(
    id int(11) AUTO_INCREMENT,
    name varchar(512) NOT NULL,
    PRIMARY KEY(id)
);
create table user(
  id int(11) AUTO_INCREMENT,
  login varchar(64) NOT NULL,
  password varchar(32) NOT NULL,
  fio varchar(128) NOT NULL,
  work varchar(256),
  email varchar(512) NOT NULL,
  id_sex int(11) NOT NULL,
  birthday date,
  about varchar(1024),
  id_image int(11),
  id_role int(11),
  PRIMARY KEY(id),
  FOREIGN KEY(id_sex) REFERENCES sex(id),
  FOREIGN KEY(id_image) REFERENCES image(id),
  FOREIGN KEY(id_role) REFERENCES role(id)
);
create table text(
  id int(11) AUTO_INCREMENT,
  title varchar(256),
  short_text varchar(2048),
  text text NOT NULL,
  id_user int(11),
  meta_description varchar(1024),
  meta_tag varchar(1024),
  checked bool,
  id_category int(11) NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(id_user) REFERENCES user(id),
  FOREIGN KEY(id_category) REFERENCES category(id)
);
create table firm (
  id int(11) auto_increment,
  name varchar(256) not null ,
  id_service int(11) not null ,
  phone varchar(11),
  site varchar(256),
  address varchar(512),
  map varchar(2048),
  primary key(id),
  foreign key(id_service) references service(id)
);
create table comment(
  id int(11) auto_increment,
  text varchar(4096) not null ,
  id_user int(11) not null ,
  primary key(id),
  foreign key(id_user) references user(id)
);
create table firm_galary(
  id int(11) auto_increment,
  id_firm int(11) not null,
  id_image int(11) not null,
  ord int(8),
  primary key(id),
  foreign key(id_firm) references firm(id),
  foreign key(id_image) references image(id)
);
create table text_galary(
  id int(11) auto_increment,
  id_text int(11) not null,
  id_image int(11) not null,
  ord int(8),
  primary key(id),
  foreign key(id_text) references text(id),
  foreign key(id_image) references image(id)
);
create table text_comment(
  id int(11) auto_increment,
  id_text int(11) not null,
  id_comment int(11) not null,
  id_parent_comment int(11),
  primary key(id),
  foreign key(id_text) references text(id),
  foreign key(id_comment) references comment(id),
  foreign key(id_parent_comment) references comment(id)
);
create table text_like(
  id int(11) auto_increment,
  id_text int(11) not null,
  id_user int(11) not null,
  primary key(id),
  foreign key(id_text) references text(id),
  foreign key(id_user) references user(id)
);