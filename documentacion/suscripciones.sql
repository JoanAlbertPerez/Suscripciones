create database suscripcion;

  use suscripcion;

  create table admin (
    id int(24) not null auto_increment,
    nombre varchar(225) not null,
    password varchar(225) not null,
    primary key (id)
  );

  create table usuario  (
    id int(25) not null auto_increment,
    nombre varchar(128) not null,
    apellidos varchar(128) not null,
    estado enum('alta', 'baja') not null,
    dni varchar(9) not null,
    telefono varchar(9) not null,
    fecha_nac date not null,
    ultimo_cobro date,
    primary key (id)
  );

  create table altas_bajas(
    id int(25) not null auto_increment,
    tipo enum('alta', 'baja', 'error') not null,
    mensaje varchar(128),
    usuario_id int(25) not null,
    telefono varchar(9) not null,
    fecha datetime not null,
    primary key (id),
    foreign key (usuario_id) references usuario(id)
  );


  create table cobros(
    id int(25) not null auto_increment,
    tipo enum('si', 'no') not null,
    mensaje varchar(128),
    usuario_id int(25) not null,
    telefono varchar(9) not null,
    primary key (id),
    foreign key (usuario_id) references usuario(id)
  );


  create table sms(
    id int(25) not null auto_increment,
    tipo enum('si', 'no') not null,
    mensaje varchar(128),
    usuario_id int(25) not null,
    telefono varchar(9) not null,
    primary key (id),
    foreign key (usuario_id) references usuario(id)
  );


  create table web_service(
    id int(25) not null auto_increment,
    tipo enum('pet_token', 'pet_sms', 'pet_cobro') not null,
    stat_CODE enum('SUCCESS', 'BAD_REQUEST-TYPE', 'NO_REQUEST', 'SYSTEM_ERROR', 'INVALID_XML', 'MISSING_PROPERTY', 'MISSING_CREDENTIALS', 'INVALID_CREDENTIALS', 'TOKEN_SUCCESS', 'TOKEN_ALREADY_USED', 'INVALID_TOKEN', 'NO_FUNDS', 'CHARGING_ERROR', 'DUPLICATED_TR' ),
    stat_msg varchar(128),
    transaction varchar(128),
    msisdn varchar(9) not null,
    shortcode varchar(3) not null,
    text varchar(255) not null,
    token varchar(255) not null,
    tx_id varchar(25) not null,
    usuario_id int(25) not null,
    primary key (id),
    foreign key (usuario_id) references usuario(id)
  );
