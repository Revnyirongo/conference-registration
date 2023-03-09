CREATE DATABASE IF NOT EXISTS registrations;

USE registrations;

create table clients(
   id INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(100) NOT NULL,
   email VARCHAR(40) NOT NULL,
   phone VARCHAR(100) NOT NULL,
   country VARCHAR(100) NOT NULL,
   message VARCHAR(100) NOT NULL,
   attachment LONGBLOB,
   PRIMARY KEY (id)
);
