create database su_sessions;

create table sessions(
id int primary key auto_increment, 
session_id varchar(16) not null, 
content text default '[]' not null
);