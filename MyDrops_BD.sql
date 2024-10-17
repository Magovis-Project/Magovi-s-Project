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
    Email VARCHAR(255) NOT NULL UNIQUE,
    Telefono INT,
    Cedula INT NOT NULL UNIQUE,
    Fecha_Creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    Foto TEXT
);

-- Tabla Empresa
CREATE TABLE Empresa (
    ID_Empresa INT PRIMARY KEY AUTO_INCREMENT,
    Password VARCHAR(255) NOT NULL,
    Direccion VARCHAR(255) NOT NULL,
    Nombre VARCHAR(255) NOT NULL UNIQUE,
    RUT VARCHAR(20) NOT NULL UNIQUE,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Telefono VARCHAR(20) NOT NULL,
    Valoracion DECIMAL(2, 1)
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

-- Tabla Repartidor
CREATE TABLE Repartidor (
    ID_Repartidor INT PRIMARY KEY AUTO_INCREMENT,
    Empresa_Matriz VARCHAR(255)
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


-- Insertar datos en la tabla Usuarios
INSERT INTO Usuarios (Password, Direccion, Apellido, Nombre, Email, Telefono, Cedula, Foto)
VALUES
('Password123', 'Av. Siempre Viva 123', 'Pérez', 'Juan', 'juan.perez@example.com', 5551234, 12345678, NULL),
('Password456', 'Calle Falsa 456', 'García', 'Ana', 'ana.garcia@example.com', 5555678, 87654321, NULL),
('Password789', 'Paseo de la Reforma 789', 'Martínez', 'Pedro', 'pedro.martinez@example.com', 5559101, 11223344, NULL);

-- Insertar datos en la tabla Empresa
INSERT INTO Empresa (Password, Direccion, Nombre, RUT, Email, Telefono, Valoracion)
VALUES
('empresaA123', 'Calle Principal 1', 'Empresa A', '12345678-9', 'contacto@empresaA.com', '555-0011', 4.5),
('empresaB123', 'Av. Secundaria 2', 'Empresa B', '98765432-1', 'contacto@empresaB.com', '555-0022', 4.0);

-- Insertar datos en la tabla Articulos
INSERT INTO Articulos (ID_Empresa, Nombre, Precio, Cantidad, Tipo)
VALUES
(1, 'Producto A1', 10.00, 100, 'Tipo 1'),
(1, 'Producto A2', 20.00, 200, 'Tipo 2'),
(2, 'Producto B1', 30.00, 150, 'Tipo 1');

-- Insertar datos en la tabla Carrito
INSERT INTO Carrito (Id_Usuario, Cantidad)
VALUES
(1, 2),
(2, 3),
(3, 1);

-- Insertar datos en la tabla Conforma
INSERT INTO Conforma (Id_Usuario, ID_Articulo)
VALUES
(1, 1),
(2, 2),
(3, 3);

-- Insertar datos en la tabla Reseña
INSERT INTO Reseña (Rating, Comentario, Id_Articulos, Id_Usuario)
VALUES
(5.0, 'Excelente calidad', 1, 1),
(4.0, 'Buena relación calidad-precio', 2, 2),
(3.5, 'Satisfactorio', 3, 3);

-- Insertar datos en la tabla Repartidor
INSERT INTO Repartidor (Empresa_Matriz)
VALUES
('Empresa A'),
('Empresa B');

-- Insertar datos en la tabla Envio
INSERT INTO Envio (ID_Usuario, Estado, Id_Repartidor)
VALUES
(1, 'En camino', 1),
(2, 'Entregado', 2);

-- Insertar datos en la tabla Vio
INSERT INTO Vio (Id_Articulos, Id_Usuario)
VALUES
(1, 1),
(2, 2),
(3, 3);

-- Insertar datos en la tabla Likeo
INSERT INTO Likeo (Id_Usuario, ID_Articulo)
VALUES
(1, 2),
(2, 1);

-- Insertar datos en la tabla Compone
INSERT INTO Compone (Id_Envio, ID_Articulo)
VALUES
(1, 1),
(1, 2),
(2, 3);



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
