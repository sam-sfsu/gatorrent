CREATE TABLE IF NOT EXISTS `f16g13`.`Renters`(
   `renterId` int(9),
   `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
   `firstName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
   `lastName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
   `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
   `createdDate` datetime DEFAULT CURRENT_TIMESTAMP COLLATE utf8_unicode_ci,
   `modifiedDate` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COLLATE utf8_unicode_ci,
   PRIMARY KEY (`renterId`),
   UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `f16g13`.`Lessors`(
   `lessorId` int(9) AUTO_INCREMENT,
   `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
   `firstName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
   `lastName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
   `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
   `createdDate` datetime DEFAULT CURRENT_TIMESTAMP COLLATE utf8_unicode_ci,
   `modifiedDate` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COLLATE utf8_unicode_ci,
   PRIMARY KEY (`lessorId`),
   UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `f16g13`.`Apartments`(
   `apartmentId` int(9) AUTO_INCREMENT,
   `lessorId` int (9),
   `title` varchar(60) COLLATE utf8_unicode_ci,
   `streetAddress` varchar(100) COLLATE utf8_unicode_ci,
   `zipcode`int (5),
   `price`int (5),
   `rooms`int (1),
   `baths`int (1),
   `description` varchar(512) COLLATE utf8_unicode_ci,
   `createdDate` datetime DEFAULT CURRENT_TIMESTAMP COLLATE utf8_unicode_ci,
   `modifiedDate` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COLLATE utf8_unicode_ci,
   `picture1` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
   `picture2` varchar(200) COLLATE utf8_unicode_ci,
   `picture3` varchar(200) COLLATE utf8_unicode_ci,
   `picture4` varchar(200) COLLATE utf8_unicode_ci,
   `isAvailable` boolean DEFAULT true,
   PRIMARY KEY (`apartmentId`),
   FOREIGN KEY(`lessorId`) REFERENCES `f16g13`.`Lessors`(`lessorId`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
