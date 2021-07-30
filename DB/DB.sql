/*
Navicat MySQL Data Transfer

Source Server         : UNIVERSAL MYSQL
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : test_pueblo_bonito

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2021-07-24 10:33:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for generos
-- ----------------------------
DROP TABLE IF EXISTS `generos`;
CREATE TABLE `generos` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`descripcion`  varchar(20) CHARACTER SET utf16 COLLATE utf16_general_ci NULL DEFAULT '' ,
`abreviatura`  varchar(5) CHARACTER SET utf16 COLLATE utf16_general_ci NULL DEFAULT '' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf16 COLLATE=utf16_general_ci
AUTO_INCREMENT=3

;

-- ----------------------------
-- Records of generos
-- ----------------------------
BEGIN;
INSERT INTO `generos` VALUES ('1', 'Femenino', 'F'), ('2', 'Masculino', 'M');
COMMIT;

-- ----------------------------
-- Table structure for personas
-- ----------------------------
DROP TABLE IF EXISTS `personas`;
CREATE TABLE `personas` (
`id`  bigint(20) NOT NULL AUTO_INCREMENT ,
`nombres`  varchar(100) CHARACTER SET utf16 COLLATE utf16_general_ci NULL DEFAULT '' ,
`direccion`  varchar(300) CHARACTER SET utf16 COLLATE utf16_general_ci NULL DEFAULT '' ,
`edad`  int(11) NULL DEFAULT '' ,
`idGenero`  int(11) NOT NULL ,
`salario`  decimal(10,2) NULL DEFAULT '' ,
PRIMARY KEY (`id`),
FOREIGN KEY (`idGenero`) REFERENCES `generos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
INDEX `personas_ibfk_1` (`idGenero`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf16 COLLATE=utf16_general_ci
AUTO_INCREMENT=72

;

-- ----------------------------
-- Records of personas
-- ----------------------------
BEGIN;
INSERT INTO `personas` VALUES ('71', 'Manuel', 'Mar Mediterraneo', '25', '2', '20000.00');
COMMIT;

-- ----------------------------
-- Auto increment value for generos
-- ----------------------------
ALTER TABLE `generos` AUTO_INCREMENT=3;

-- ----------------------------
-- Auto increment value for personas
-- ----------------------------
ALTER TABLE `personas` AUTO_INCREMENT=72;
