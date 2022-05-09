CREATE TABLE `almacen`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NULL,
  `fecha` varchar(255) NULL,
  `hora` varchar(255) NULL,
  `id_empresa` int(11) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `almacen_productos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_almacen` int(11) NULL,
  `id_producto` varchar(255) NULL,
  `cantidad` double NULL,
  `mod_fecha_entrada` date NULL,
  `mod_hora_entrada` time NULL,
  `mod_fecha_salida` date NULL,
  `mod_hora_salida` time NULL,
  `mod_id_usuario` int(11) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `categoria_inv`  (
  `id` int NOT NULL,
  `nombre` varchar(255) NULL,
  `id_empresa` int(11) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `empresa`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NULL,
  `fecha` varchar(255) NULL,
  `hora` varchar(255) NULL,
  `id_sub` int(11) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `entrada_producto`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NULL,
  `fecha` date NULL,
  `hora` time NULL,
  `cantidad` double NULL,
  `id_producto` int(11) NULL,
  `devolucion` int(11) NULL,
  `id_usuario_dev` int(11) NULL,
  `clave_solicitud` varchar(255) NULL,
  `id_almacen` int(11) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `producto_foto_inv`  (
  `id` int NOT NULL,
  `foto` varchar(255) NULL,
  `id_producto` int NULL,
  `favorito` int NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `productos_inv`  (
  `id` int NOT NULL DEFAULT '',
  `nombre` varchar(255) NULL,
  `cantidad` int NULL,
  `descripcion` varchar(255) NULL,
  `codigo_barras` varchar(255) NULL,
  `sku` varchar(255) NULL,
  `fecha_registro` date NULL,
  `hora_registro` time NULL,
  `id_usuario_alta` int NULL,
  `id_categoria` int NULL,
  `estatus` int NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `salida_producto`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NULL,
  `fecha` date NULL,
  `hora` time NULL,
  `cantidad` double NULL,
  `cantidad_prestada` double NULL,
  `id_producto` int(11) NULL,
  `id_solicitante` int(11) NULL,
  `prestamo` int(11) NULL,
  `estatus` int(11) NULL,
  `clave_solicitud` varchar(255) NULL,
  `id_usuario_mod_pres` int(11) NULL,
  `id_almacen` int(255) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `subs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) NULL,
  `contraseña` varchar(255) NULL,
  `nombres` varchar(255) NULL,
  `apellidos` varchar(255) NULL,
  `fecha` date NULL,
  `hora` time NULL,
  `fecha_sesion` date NULL,
  `hora_sesion` time NULL,
  `estatus` int NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `transfer_entrada`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NULL,
  `fecha` date NULL,
  `hora` time NULL,
  `cantidad` double NULL,
  `id_producto` int(11) NULL,
  `clave_transfer` varchar(255) NULL,
  `id_almacen` int(11) NULL,
  `id_almacen_origen` int(11) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `transfer_salida`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NULL,
  `fecha` date NULL,
  `hora` time NULL,
  `cantidad` double NULL,
  `id_producto` int(11) NULL,
  `id_responsable` int(11) NULL,
  `codigo_transfer` varchar(255) NULL,
  `id_almacen` int(11) NULL,
  `id_almacen_destino` int(11) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `usuarios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NULL,
  `contraseña` varchar(255) NULL,
  `id_rol` int(11) NULL,
  `id_empresa` int(11) NULL,
  PRIMARY KEY (`id`)
);

