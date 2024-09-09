CREATE DATABASE MyDrops_BD;
USE MyDrops_BD;

CREATE TABLE usuario(
    id_usuario INT AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (id_usuario)
);

CREATE TABLE tarjetas(
    id_usuario INT NOT NULL,
    numero_tarjeta VARCHAR(16) NOT NULL,
    FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario),
    PRIMARY KEY (id_usuario)
);

CREATE TABLE empresa(
    id_empresa INT AUTO_INCREMENT NOT NULL,
    nombre_empresa VARCHAR(50) NOT NULL,
    direccion_empresa VARCHAR(100) NOT NULL,
    email_empresa VARCHAR(50) NOT NULL,
    password_empresa VARCHAR(255) NOT NULL,
    RUT VARCHAR(12) NOT NULL,
    PRIMARY KEY (id_empresa)
);

CREATE TABLE articulos(
    id_articulo INT AUTO_INCREMENT NOT NULL,
    id_empresa INT NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    cantidad INT NOT NULL,
    tipo INT NOT NULL,
    FOREIGN KEY(id_empresa) REFERENCES empresa(id_empresa),
    PRIMARY KEY (id_articulo)
);

CREATE TABLE compras(
    id_usuario INT NOT NULL,
    id_articulo INT NOT NULL,
    FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario),
    FOREIGN KEY(id_articulo) REFERENCES articulos(id_articulo),
    PRIMARY KEY (id_usuario, id_articulo)
);

CREATE TABLE carrito(
    id_carrito INT AUTO_INCREMENT NOT NULL,
    id_usuario INT NOT NULL,
    estado_carrito ENUM("Entregado", "Recibido", "Armado", "En camino") NOT NULL,
    FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario),
    PRIMARY KEY (id_carrito)
);

CREATE TABLE repartidor(
    id_repartidor INT AUTO_INCREMENT NOT NULL,
    id_carrito INT NOT NULL,
    empresa_matriz VARCHAR(50) NOT NULL,
    FOREIGN KEY(id_carrito) REFERENCES carrito(id_carrito),
    PRIMARY KEY (id_repartidor)
);

CREATE TABLE conforma(
    id_usuario INT NOT NULL,
    id_articulo INT NOT NULL,
    id_carrito INT NOT NULL,
    FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario),
    FOREIGN KEY(id_articulo) REFERENCES articulos(id_articulo),
    FOREIGN KEY(id_carrito) REFERENCES carrito(id_carrito),
    PRIMARY KEY (id_usuario, id_articulo, id_carrito)
);

CREATE TABLE reseña(
    id_reseña INT AUTO_INCREMENT NOT NULL,
    id_usuario INT NOT NULL,
    id_articulo INT NOT NULL,
    comentario VARCHAR(255) NOT NULL,
    rating INT DEFAULT 0,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
    FOREIGN KEY (id_articulo) REFERENCES articulos(id_articulo),
    PRIMARY KEY (id_reseña)
);

-- Insertar datos en la tabla usuario
INSERT INTO usuario (nombre, apellido, direccion, foto, email, password, telefono)
VALUES
('Juan', 'Pérez', 'Av. Siempre Viva 123', 'juan.jpg', 'juan.perez@example.com', 'password123', '555-1234'),
('Ana', 'García', 'Calle Falsa 456', 'ana.jpg', 'ana.garcia@example.com', 'password456', '555-5678'),
('Pedro', 'Martínez', 'Paseo de la Reforma 789', 'pedro.jpg', 'pedro.martinez@example.com', 'password789', '555-9101');

-- Insertar datos en la tabla tarjetas
INSERT INTO tarjetas (id_usuario, numero_tarjeta)
VALUES
(1, '1234567812345678'),
(2, '2345678923456789'),
(3, '3456789034567890');

-- Insertar datos en la tabla empresa
INSERT INTO empresa (nombre_empresa, direccion_empresa, email_empresa, password_empresa, RUT)
VALUES
('Empresa A', 'Calle Principal 1', 'contacto@empresaA.com', 'passwordA', '12345678-9'),
('Empresa B', 'Av. Secundaria 2', 'contacto@empresaB.com', 'passwordB', '98765432-1');

-- Insertar datos en la tabla articulos
INSERT INTO articulos (id_empresa, nombre, precio, cantidad, tipo)
VALUES
(1, 'Artículo 1', 10.00, 100, 1),
(1, 'Artículo 2', 20.00, 200, 2),
(2, 'Artículo 3', 30.00, 150, 1);

-- Insertar datos en la tabla compras
INSERT INTO compras (id_usuario, id_articulo)
VALUES
(1, 1),
(2, 2),
(3, 3);

-- Insertar datos en la tabla carrito
INSERT INTO carrito (id_usuario, estado_carrito)
VALUES
(1, 'Armado'),
(2, 'En camino'),
(3, 'Recibido');

-- Insertar datos en la tabla repartidor
INSERT INTO repartidor (id_carrito, empresa_matriz)
VALUES
(1, 'Empresa A'),
(2, 'Empresa B');

-- Insertar datos en la tabla conforma
INSERT INTO conforma (id_usuario, id_articulo, id_carrito)
VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3);

-- Insertar datos en la tabla reseña
INSERT INTO reseña (id_usuario, id_articulo, comentario, rating)
VALUES
(1, 1, 'Excelente producto', 5),
(2, 2, 'Buena calidad', 4),
(3, 3, 'Satisfecho con la compra', 3);



-- Crear Usuario Visitante con Permisos Restringidos
CREATE USER 'visitante'@'%' IDENTIFIED BY 'password_visitante'; 
-- Permitir solo la visualización de los artículos.
GRANT SELECT ON MyDrops_BD.articulos TO 'visitante'@'%';
-- Permitir que el visitante inserte, actualice y vea su carrito.
GRANT SELECT, INSERT, UPDATE ON MyDrops_BD.carrito TO 'visitante'@'%';


-- Crear Usuario Final con Permisos Restringidos
CREATE USER 'usuario_final'@'%' IDENTIFIED BY 'password_final';
-- Permitir ver y actualizar sus propios datos
GRANT SELECT, UPDATE ON MyDrops_BD.usuario TO 'usuario_final'@'%';
-- Permitir ver artículos
GRANT SELECT ON MyDrops_BD.articulos TO 'usuario_final'@'%';
-- Permitir agregar y modificar su propio carrito (sin eliminar)
GRANT SELECT, INSERT, UPDATE ON MyDrops_BD.carrito TO 'usuario_final'@'%';
-- Permitir agregar y ver sus propias reseñas
GRANT SELECT, INSERT ON MyDrops_BD.reseña TO 'usuario_final'@'%';
-- Permitir realizar compras (interactuar con artículos)
GRANT SELECT, INSERT ON MyDrops_BD.compras TO 'usuario_final'@'%';


-- Crear Usuario Admin con Todos los Permisos
CREATE USER 'admin'@'%' IDENTIFIED BY 'password_admin'; 
GRANT ALL PRIVILEGES ON MyDrops_BD.* TO 'admin'@'%';

-- Crear Usuario Empresa con Permisos Restringidos
CREATE USER 'empresa'@'%' IDENTIFIED BY 'password_empresa';
-- Permisos para manipular sus propios datos de empresa
GRANT SELECT, INSERT, UPDATE ON MyDrops_BD.empresa TO 'empresa'@'%'; 
-- Permisos para manipular sus propios artículos
GRANT SELECT, INSERT, UPDATE, DELETE ON MyDrops_BD.articulos TO 'empresa'@'%';
-- Permiso de visualización sobre las reseñas de los productos
GRANT SELECT ON MyDrops_BD.reseña TO 'empresa'@'%';



-- Aplicar los Cambios
FLUSH PRIVILEGES;
