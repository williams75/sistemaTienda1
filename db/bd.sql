-- MySQL Workbench Synchronization
-- Generated: 2022-09-22 16:01
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: leone

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

ALTER SCHEMA `sis_com`  DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_general_ci ;

CREATE TABLE IF NOT EXISTS `sis_com`.`persona` (
  `id_persona` INT(11) NOT NULL AUTO_INCREMENT,
  `cargos_id_cargos` INT(11) NOT NULL,
  `nombre_completo` VARCHAR(100) NULL DEFAULT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `password` VARCHAR(250) NULL DEFAULT NULL,
  `telefono` VARCHAR(30) NULL DEFAULT NULL,
  `token` VARCHAR(150) NULL DEFAULT NULL,
  `fecha` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_persona`),
  INDEX `fk_personal_cargos_idx` (`cargos_id_cargos` ASC) VISIBLE,
  CONSTRAINT `fk_personal_cargos`
    FOREIGN KEY (`cargos_id_cargos`)
    REFERENCES `sis_com`.`cargo` (`id_cargo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`cargo` (
  `id_cargo` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre_cargo` VARCHAR(50) NULL DEFAULT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `estado` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_cargo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`permisos` (
  `id_permisos` INT(11) NOT NULL AUTO_INCREMENT,
  `modulo_id_modulo` INT(11) NOT NULL,
  `cargos_id_cargos` INT(11) NOT NULL,
  `crear` INT(11) NULL DEFAULT NULL,
  `eliminar` INT(11) NULL DEFAULT NULL,
  `modificar` INT(11) NULL DEFAULT NULL,
  `ver` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_permisos`),
  INDEX `fk_permisos_cargos1_idx` (`cargos_id_cargos` ASC) VISIBLE,
  INDEX `fk_permisos_modulo1_idx` (`modulo_id_modulo` ASC) VISIBLE,
  CONSTRAINT `fk_permisos_cargos1`
    FOREIGN KEY (`cargos_id_cargos`)
    REFERENCES `sis_com`.`cargo` (`id_cargo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permisos_modulo1`
    FOREIGN KEY (`modulo_id_modulo`)
    REFERENCES `sis_com`.`modulo` (`id_modulo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`modulo` (
  `id_modulo` INT(11) NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(50) NULL DEFAULT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `estado` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_modulo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`categoria` (
  `id_categoria` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NULL DEFAULT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `portada` VARCHAR(100) NULL DEFAULT NULL,
  `fecha` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_categoria`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`producto` (
  `id_producto` INT(11) NOT NULL AUTO_INCREMENT,
  `categoria_id_categoria` INT(11) NOT NULL,
  `barra` INT(11) NULL DEFAULT NULL,
  `nombre_producto` VARCHAR(70) NULL DEFAULT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `cantidad` INT(11) NULL DEFAULT NULL,
  `fecha` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `imagen` VARCHAR(100) NULL DEFAULT NULL,
  `estado` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  INDEX `fk_producto_categoria1_idx` (`categoria_id_categoria` ASC) VISIBLE,
  CONSTRAINT `fk_producto_categoria1`
    FOREIGN KEY (`categoria_id_categoria`)
    REFERENCES `sis_com`.`categoria` (`id_categoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`kardex` (
  `id_kardex` INT(11) NOT NULL AUTO_INCREMENT,
  `producto_id_producto` INT(11) NOT NULL,
  `cant_entrada` INT(11) NULL DEFAULT NULL,
  `cant_salida` INT(11) NULL DEFAULT NULL,
  `cant_saldo` INT(11) NULL DEFAULT NULL,
  `costo_compra` DECIMAL(12,2) NULL DEFAULT NULL,
  `costo_venta` DECIMAL(12,2) NULL DEFAULT NULL,
  `valor_entrada` DECIMAL(12,2) NULL DEFAULT NULL,
  `valor_salida` DECIMAL(12,2) NULL DEFAULT NULL,
  `valor_saldo` DECIMAL(12,2) NULL DEFAULT NULL,
  `fecha` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id_kardex`),
  INDEX `fk_kardex_producto1_idx` (`producto_id_producto` ASC) VISIBLE,
  CONSTRAINT `fk_kardex_producto1`
    FOREIGN KEY (`producto_id_producto`)
    REFERENCES `sis_com`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`precios` (
  `id_precios` INT(11) NOT NULL AUTO_INCREMENT,
  `producto_id_producto` INT(11) NOT NULL,
  `precio_a` DECIMAL(12,2) NULL DEFAULT NULL,
  `precio_b` DECIMAL(12,2) NULL DEFAULT NULL,
  `precio_c` DECIMAL(12,2) NULL DEFAULT NULL,
  `precio_d` DECIMAL(12,2) NULL DEFAULT NULL,
  `precio_e` DECIMAL(12,2) NULL DEFAULT NULL,
  PRIMARY KEY (`id_precios`),
  INDEX `fk_precios_producto1_idx` (`producto_id_producto` ASC) VISIBLE,
  CONSTRAINT `fk_precios_producto1`
    FOREIGN KEY (`producto_id_producto`)
    REFERENCES `sis_com`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`venta` (
  `id_venta` INT(11) NOT NULL AUTO_INCREMENT,
  `persona_id_persona` INT(11) NOT NULL,
  `fecha_venta` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `monto` DECIMAL(12,2) NULL DEFAULT NULL,
  `transaccion_det` VARCHAR(250) NULL DEFAULT NULL,
  PRIMARY KEY (`id_venta`),
  INDEX `fk_venta_persona1_idx` (`persona_id_persona` ASC) VISIBLE,
  CONSTRAINT `fk_venta_persona1`
    FOREIGN KEY (`persona_id_persona`)
    REFERENCES `sis_com`.`persona` (`id_persona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`tipopago` (
  `id_tipopago` INT(11) NOT NULL AUTO_INCREMENT,
  `venta_id_venta` INT(11) NOT NULL,
  `efectivo` DECIMAL(12,2) NULL DEFAULT NULL,
  `transferencia` DECIMAL(12,2) NULL DEFAULT NULL,
  `tarjeta` DECIMAL(12,2) NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipopago`),
  INDEX `fk_tipopago_venta1_idx` (`venta_id_venta` ASC) VISIBLE,
  CONSTRAINT `fk_tipopago_venta1`
    FOREIGN KEY (`venta_id_venta`)
    REFERENCES `sis_com`.`venta` (`id_venta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`detalle_venta` (
  `id_detalle_venta` INT(11) NOT NULL AUTO_INCREMENT,
  `producto_id_producto` INT(11) NOT NULL,
  `venta_id_venta` INT(11) NOT NULL,
  `cantidad` INT(11) NULL DEFAULT NULL,
  `precio` DECIMAL(12,2) NULL DEFAULT NULL,
  PRIMARY KEY (`id_detalle_venta`),
  INDEX `fk_detalle_venta_producto1_idx` (`producto_id_producto` ASC) VISIBLE,
  INDEX `fk_detalle_venta_venta1_idx` (`venta_id_venta` ASC) VISIBLE,
  CONSTRAINT `fk_detalle_venta_producto1`
    FOREIGN KEY (`producto_id_producto`)
    REFERENCES `sis_com`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_venta_venta1`
    FOREIGN KEY (`venta_id_venta`)
    REFERENCES `sis_com`.`venta` (`id_venta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`detalle_temp` (
  `id_detalle_temp` INT(11) NOT NULL,
  `persona_id_persona` INT(11) NOT NULL,
  `producto_id_producto` INT(11) NOT NULL,
  `cantidad` INT(11) NULL DEFAULT NULL,
  `precio` DECIMAL(12,2) NULL DEFAULT NULL,
  PRIMARY KEY (`id_detalle_temp`),
  INDEX `fk_detalle_temp_persona1_idx` (`persona_id_persona` ASC) VISIBLE,
  INDEX `fk_detalle_temp_producto1_idx` (`producto_id_producto` ASC) VISIBLE,
  CONSTRAINT `fk_detalle_temp_persona1`
    FOREIGN KEY (`persona_id_persona`)
    REFERENCES `sis_com`.`persona` (`id_persona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_temp_producto1`
    FOREIGN KEY (`producto_id_producto`)
    REFERENCES `sis_com`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`caja` (
  `id_caja` INT(11) NOT NULL AUTO_INCREMENT,
  `cuenta` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`id_caja`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `sis_com`.`balance` (
  `id_balance` INT(11) NOT NULL AUTO_INCREMENT,
  `persona_id_persona` INT(11) NOT NULL,
  `caja_id_caja` INT(11) NOT NULL,
  `importe` VARCHAR(45) NULL DEFAULT NULL,
  `fecha` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `detalle` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id_balance`),
  INDEX `fk_balance_persona1_idx` (`persona_id_persona` ASC) VISIBLE,
  INDEX `fk_balance_caja1_idx` (`caja_id_caja` ASC) VISIBLE,
  CONSTRAINT `fk_balance_persona1`
    FOREIGN KEY (`persona_id_persona`)
    REFERENCES `sis_com`.`persona` (`id_persona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_balance_caja1`
    FOREIGN KEY (`caja_id_caja`)
    REFERENCES `sis_com`.`caja` (`id_caja`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
