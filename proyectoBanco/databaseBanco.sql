    drop database if exists databaseBanco;
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
        emisor integer(16),
        receptor integer(16),
        id_cajaDeAhorro integer(16),
        PRIMARY KEY(id_historial),
        FOREIGN KEY(id_cajaDeAhorro) references cajaDeAhorros(id_cajaDeAhorro),
        FOREIGN KEY(emisor) references cliente(id_cliente),
        FOREIGN KEY(receptor) references cliente(id_cliente)
    );

    ALTER TABLE cliente
    ADD FOREIGN KEY (id_cajaDeAhorro) REFERENCES cajaDeAhorros(id_cajaDeAhorro);

   INSERT INTO cliente (nombre, apellido, telefono, DNI, email, contrasena)
    VALUES
    ('Juan', 'Pérez', '11 1555-1234', '12345678', 'juan.perez@email.com', MD5('juanP@1234')),
    ('Ana', 'Gómez', '11 1555-5678', '87654321', 'ana.gomez@email.com', MD5('anaG!m5678')),
    ('Carlos', 'López', '11 1555-9876', '11223344', 'carlos.lopez@email.com', MD5('c@rlos12345')),
    ('María', 'Martínez', '11 1555-4567', '22334455', 'maria.martinez@email.com', MD5('m@ria1234567')),
    ('Pedro', 'Sánchez', '11 1555-1357', '55667788', 'pedro.sanchez@email.com', MD5('pedro!S9876'));


    INSERT INTO cajaDeAhorros (id_cliente, saldo)
    VALUES
    (1, 5000.00),
    (2, 3000.00),
    (3, 7000.00),
    (4, 1500.00),
    (5, 10000.00);


    -- Historial de transacciones de Juan (Cliente 1)
    INSERT INTO historial (saldoInicio, saldoFinal, ingreso_egreso, fecha, emisor, receptor, id_cajaDeAhorro)
    VALUES
    (5000.00, 4500.00, 0, '2024-10-01', 1, 2, 1),  -- Juan transfiere a Ana
    (4500.00, 4300.00, 0, '2024-10-03', 1, 3, 1),  -- Juan transfiere a Carlos
    (4300.00, 4600.00, 1, '2024-10-05', 2, 1, 1),  -- Ana recibe dinero de Juan
    (4600.00, 5200.00, 1, '2024-10-06', 4, 1, 1),  -- María recibe dinero de Juan
    (5200.00, 5000.00, 0, '2024-10-07', 1, 5, 1);  -- Juan transfiere a Pedro

    -- Historial de transacciones de Ana (Cliente 2)
    INSERT INTO historial (saldoInicio, saldoFinal, ingreso_egreso, fecha, emisor, receptor, id_cajaDeAhorro)
    VALUES
    (3000.00, 3500.00, 1, '2024-10-02', 1, 2, 2),  -- Juan transfiere a Ana
    (3500.00, 3000.00, 0, '2024-10-04', 2, 3, 2),  -- Ana transfiere a Carlos
    (3000.00, 3500.00, 1, '2024-10-06', 3, 2, 2),  -- Carlos transfiere a Ana
    (3500.00, 4000.00, 1, '2024-10-08', 5, 2, 2),  -- Pedro transfiere a Ana
    (4000.00, 4500.00, 1, '2024-10-09', 4, 2, 2);  -- María transfiere a Ana

    -- Historial de transacciones de Carlos (Cliente 3)
    INSERT INTO historial (saldoInicio, saldoFinal, ingreso_egreso, fecha, emisor, receptor, id_cajaDeAhorro)
    VALUES
    (7000.00, 8000.00, 1, '2024-10-05', 4, 3, 3),  -- María transfiere a Carlos
    (8000.00, 7500.00, 0, '2024-10-06', 3, 4, 3),  -- Carlos transfiere a María
    (7500.00, 7000.00, 0, '2024-10-07', 3, 2, 3),  -- Carlos transfiere a Ana
    (7000.00, 7500.00, 1, '2024-10-08', 2, 3, 3),  -- Ana transfiere a Carlos
    (7500.00, 8000.00, 1, '2024-10-09', 5, 3, 3);  -- Pedro transfiere a Carlos

    -- Historial de transacciones de María (Cliente 4)
    INSERT INTO historial (saldoInicio, saldoFinal, ingreso_egreso, fecha, emisor, receptor, id_cajaDeAhorro)
    VALUES
    (1500.00, 1000.00, 0, '2024-10-06', 4, 5, 4),  -- María transfiere a Pedro
    (1000.00, 1500.00, 1, '2024-10-07', 5, 4, 4),  -- Pedro transfiere a María
    (1500.00, 2000.00, 1, '2024-10-08', 3, 4, 4),  -- Carlos transfiere a María
    (2000.00, 1800.00, 0, '2024-10-09', 4, 1, 4),  -- María transfiere a Juan
    (1800.00, 2500.00, 1, '2024-10-10', 2, 4, 4);  -- Ana transfiere a María

    -- Historial de transacciones de Pedro (Cliente 5)
    INSERT INTO historial (saldoInicio, saldoFinal, ingreso_egreso, fecha, emisor, receptor, id_cajaDeAhorro)
    VALUES
    (10000.00, 9000.00, 0, '2024-10-07', 5, 1, 5),  -- Pedro transfiere a Juan
    (9000.00, 9500.00, 1, '2024-10-08', 1, 5, 5),  -- Juan transfiere a Pedro
    (9500.00, 10500.00, 1, '2024-10-09', 4, 5, 5),  -- María transfiere a Pedro
    (10500.00, 10000.00, 0, '2024-10-10', 5, 3, 5),  -- Pedro transfiere a Carlos
    (10000.00, 12000.00, 1, '2024-10-11', 2, 5, 5);  -- Ana transfiere a Pedro

    -- Actualizar el cliente 1 (Juan) con su id_cajaDeAhorro
    UPDATE cliente
    SET id_cajaDeAhorro = 1
    WHERE id_cliente = 1;

    -- Actualizar el cliente 2 (Ana) con su id_cajaDeAhorro
    UPDATE cliente
    SET id_cajaDeAhorro = 2
    WHERE id_cliente = 2;

    -- Actualizar el cliente 3 (Carlos) con su id_cajaDeAhorro
    UPDATE cliente
    SET id_cajaDeAhorro = 3
    WHERE id_cliente = 3;

    -- Actualizar el cliente 4 (María) con su id_cajaDeAhorro
    UPDATE cliente
    SET id_cajaDeAhorro = 4
    WHERE id_cliente = 4;

    -- Actualizar el cliente 5 (Pedro) con su id_cajaDeAhorro
    UPDATE cliente
    SET id_cajaDeAhorro = 5
    WHERE id_cliente = 5;
