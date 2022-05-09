/*
 Navicat Premium Data Transfer

 Source Server         : cert
 Source Server Type    : MySQL
 Source Server Version : 100422
 Source Host           : localhost:3306
 Source Schema         : cert

 Target Server Type    : MySQL
 Target Server Version : 100422
 File Encoding         : 65001

 Date: 09/05/2022 11:40:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for inv_campus_producto
-- ----------------------------

CREATE TABLE `inv_campus_producto`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NULL DEFAULT NULL,
  `id_campus` int(11) NULL DEFAULT NULL,
  `cantidad` double NULL DEFAULT NULL,
  `mod_fecha_entrada` date NULL DEFAULT NULL,
  `mod_hora_entrada` time(0) NULL DEFAULT NULL,
  `mod_fecha_salida` date NULL DEFAULT NULL,
  `mod_hora_salida` time(0) NULL DEFAULT NULL,
  `mod_id_usuario` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 173 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for inv_categoria
-- ----------------------------

CREATE TABLE `inv_categoria`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_area` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for inv_entrada_producto
-- ----------------------------

CREATE TABLE `inv_entrada_producto`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `hora` time(0) NULL DEFAULT NULL,
  `cantidad` double NULL DEFAULT NULL,
  `id_producto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `devolucion` int(11) NULL DEFAULT NULL,
  `id_usuario_dev` int(11) NULL DEFAULT NULL,
  `clave_solicitud` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_campus` int(11) NULL DEFAULT NULL,
  `factura` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total` double NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for inv_entrada_transferencia
-- ----------------------------

CREATE TABLE `inv_entrada_transferencia`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `hora` time(0) NULL DEFAULT NULL,
  `cantidad` double NULL DEFAULT NULL,
  `id_producto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `codigo_transfer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_campus` int(11) NULL DEFAULT NULL,
  `id_campus_origen` int(11) NULL DEFAULT NULL,
  `estatus` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for inv_niveles
-- ----------------------------

CREATE TABLE `inv_niveles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for inv_producto_foto
-- ----------------------------

CREATE TABLE `inv_producto_foto`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_producto` int(11) NULL DEFAULT NULL,
  `favorito` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for inv_productos
-- ----------------------------

CREATE TABLE `inv_productos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `numero_serie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fecha_registro` date NULL DEFAULT NULL,
  `hora_registro` time(0) NULL DEFAULT NULL,
  `id_usuario_alta` int(11) NULL DEFAULT NULL,
  `id_categoria` int(11) NULL DEFAULT NULL,
  `estatus` int(11) NULL DEFAULT NULL,
  `id_area` int(11) NULL DEFAULT NULL,
  `id_unidad` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 87 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for inv_salida_producto
-- ----------------------------

CREATE TABLE `inv_salida_producto`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `hora` time(0) NULL DEFAULT NULL,
  `cantidad` double NULL DEFAULT NULL,
  `cantidad_prestada` double NULL DEFAULT NULL,
  `id_producto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_solicitante` int(11) NULL DEFAULT NULL,
  `prestamo` int(11) NULL DEFAULT NULL,
  `estatus` int(11) NULL DEFAULT NULL,
  `clave_solicitud` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_usuario_mod_pres` int(11) NULL DEFAULT NULL,
  `id_campus` int(11) NULL DEFAULT NULL,
  `proyecto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for inv_salida_transferencia
-- ----------------------------

CREATE TABLE `inv_salida_transferencia`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `hora` time(0) NULL DEFAULT NULL,
  `cantidad` double NULL DEFAULT NULL,
  `id_producto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_responsable` int(11) NULL DEFAULT NULL,
  `codigo_transfer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_campus` int(11) NULL DEFAULT NULL,
  `id_campus_destino` int(11) NULL DEFAULT NULL,
  `estatus` int(11) NULL DEFAULT NULL,
  `cantidad_enviada` double NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for inv_subareas
-- ----------------------------

CREATE TABLE `inv_subareas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `estatus` int(11) NULL DEFAULT NULL,
  `id_area` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for inv_unidades
-- ----------------------------

CREATE TABLE `inv_unidades`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `abreviacion` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
