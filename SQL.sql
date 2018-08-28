ALTER DATABASE mydb charset=utf8;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `privilege` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `volunteers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fathers_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT ' ',
  `phone_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT '-',
  `group_num` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) DEFAULT '0',
  `shift` int(11) NOT NULL,
  `privilege` int(11) NOT NULL DEFAULT '0',
  `rest_day` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `volunteer` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `shift` int(11) NOT NULL DEFAULT '1',
  `volunteer_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `busy` int(11) NOT NULL DEFAULT '0',
  `volunteer_id` int(11) DEFAULT '0',
  `department_type` varchar(10) COLLATE utf8_unicode_ci DEFAULT 's',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO users (full_name, username, password, phone_number, email, privilege)
VALUES ('ORXAN HUSEYNLI', 'administrator-01', MD5('hFHW5ZD9'), '+994509789914', 'ohuseynli2018@ada.edu.az', 1);

INSERT INTO users (full_name, username, password, phone_number, email, privilege)
VALUES ('ORXAN HUSEYNLI', 'ohuseynli2018', MD5('orkhan96'), '+994509789914', 'eauditory3@gmail.com', 0);

INSERT INTO volunteers (first_name, last_name, fathers_name, phone_number, email, group_num, shift)
VALUES ('Arzu','Vəliyev','Ülfət','+994559060690','someone@example.com','K55M1', 1);