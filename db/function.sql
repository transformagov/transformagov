-- MySQL dump 10.13  Distrib 5.5.21, for linux2.6 (x86_64)
--
-- Host: localhost    Database: selecao
-- ------------------------------------------------------
-- Server version	5.5.21-log
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping routines for database 'selecao'
--
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 FUNCTION `remove_accents`(`str` TEXT) RETURNS text CHARSET latin1
    NO SQL
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN

    SET str = REPLACE(str,'Š','S');
    SET str = REPLACE(str,'š','s');
    SET str = REPLACE(str,'Ð','Dj');
    SET str = REPLACE(str,'Ž','Z');
    SET str = REPLACE(str,'ž','z');
    SET str = REPLACE(str,'À','A');
    SET str = REPLACE(str,'Á','A');
    SET str = REPLACE(str,'Â','A');
    SET str = REPLACE(str,'Ã','A');
    SET str = REPLACE(str,'Ä','A');
    SET str = REPLACE(str,'Å','A');
    SET str = REPLACE(str,'Æ','A');
    SET str = REPLACE(str,'Ç','C');
    SET str = REPLACE(str,'È','E');
    SET str = REPLACE(str,'É','E');
    SET str = REPLACE(str,'Ê','E');
    SET str = REPLACE(str,'Ë','E');
    SET str = REPLACE(str,'Ì','I');
    SET str = REPLACE(str,'Í','I');
    SET str = REPLACE(str,'Î','I');
    SET str = REPLACE(str,'Ï','I');
    SET str = REPLACE(str,'Ñ','N');
    SET str = REPLACE(str,'Ò','O');
    SET str = REPLACE(str,'Ó','O');
    SET str = REPLACE(str,'Ô','O');
    SET str = REPLACE(str,'Õ','O');
    SET str = REPLACE(str,'Ö','O');
    SET str = REPLACE(str,'Ø','O');
    SET str = REPLACE(str,'Ù','U');
    SET str = REPLACE(str,'Ú','U');
    SET str = REPLACE(str,'Û','U');
    SET str = REPLACE(str,'Ü','U');
    SET str = REPLACE(str,'Ý','Y');
    SET str = REPLACE(str,'Þ','B');
    SET str = REPLACE(str,'ß','Ss');
    SET str = REPLACE(str,'à','a');
    SET str = REPLACE(str,'á','a');
    SET str = REPLACE(str,'â','a');
    SET str = REPLACE(str,'ã','a');
    SET str = REPLACE(str,'ä','a');
    SET str = REPLACE(str,'å','a');
    SET str = REPLACE(str,'æ','a');
    SET str = REPLACE(str,'ç','c');
    SET str = REPLACE(str,'è','e');
    SET str = REPLACE(str,'é','e');
    SET str = REPLACE(str,'ê','e');
    SET str = REPLACE(str,'ë','e');
    SET str = REPLACE(str,'ì','i');
    SET str = REPLACE(str,'í','i');
    SET str = REPLACE(str,'î','i');
    SET str = REPLACE(str,'ï','i');
    SET str = REPLACE(str,'ð','o');
    SET str = REPLACE(str,'ñ','n');
    SET str = REPLACE(str,'ò','o');
    SET str = REPLACE(str,'ó','o');
    SET str = REPLACE(str,'ô','o');
    SET str = REPLACE(str,'õ','o');
    SET str = REPLACE(str,'ö','o');
    SET str = REPLACE(str,'ø','o');
    SET str = REPLACE(str,'ù','u');
    SET str = REPLACE(str,'ú','u');
    SET str = REPLACE(str,'û','u');
    SET str = REPLACE(str,'ý','y');
    SET str = REPLACE(str,'ý','y');
    SET str = REPLACE(str,'þ','b');
    SET str = REPLACE(str,'ÿ','y');
    SET str = REPLACE(str,'ƒ','f');


    RETURN str;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-29 10:36:53
