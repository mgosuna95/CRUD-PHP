/*
Navicat MySQL Data Transfer

Source Server         : UNIVERSAL MYSQL
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : test_pueblo_bonito

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2021-07-24 10:33:39
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
-- Procedure structure for Actualizar_Persona
-- ----------------------------
DROP PROCEDURE IF EXISTS `Actualizar_Persona`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Actualizar_Persona`(IN `nombresP` VARCHAR(100), IN `direccionP` VARCHAR(300), IN `edadP` INT, IN `idGeneroP`INT, IN `salarioP` VARCHAR(20), IN `idP` INT)
BEGIN
	#Routine body goes here...
	UPDATE personas SET nombres = nombresP, direccion = direccionP, edad = edadP, idGenero = idGeneroP, salario = salarioP WHERE personas.id = idP;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for Consultar_Generos
-- ----------------------------
DROP PROCEDURE IF EXISTS `Consultar_Generos`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Consultar_Generos`()
BEGIN
	#Routine body goes here...
	SELECT * FROM generos;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for Consultar_Persona
-- ----------------------------
DROP PROCEDURE IF EXISTS `Consultar_Persona`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Consultar_Persona`(IN `idP` bigint)
BEGIN
	#Routine body goes here...
	
SELECT id, nombres, direccion, edad, (SELECT descripcion from generos WHERE idGenero = generos.id) AS 'genero', idGenero, salario FROM	personas WHERE personas.id = idP;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for Consultar_Personas
-- ----------------------------
DROP PROCEDURE IF EXISTS `Consultar_Personas`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Consultar_Personas`()
BEGIN
	#Routine body goes here...
SELECT id, nombres, direccion, edad, (SELECT descripcion from generos WHERE idGenero = generos.id) AS 'genero', idGenero, salario FROM	personas;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for Consultar_Salario_Promedio_Por_Genero
-- ----------------------------
DROP PROCEDURE IF EXISTS `Consultar_Salario_Promedio_Por_Genero`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Consultar_Salario_Promedio_Por_Genero`()
BEGIN
	#Routine body goes here...
	SELECT descripcion, ROUND((SELECT AVG(salario) FROM personas WHERE idGenero = generos.id),2) AS 'PROMEDIO_POR_GENERO' FROM generos;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for Consultar_Salarios
-- ----------------------------
DROP PROCEDURE IF EXISTS `Consultar_Salarios`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Consultar_Salarios`()
BEGIN
		SELECT ROUND(SUM(salario),2) AS "TOTAL_SALARIOS"  FROM personas;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for Consultar_Salarios_Promedio
-- ----------------------------
DROP PROCEDURE IF EXISTS `Consultar_Salarios_Promedio`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Consultar_Salarios_Promedio`()
BEGIN
	#Routine body goes here...
	SELECT ROUND(AVG(salario),2) AS 'PROMEDIO_SALARIOS' FROM personas;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for Eliminar_Persona
-- ----------------------------
DROP PROCEDURE IF EXISTS `Eliminar_Persona`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Eliminar_Persona`(IN `idP` INT)
BEGIN
	#Routine body goes here...
	DELETE FROM personas WHERE personas.id = idP;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for Insertar_Persona
-- ----------------------------
DROP PROCEDURE IF EXISTS `Insertar_Persona`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `Insertar_Persona`(IN `nombresP` VARCHAR(100), IN `direccionP` VARCHAR(300), IN `edadP` INT, IN `idGeneroP`INT, IN `salarioP` DECIMAL)
BEGIN
	#Routine body goes here...
	INSERT INTO personas(`nombres`, `direccion`, `edad`, `idGenero`, `salario`) VALUES (nombresP, direccionP, edadP, idGeneroP, salarioP);
END
;;
DELIMITER ;

-- ----------------------------
-- Auto increment value for generos
-- ----------------------------
ALTER TABLE `generos` AUTO_INCREMENT=3;

-- ----------------------------
-- Auto increment value for personas
-- ----------------------------
ALTER TABLE `personas` AUTO_INCREMENT=72;
