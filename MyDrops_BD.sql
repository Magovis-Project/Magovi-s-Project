-- Creación de la base de datos
CREATE DATABASE MyDrops_BD
USE MyDrops_BD;

-- Tabla Usuarios
CREATE TABLE Usuarios (
    Id_Usuario INT PRIMARY KEY AUTO_INCREMENT,
    Password VARCHAR(255) NOT NULL,
    Direccion VARCHAR(255) NOT NULL,
    Apellido VARCHAR(255) NOT NULL,
    Nombre VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Telefono INT,
    Cedula INT NOT NULL,
    Fecha_Creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    Foto BLOB
);

-- Tabla Empresa
CREATE TABLE Empresa (
    ID_Empresa INT PRIMARY KEY AUTO_INCREMENT,
    Password VARCHAR(255) NOT NULL,
    Direccion VARCHAR(255) NOT NULL,
    Nombre VARCHAR(255) NOT NULL,
    RUT VARCHAR(20) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Telefono VARCHAR(20) NOT NULL,
    Valoracion DECIMAL(2, 1),
);

-- Tabla Articulos
CREATE TABLE Articulos (
    Id_Articulos INT PRIMARY KEY AUTO_INCREMENT,
    ID_Empresa INT,
    Nombre VARCHAR(255) NOT NULL,
    Precio DECIMAL(10, 2) NOT NULL,
    Cantidad INT NOT NULL,
    Tipo VARCHAR(50) NOT NULL,
    FOREIGN KEY (ID_Empresa) REFERENCES Empresa(ID_Empresa)
);

-- Tabla Carrito
CREATE TABLE Carrito (
    Id_Usuario INT PRIMARY KEY,
    Cantidad INT NOT NULL,
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario)
);

-- Tabla Conforma
CREATE TABLE Conforma (
    Id_Usuario INT,
    ID_Articulo INT,
    PRIMARY KEY (Id_Usuario, ID_Articulo),
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario),
    FOREIGN KEY (ID_Articulo) REFERENCES Articulos(Id_Articulos)
);

-- Tabla Reseña
CREATE TABLE Reseña (
    Id_Reseña INT PRIMARY KEY AUTO_INCREMENT,
    Rating DECIMAL(2, 1) NOT NULL,
    Comentario TEXT NOT NULL,
    Fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    Id_Articulos INT,
    Id_Usuario INT,
    FOREIGN KEY (Id_Articulos) REFERENCES Articulos(Id_Articulos),
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario)
);

-- Tabla Envio
CREATE TABLE Envio (
    ID_Envio INT PRIMARY KEY AUTO_INCREMENT,
    ID_Usuario INT,
    Estado VARCHAR(50) NOT NULL,
    Id_Repartidor INT,
    FOREIGN KEY (ID_Usuario) REFERENCES Usuarios(Id_Usuario),
    FOREIGN KEY (Id_Repartidor) REFERENCES Repartidor(ID_Repartidor)
);

-- Tabla Repartidor
CREATE TABLE Repartidor (
    ID_Repartidor INT PRIMARY KEY AUTO_INCREMENT,
    Empresa_Matriz VARCHAR(255)
);

-- Tabla Vio
CREATE TABLE Vio (
    Id_Articulos INT,
    Id_Usuario INT,
    Fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (Id_Articulos, Id_Usuario, Fecha),
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario),
    FOREIGN KEY (Id_Articulos) REFERENCES Articulos(Id_Articulos)
);

-- Tabla Likeo
CREATE TABLE Likeo (
    Id_Usuario INT,
    ID_Articulo INT,
    PRIMARY KEY (Id_Usuario, ID_Articulo),
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario),
    FOREIGN KEY (ID_Articulo) REFERENCES Articulos(Id_Articulos)
);

-- Tabla Compone
CREATE TABLE Compone (
    Id_Envio INT,
    ID_Articulo INT,
    PRIMARY KEY (Id_Envio, ID_Articulo),
    FOREIGN KEY (Id_Envio) REFERENCES Envio(ID_Envio),
    FOREIGN KEY (ID_Articulo) REFERENCES Articulos(Id_Articulos)
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
