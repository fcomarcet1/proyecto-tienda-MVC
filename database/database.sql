SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `tienda_master` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE tienda_master;

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios
(
    idUsuario INT AUTO_INCREMENT NOT NULL,
    nombre VARCHAR (100) NOT NULL,
    apellidos VARCHAR (255) NOT NULL,
    email VARCHAR (100) NOT NULL,
    password VARCHAR (255) NOT NULL,
    rol VARCHAR (50) ,
    fecha_reg DATETIME DEFAULT CURRENT_TIMESTAMP, 

    CONSTRAINT pk_usuarios PRIMARY KEY (idUsuario),
    CONSTRAINT uq_email UNIQUE (email)

) ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO usuarios VALUES (NULL, "admin", "admin", "admin@admin.es", "admin", "Administrador", NOW());


DROP TABLE IF EXISTS  categorias;
CREATE TABLE  categorias 
(
    idCategoria INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR (255) NOT NULL,
    CONSTRAINT pk_categorias PRIMARY KEY(idCategoria)

) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO categorias VALUES(NULL,"Manga corta");
INSERT INTO categorias VALUES(NULL,"Manga larga");
INSERT INTO categorias VALUES(NULL,"Tirantes");
INSERT INTO categorias VALUES(NULL,"Sudaderas");

DROP TABLE IF EXISTS productos;
CREATE TABLE `productos` 
(
    idproducto INT NOT NULL AUTO_INCREMENT,
    id_categoria INT NOT NULL ,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio FLOAT(8,2) NOT NULL, /* decimal es para numeros mayores*/
    stock INT NOT NULL,
    oferta VARCHAR(2),
    imagen VARCHAR(255),
    fecha_reg DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT pk_producto PRIMARY KEY (idproducto),
    CONSTRAINT fk_categorias_producto FOREIGN KEY (id_categoria) REFERENCES categorias (idCategoria) 

) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



DROP TABLE IF EXISTS pedidos;
CREATE TABLE pedidos 
(
    idpedido INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL ,
    localidad VARCHAR(100) NOT NULL,
    provincia  VARCHAR(255) NOT NULL,
    direccion  VARCHAR(255) NOT NULL,
    coste FLOAT(8,2) NOT NULL, /* decimal es para numeros mayores*/
    estado VARCHAR(20) NOT NULL,
    fecha_reg DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT pk_pedido PRIMARY KEY (idpedido),
    CONSTRAINT fk_pedido_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios (idUsuario) 

) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS lineas_pedidos;
CREATE TABLE lineas_pedidos 
(
    idLineaPedido INT NOT NULL AUTO_INCREMENT,
    id_pedido  INT NOT NULL,
    id_producto  INT NOT NULL,

    CONSTRAINT pk_lineas_pedido PRIMARY KEY(idLineaPedido),
    CONSTRAINT fk_linea_pedido FOREIGN KEY (id_pedido) REFERENCES pedidos (idPedido),
    CONSTRAINT fk_linea_producto FOREIGN KEY (id_producto) REFERENCES productos (idProducto)  

) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;