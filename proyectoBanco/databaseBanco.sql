drop database databaseBanco;
create database databaseBanco;
use databaseBanco;
create table cliente(
    id_cliente integer(16) auto_increment,
    id_cajaDeAhorro integer(16),
    nombre varchar(30),
    apellido varchar(15),
    telefono varchar(30),
    DNI varchar(8),
    email varchar(40),
    contrasena varchar(32),
    PRIMARY KEY (id_cliente),
    UNIQUE(DNI)
);

create table cajaDeAhorros(
    id_cajaDeAhorro integer(16) auto_increment,
    id_cliente integer(16),
    saldo float,
    PRIMARY KEY (id_cajaDeAhorro),
    FOREIGN KEY(id_cliente) references cliente(id_cliente)
);

create table historial(
    id_historial integer(16) auto_increment,
    saldoInicio float,
    saldoFinal  float,
    ingreso_egreso boolean,
    fecha date,
    id_cajaDeAhorro integer(16),
    PRIMARY KEY(id_historial),
    FOREIGN KEY(id_cajaDeAhorro) references cajaDeAhorros(id_cajaDeAhorro)
);

ALTER TABLE cliente
ADD FOREIGN KEY (id_cajaDeAhorro) REFERENCES cajaDeAhorros(id_cajaDeAhorro);