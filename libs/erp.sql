-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'usuarios'
-- 
-- ---

DROP TABLE IF EXISTS `usuarios`;
		
CREATE TABLE `usuarios` (
  `id_usr` INTEGER(11) NULL AUTO_INCREMENT,
  `nombre_usr` VARCHAR(50),
  `correo_usr` VARCHAR(50),
  `password_usr` VARCHAR(50),
  `telefono_usr` VARCHAR(50),
  `direccion_usr` VARCHAR(50),
  `id_perfil` INTEGER(11) NULL,
  PRIMARY KEY (`id_usr`)
);

-- ---
-- Table 'perfiles'
-- 
-- ---

DROP TABLE IF EXISTS `perfiles`;
		
CREATE TABLE `perfiles` (
  `id_perfil` INTEGER(11) NULL AUTO_INCREMENT,
  `nombre_perfil` VARCHAR(50),
  `consultar` VARCHAR(50),
  `insertar` VARCHAR(50),
  `editar` VARCHAR(50),
  `eliminar` VARCHAR(50),
  PRIMARY KEY (`id_perfil`)
);

-- ---
-- Table 'modulos'
-- 
-- ---

DROP TABLE IF EXISTS `modulos`;
		
CREATE TABLE `modulos` (
  `id_modulo` INTEGER(11) NULL AUTO_INCREMENT,
  `nombre_modulo` VARCHAR(50),
  `icono_modulo` VARCHAR(30),
  PRIMARY KEY (`id_modulo`)
);

-- ---
-- Foreign Keys 
-- ---

ALTER TABLE `usuarios` ADD FOREIGN KEY (id_perfil) REFERENCES `perfiles` (`id_perfil`);

INSERT INTO `modulos` (`id_modulo`, `nombre_modulo`, `icono_modulo`) VALUES (NULL, 'usuarios', 'pe-7s-users'), (NULL, 'perfiles', 'pe-7s-user'), (NULL, 'modulos', 'pe-7s-graph2');
INSERT INTO `perfiles` (`id_perfil`, `nombre_perfil`, `consultar`, `insertar`, `editar`, `eliminar`) VALUES (NULL, 'Administrador', '1 2 3', '1 2 3', '1 2 3', '1 2 3');
INSERT INTO `usuarios` (`id_usr`, `nombre_usr`, `correo_usr`, `password_usr`, `telefono_usr`, `direccion_usr`, `id_perfil`) VALUES (NULL, 'Administrador', 'admin@gmail.com', '12345', '1234567890', 'calle admin', '1');