-- Creación de la base de datos
CREATE DATABASE MyDrops_BD;
USE MyDrops_BD;

-- Tabla Usuarios
CREATE TABLE Usuarios (
    Id_Usuario INT PRIMARY KEY AUTO_INCREMENT,
    Password VARCHAR(255) NOT NULL,
    Direccion VARCHAR(255) NOT NULL,
    Apellido VARCHAR(255) NOT NULL,
    Nombre VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Telefono VARCHAR(9),
    Cedula VARCHAR(8) NOT NULL UNIQUE,
    Fecha_Creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    Foto TEXT,
    Actividad ENUM("Activo","Desactivado") DEFAULT "Activo"
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
    Valoracion DECIMAL(2, 1),
    Actividad ENUM("Activo","Desactivado") DEFAULT "Activo",
    foto_url VARCHAR(255)
);

-- Tabla Articulos
CREATE TABLE Articulos (
    Id_Articulos INT PRIMARY KEY AUTO_INCREMENT,
    ID_Empresa INT,
    Nombre VARCHAR(255) NOT NULL,
    Precio DECIMAL(10, 2) NOT NULL,
    Cantidad INT NOT NULL,
    Valoracion DECIMAL(2,1) DEFAULT "0.0",
    Descripcion TEXT NOT NULL,
    Actividad ENUM("Activo","Desactivado") DEFAULT "Activo",
    FOREIGN KEY (ID_Empresa) REFERENCES Empresa(ID_Empresa)
);

CREATE TABLE Categorias (
    ID_Categoria INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE Categorizan (
    Id_Articulo INT,
    Id_Categoria INT,
    FOREIGN KEY (Id_Articulo) REFERENCES Articulos(Id_Articulos),
    FOREIGN KEY (Id_Categoria) REFERENCES Categorias(ID_Categoria),
    PRIMARY KEY (Id_Articulo, Id_Categoria)
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

CREATE TABLE Ventas (
    Id_Venta INT PRIMARY KEY AUTO_INCREMENT,
    Id_Usuario INT NOT NULL,                    -- Cliente que realizó la compra
    Fecha DATETIME DEFAULT CURRENT_TIMESTAMP,   -- Fecha y hora de la venta
    Total DECIMAL(10, 2) NOT NULL,              -- Monto total de la venta
    FOREIGN KEY (Id_Usuario) REFERENCES Usuarios(Id_Usuario)
);


CREATE TABLE Detalle_Venta (
    Id_Detalle INT PRIMARY KEY AUTO_INCREMENT,
    Id_Venta INT NOT NULL,                      -- ID de la venta
    Id_Articulo INT NOT NULL,                   -- ID del artículo vendido
    Cantidad INT NOT NULL,                      -- Cantidad de artículos vendidos
    Precio DECIMAL(10, 2) NOT NULL,             -- Precio unitario en el momento de la venta
    FOREIGN KEY (Id_Venta) REFERENCES Ventas(Id_Venta),
    FOREIGN KEY (Id_Articulo) REFERENCES Articulos(Id_Articulos)
);

-- Insertar datos en la tabla Usuarios con cédulas únicas
INSERT INTO Usuarios (Password, Direccion, Apellido, Nombre, Email, Telefono, Cedula)
VALUES 
('password123', '123 Calle Falsa', 'Perez', 'Juan', 'juan.perez@gmail.com', 123456789, 12345678),
('password456', '456 Calle Verdadera', 'Gomez', 'Ana', 'ana.gomez@hotmail.com', 987654321, 87654321),
('password789', '789 Calle Real', 'Lopez', 'Carlos', 'carlos.lopez@yahoo.com', 112233445, 23456789), 
('password321', '321 Calle Norte', 'Ramirez', 'Mariana', 'mariana.ramirez@outlook.com', 667788990, 76543210),  
('password654', '654 Calle Sur', 'Martinez', 'Luis', 'luis.martinez@correo.com', 445566778, 34567890),  
('password987', '987 Calle Este', 'Torres', 'Sofia', 'sofia.torres@gmail.com', 998877665, 45678901),  
('password111', '111 Calle Oeste', 'Diaz', 'Lucia', 'lucia.diaz@correo.com', 332211445, 56789012), 
('password222', '222 Calle Central', 'Garcia', 'David', 'david.garcia@hotmail.com', 776655443, 67890123),
('password333', '333 Calle Principal', 'Jimenez', 'Laura', 'laura.jimenez@correo.com', 556677889, 78901234),  
('password444', '444 Calle Secundaria', 'Morales', 'Fernando', 'fernando.morales@gmail.com', 998877664, 89012345); 


-- Insertar datos en la tabla Empresa con RUT corregido
INSERT INTO Empresa (Password, Direccion, Nombre, RUT, Email, Telefono, Valoracion)
VALUES 
('emp_password1', 'Av. Empresa 123', 'Tecnologias SA', '123456789012', 'contacto@tecnologiassa.com', '123456789', 4.5),
('emp_password2', 'Av. Empresa 456', 'Construcciones SRL', '234567890123', 'info@construccionessrl.com', '987654321', 3.8),
('emp_password3', 'Av. Empresa 789', 'Moda y Estilo', '345678901234', 'ventas@modaestilo.com', '112233445', 4.2),
('emp_password4', 'Av. Empresa 101', 'Alimentos Saludables', '456789012345', 'contacto@alimentos.com', '667788990', 4.9),
('emp_password5', 'Av. Empresa 102', 'Electrodomésticos S.A.', '567890123456', 'soporte@electro.com', '445566778', 3.9);

-- Insertar datos en la tabla Articulos
INSERT INTO Articulos (ID_Empresa, Nombre, Precio, Cantidad, Descripcion)
VALUES
(1, 'Laptop HP', 750.00, 50, 'Laptop HP con 8GB RAM y 256GB SSD'),
(1, 'Mouse Inalámbrico', 25.00, 200, 'Mouse inalámbrico ergonómico'),
(2, 'Taladro Bosch', 120.00, 100, 'Taladro eléctrico Bosch para uso doméstico'),
(3, 'Chaqueta de Invierno', 65.00, 150, 'Chaqueta térmica para invierno'),
(4, 'Batido de Proteína', 30.00, 300, 'Batido alto en proteínas para deportistas');

-- Insertar datos en la tabla Reseña
INSERT INTO Reseña (Rating, Comentario, Id_Articulos, Id_Usuario)
VALUES
(4.5, 'Excelente producto, muy recomendado.', 1, 1),
(3.8, 'Buena calidad, pero algo costoso.', 2, 2),
(5.0, 'Me ayudó mucho en mi trabajo diario.', 3, 3),
(4.0, 'Muy cómoda y caliente, ideal para el frío.', 4, 4),
(4.7, 'Ideal para complementar mi dieta.', 5, 5);

-- Insertar datos en la tabla Carrito
INSERT INTO Carrito (Id_Usuario, Cantidad)
VALUES 
(1, 3),
(2, 5),
(3, 2),
(4, 7),
(5, 1);

-- Insertar datos en la tabla Conforma
INSERT INTO Conforma (Id_Usuario, ID_Articulo)
VALUES 
(1, 1),
(1, 2),
(2, 3),
(3, 4),
(4, 5),
(5, 1);

-- Insertar datos en la tabla Repartidor
INSERT INTO Repartidor (Empresa_Matriz)
VALUES 
('Rápidos S.A.'),
('Mensajería Plus'),
('Entregas Express'),
('Logística Global'),
('Envíos Directos');

-- Insertar datos en la tabla Envio
INSERT INTO Envio (ID_Usuario, Estado, Id_Repartidor)
VALUES 
(1, 'En camino', 1),
(2, 'Entregado', 2),
(3, 'Pendiente', 3),
(4, 'Cancelado', 4),
(5, 'En camino', 5);

-- Insertar datos en la tabla Vio
INSERT INTO Vio (Id_Articulos, Id_Usuario, Fecha)
VALUES 
(1, 1, '2024-10-15 10:30:00'),
(2, 2, '2024-10-16 11:45:00'),
(3, 3, '2024-10-17 12:00:00'),
(4, 4, '2024-10-18 13:15:00'),
(5, 5, '2024-10-19 14:20:00');

-- Insertar datos en la tabla Likeo
INSERT INTO Likeo (Id_Usuario, ID_Articulo)
VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- Insertar datos en la tabla Compone
INSERT INTO Compone (Id_Envio, ID_Articulo)
VALUES 
(1, 1),
(1, 2),
(2, 3),
(3, 4),
(4, 5);

-- Insertar datos en la tabla Ventas
INSERT INTO Ventas (Id_Usuario, Total)
VALUES 
(1, 150.00),
(2, 75.00),
(3, 200.00),
(4, 50.00),
(5, 300.00);

-- Insertar datos en la tabla Detalle_Venta
INSERT INTO Detalle_Venta (Id_Venta, Id_Articulo, Cantidad, Precio)
VALUES 
(1, 1, 2, 75.00),
(1, 2, 1, 25.00),
(2, 3, 1, 75.00),
(3, 4, 3, 50.00),
(4, 5, 1, 50.00),
(5, 1, 4, 75.00);


INSERT INTO Categorias (Nombre) VALUES
('Electrónica'),
('Hogar'),
('Jardinería'),
('Moda'),
('Salud'),
('Deportes'),
('Alimentos'),
('Libros'),
('Juguetes'),
('Muebles');

-- Insertar datos en la tabla Categorizan
INSERT INTO Categorizan (Id_Articulo, Id_Categoria)
VALUES 
(1, 1),  -- Laptop HP - Electrónica
(2, 1),  -- Mouse Inalámbrico - Electrónica
(3, 2),  -- Taladro Bosch - Hogar
(3, 3),  -- Taladro Bosch - Jardinería
(4, 4),  -- Chaqueta de Invierno - Moda
(5, 5),  -- Batido de Proteína - Salud
(5, 6),  -- Batido de Proteína - Deportes
(1, 7),  -- Laptop HP - Alimentos
(4, 8),  -- Chaqueta de Invierno - Libros (por ejemplo de estilo)
(2, 9);  -- Mouse Inalámbrico - Juguetes



-- Crear Usuario Visitante con Permisos Restringidos
CREATE USER 'visitante'@'%' IDENTIFIED BY 'password_visitante'; 
GRANT SELECT ON MyDrops_BD.Articulos TO 'visitante'@'%';
GRANT SELECT, INSERT, UPDATE ON MyDrops_BD.Carrito TO 'visitante'@'%';

-- Crear Usuario Final con Permisos Restringidos
CREATE USER 'usuario_final'@'%' IDENTIFIED BY 'password_final';
GRANT SELECT, UPDATE ON MyDrops_BD.Usuarios TO 'usuario_final'@'%';
GRANT SELECT ON MyDrops_BD.Articulos TO 'usuario_final'@'%';
GRANT SELECT, INSERT, UPDATE ON MyDrops_BD.Carrito TO 'usuario_final'@'%';
GRANT SELECT, INSERT ON MyDrops_BD.Reseña TO 'usuario_final'@'%';

-- Crear Usuario Admin con Todos los Permisos
CREATE USER 'admin'@'%' IDENTIFIED BY 'password_admin'; 
GRANT ALL PRIVILEGES ON MyDrops_BD.* TO 'admin'@'%';

-- Crear Usuario Empresa con Permisos Restringidos
CREATE USER 'empresa'@'%' IDENTIFIED BY 'password_empresa';
GRANT SELECT, INSERT, UPDATE ON MyDrops_BD.Empresa TO 'empresa'@'%'; 
GRANT SELECT, INSERT, UPDATE, DELETE ON MyDrops_BD.Articulos TO 'empresa'@'%';
GRANT SELECT ON MyDrops_BD.Reseña TO 'empresa'@'%';

-- Aplicar los Cambios
FLUSH PRIVILEGES;
