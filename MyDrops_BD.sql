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
    Telefono INT,
    Cedula INT NOT NULL UNIQUE,
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
