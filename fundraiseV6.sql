-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2017 at 04:17 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fundraise`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `UPDATE_PROJECT` ()  BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE var_projid INT(11);
  DECLARE var_projminfundreq INT(11);
  DECLARE var_projfunddeadline DATETIME;
  DECLARE var_projfundcollected INT(11);
  DECLARE var_projmaxfundreq INT(11);
  DECLARE var_projstatus VARCHAR(45);
  DECLARE cur1 CURSOR FOR SELECT projid, projminfundreq, projmaxfundreq, projfunddeadlinedatetime, projfundcollected, projstatus FROM project;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  OPEN cur1;
  read_loop: LOOP
    FETCH cur1 INTO var_projid, var_projminfundreq, var_projmaxfundreq, var_projfunddeadline, var_projfundcollected, var_projstatus;
    IF done THEN
      LEAVE read_loop;
    END IF;
    IF current_timestamp >=var_projfunddeadline THEN
        
        IF var_projfundcollected < var_projminfundreq THEN
        # Set the status of the project to failed
            UPDATE project SET projstatus = "Failed" WHERE projid = var_projid;
        ELSE  
        # Set the status of the project to successful Funded
            UPDATE project SET projstatus = "Funded", projfundraisedatetime = var_projfunddeadline WHERE projid = var_projid AND projstatus <> "Executed" AND projstatus <> "Failed";
		END IF;
    ELSE IF var_projfundcollected = var_projmaxfundreq THEN
        UPDATE project SET projstatus = "Funded", projfundraisedatetime = current_timestamp WHERE projid = var_projid AND projstatus <> "Executed";
    END IF;
    END IF;
    BLOCK2: BEGIN
            DECLARE done1 INT DEFAULT FALSE;
            DECLARE var_spon_projid INT(11);
            DECLARE var_spon_uid INT(11);
            DECLARE var_spon_cardno BIGINT(13);
           # DECLARE var_spon_sdatetime DATETIME;
            DECLARE var_spon_samount INT(11);
            DECLARE cur2 CURSOR FOR SELECT projid,uid,cardno,sum(samount) from sponsor where projid=var_projid AND 
			projid NOT IN (SELECT projid FROM transaction) group by projid,cardno,uid;
            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done1 = TRUE;
            OPEN cur2; 
			read_sponsor_loop: LOOP
            FETCH cur2 INTO var_spon_projid,var_spon_uid,var_spon_cardno,var_spon_samount;   
            IF done1 THEN
            LEAVE read_sponsor_loop;
            END IF; 
            IF var_projstatus='Funded' OR var_projstatus='Executed' THEN
            #Req fund collected then create transaction entry
                INSERT INTO transaction values (var_spon_projid,var_spon_uid,var_spon_cardno,current_timestamp,var_spon_samount);
			END IF;
            END LOOP read_sponsor_loop;
            CLOSE cur2;
            END BLOCK2;
  END LOOP read_loop;
  CLOSE cur1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `carddetail`
--

CREATE TABLE `carddetail` (
  `cardno` bigint(13) NOT NULL,
  `cardexpiry` date NOT NULL,
  `cardname` varchar(45) NOT NULL,
  `cardcvv` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `carddetail`
--

INSERT INTO `carddetail` (`cardno`, `cardexpiry`, `cardname`, `cardcvv`) VALUES
(1122445599222233, '2019-02-04', 'Bob Brooklyn Builder', 129),
(1254256356982785, '2019-06-30', 'Gary', 963),
(2345891023567893, '2018-04-04', 'Bob Brooklyn Builder', 824),
(3652254137854856, '2020-03-31', 'Tom', 852),
(7896541323652856, '2020-01-31', 'Andrew', 122),
(9856854744521523, '2021-05-31', 'Lisa', 500);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryid` int(11) NOT NULL,
  `categoryname` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryid`, `categoryname`) VALUES
(301, 'Art '),
(302, 'Music '),
(303, 'Theater '),
(304, 'Fashion'),
(306, 'Design '),
(307, 'Dance'),
(308, 'Film'),
(309, 'Food'),
(310, 'Games'),
(311, 'Photography'),
(312, 'Journalism'),
(313, 'Technology'),
(314, 'Health');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `projid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cdatetime` datetime NOT NULL,
  `cdescription` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`projid`, `uid`, `cdatetime`, `cdescription`) VALUES
(101, 1, '2017-01-30 18:34:11', 'I am not at all ambitious. Pls support'),
(101, 2, '2017-01-20 15:15:45', 'We will surely support you for this event. We are very excited. Please go on'),
(101, 3, '2017-01-30 17:34:11', 'You are very very ambitious'),
(102, 3, '2016-06-12 13:34:00', 'When will be dates of the release. Pls tell me. '),
(104, 3, '2016-06-12 12:12:00', 'Thank you for supporting me'),
(104, 5, '2016-06-12 12:07:00', 'You are doing a great cause. Keep doing it. '),
(105, 1, '2017-06-10 07:01:00', 'Hii, Wwhat flavours will u be releasing in?'),
(105, 4, '2017-06-10 07:01:00', 'Strawberry, Ginger, Raspberry, and many more. Seems yummy right'),
(106, 3, '2017-01-15 11:59:59', 'Idea is not appropriate.'),
(106, 6, '2017-04-10 11:35:00', '(Y). Keep going.');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `uid` int(11) NOT NULL,
  `followsid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`uid`, `followsid`) VALUES
(4, 1),
(1, 2),
(5, 2),
(1, 3),
(1, 4),
(3, 4),
(6, 4),
(2, 5),
(3, 5),
(5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `projid` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`projid`, `uid`) VALUES
(104, 1),
(105, 1),
(106, 1),
(101, 2),
(104, 2),
(105, 2),
(106, 2),
(101, 3),
(105, 3),
(106, 3),
(102, 4),
(106, 4),
(102, 5),
(103, 5),
(104, 5),
(103, 6),
(104, 6),
(106, 6);

-- --------------------------------------------------------

--
-- Table structure for table `mediaattachment`
--

CREATE TABLE `mediaattachment` (
  `maid` int(11) NOT NULL,
  `projid` int(11) NOT NULL,
  `updatedatetime` datetime NOT NULL,
  `mediauri` varchar(200) NOT NULL,
  `mtypeid` int(11) NOT NULL,
  `mcaption` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mediatype`
--

CREATE TABLE `mediatype` (
  `mtypeid` int(11) NOT NULL,
  `mname` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mediatype`
--

INSERT INTO `mediatype` (`mtypeid`, `mname`) VALUES
(1, 'image'),
(2, 'mp3'),
(3, 'video');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `projid` int(11) NOT NULL,
  `projcreatorid` int(11) NOT NULL,
  `projname` varchar(45) CHARACTER SET utf8 NOT NULL,
  `projdescription` varchar(300) CHARACTER SET utf8 NOT NULL,
  `categoryid` int(11) NOT NULL,
  `projpostingdatetime` datetime NOT NULL,
  `projminfundreq` int(11) NOT NULL,
  `projmaxfundreq` int(11) NOT NULL,
  `projfunddeadlinedatetime` datetime NOT NULL,
  `projfundraisedatetime` datetime DEFAULT NULL,
  `projcompledatetime` datetime DEFAULT NULL,
  `projstatus` varchar(45) CHARACTER SET utf8 NOT NULL,
  `projcoverimage` varchar(200) CHARACTER SET utf8 NOT NULL,
  `projfundcollected` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=big5;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`projid`, `projcreatorid`, `projname`, `projdescription`, `categoryid`, `projpostingdatetime`, `projminfundreq`, `projmaxfundreq`, `projfunddeadlinedatetime`, `projfundraisedatetime`, `projcompledatetime`, `projstatus`, `projcoverimage`, `projfundcollected`) VALUES
(101, 1, 'Back street boys music album', 'new album metal music', 302, '2017-01-15 12:15:30', 15000, 20000, '2017-04-18 22:15:17', '2017-04-18 22:15:17', NULL, 'Funded', './uploads/projectcover/9b59a832b925dbfbfdc8a2d39f6b5342.jpg', 28500),
(102, 5, 'vidya vox music', 'new cover albums with mashups', 302, '2016-05-11 11:55:00', 5000, 10000, '2017-04-15 11:59:59', '2017-04-15 11:59:59', '2017-06-15 11:59:59', 'Executed', './uploads/projectcover/b4e41f4f1a33dee5dc5abd4ed3da1d2f.jpeg', 7000),
(103, 2, 'Jazz Music Album', 'new music album for jazz genre', 302, '2017-01-12 12:23:00', 5000, 10000, '2017-04-22 23:59:59', NULL, NULL, 'Active', './uploads/projectcover/8b08bb66d1e266a7a4d51238a8cb3a13.jpeg', 2000),
(104, 3, 'driverless car', 'testing driverless car module', 313, '2016-04-12 01:05:00', 100000, 125000, '2017-12-03 23:59:59', NULL, NULL, 'Active', '', 0),
(105, 4, 'cup cake business', 'FOOD', 309, '2016-02-10 05:01:00', 250000, 275000, '2017-02-09 23:59:59', '2017-02-09 23:59:59', NULL, 'Funded', './uploads/projectcover/5f6f01db4418a0ba06212569d78e4ce8.jpg', 270000),
(106, 5, 'Designer Lakme fashion week', 'Hii we are holding xvz event at NYU.', 304, '2017-01-10 05:01:00', 10000, 15000, '2017-02-28 23:59:59', '2017-02-28 23:59:59', '2017-04-12 15:08:59', 'Executed', './uploads/projectcover/591e55bc7a9c7a055219c54ef4702e14.jpg', 13000),
(107, 6, 'Hip Hop Dance Show', 'Hii we are holding a Hip Hop event in washington DC. We are planning to call a famous dancer. Pls help us ', 307, '2016-12-15 11:59:59', 5000, 10000, '2017-01-15 23:59:59', NULL, NULL, 'Failed', './uploads/projectcover/1aeb5f6d600f40cc7d4c1b849071ce7f.jpg', 0),
(108, 5, 'Healthy Food Startup', 'We are providing good health organic food', 309, '2016-01-15 12:15:30', 10000, 15000, '2016-12-01 23:59:59', '2016-12-01 23:59:59', '2017-01-31 15:55:50', 'Executed', './uploads/projectcover/bf30bed5d895505c6d8825cd404db8a5.png', 15000),
(109, 5, 'Yoga Classes', 'Fitness Yoga Class, every week at Times Square', 314, '2016-07-15 14:15:30', 15000, 30000, '2016-12-15 23:59:59', '2016-12-15 23:59:59', '2017-04-15 23:59:59', 'Executed', './uploads/projectcover/b35e610cfe3123d95dba367891e6bd7e.jpg', 20000),
(110, 7, 'BUCKY PIZZARELLI Revamp ', 'Hey, we are making a music album re creating the classic jazz album named Bucky pizzarelli ', 302, '2017-02-04 21:00:00', 2500, 10000, '2017-04-19 02:15:30', '2017-04-19 01:17:02', NULL, 'Funded', './uploads/projectcover/d8fa9533628b9c39c940b87e81c647ac.jpg\r\n', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `projtags`
--

CREATE TABLE `projtags` (
  `projid` int(11) NOT NULL,
  `tag` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projtags`
--

INSERT INTO `projtags` (`projid`, `tag`) VALUES
(101, 'jazz'),
(101, 'metal music'),
(102, 'mashup'),
(103, 'jazz'),
(104, 'driveless'),
(104, 'innovative'),
(105, 'cakes'),
(105, 'food'),
(106, 'designer'),
(106, 'fashion'),
(106, 'glamour'),
(107, 'dance'),
(107, 'hiphop');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `projid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `rdatetime` datetime NOT NULL,
  `nostars` tinyint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`projid`, `uid`, `rdatetime`, `nostars`) VALUES
(102, 3, '2017-06-17 11:59:59', 3),
(106, 3, '2017-04-18 15:08:59', 5),
(106, 6, '2017-04-14 15:08:59', 4),
(108, 1, '2017-02-03 16:55:50', 5),
(108, 4, '2017-02-08 14:23:50', 5),
(109, 1, '2017-04-18 05:59:59', 4),
(109, 6, '2017-04-19 15:59:59', 5);

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

CREATE TABLE `sponsor` (
  `projid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cardno` bigint(13) NOT NULL,
  `sdatetime` datetime NOT NULL,
  `samount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sponsor`
--

INSERT INTO `sponsor` (`projid`, `uid`, `cardno`, `sdatetime`, `samount`) VALUES
(101, 1, 1122445599222233, '2017-04-14 00:00:00', 8500),
(101, 4, 1122445599222233, '2017-04-15 12:15:30', 3000),
(101, 4, 1122445599222233, '2017-06-15 11:59:59', 4000),
(101, 4, 7896541323652856, '2017-03-15 12:15:30', 6000),
(101, 6, 1254256356982785, '2017-05-15 17:15:30', 7000),
(102, 2, 9856854744521523, '2017-03-15 11:59:59', 2000),
(102, 3, 9856854744521523, '2017-04-15 11:59:59', 5000),
(103, 4, 1122445599222233, '2017-01-17 11:28:35', 2000),
(105, 1, 1122445599222233, '2016-03-15 15:34:00', 100000),
(105, 1, 1122445599222233, '2017-01-15 18:39:00', 120000),
(105, 2, 9856854744521523, '2017-01-17 17:25:00', 50000),
(106, 3, 1254256356982785, '2017-01-28 23:59:59', 7000),
(106, 6, 1254256356982785, '2017-02-21 12:59:59', 6000),
(108, 1, 1122445599222233, '2016-05-01 12:59:59', 5000),
(108, 4, 1122445599222233, '2016-11-01 23:59:59', 10000),
(109, 1, 1122445599222233, '2016-11-30 19:15:30', 3000),
(109, 6, 1254256356982785, '2016-07-15 13:45:59', 17000),
(110, 1, 1122445599222233, '2017-03-16 00:00:00', 1200),
(110, 1, 1122445599222233, '2017-04-14 00:00:00', 8500),
(110, 2, 1254256356982785, '2017-04-16 00:00:00', 300);

--
-- Triggers `sponsor`
--
DELIMITER $$
CREATE TRIGGER `DELETE_projfund` AFTER DELETE ON `sponsor` FOR EACH ROW BEGIN
	UPDATE project p
    SET p.projfundcollected = p.projfundcollected - OLD.samount
    WHERE p.projid = OLD.projid;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `INSERT_projfund` AFTER INSERT ON `sponsor` FOR EACH ROW BEGIN
	DECLARE fundraised INT;
    DECLARE projectid INT; 
    SET @projectid = NEW.projid;

	SET @fundraised = (SELECT SUM(samount) FROM sponsor WHERE projid = @projectid GROUP BY projid); 
		
	UPDATE project SET projfundcollected = @fundraised WHERE projid = @projectid;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UPDATE_projfund` AFTER UPDATE ON `sponsor` FOR EACH ROW BEGIN
	UPDATE project p
    SET p.projfundcollected = p.projfundcollected - OLD.samount
    WHERE p.projid = OLD.projid;
    
    UPDATE project p
    SET p.projfundcollected = p.projfundcollected + NEW.samount
    WHERE p.projid = NEW.projid;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Updateprojfund` AFTER UPDATE ON `sponsor` FOR EACH ROW BEGIN
	UPDATE project p
    SET p.projfundcollected = p.projfundcollected - OLD.samount
    WHERE p.projid = OLD.projid;
    
    UPDATE project p
    SET p.projfundcollected = p.projfundcollected + NEW.samount
    WHERE p.projid = NEW.projid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `projid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cardno` bigint(13) NOT NULL,
  `tdatetime` datetime NOT NULL,
  `tamount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`projid`, `uid`, `cardno`, `tdatetime`, `tamount`) VALUES
(101, 4, 1122445599222233, '2017-04-19 00:18:16', 7000),
(101, 4, 7896541323652856, '2017-04-19 00:18:16', 6000),
(101, 6, 1254256356982785, '2017-04-19 00:18:16', 7000),
(102, 2, 9856854744521523, '2017-04-19 00:18:16', 2000),
(102, 3, 9856854744521523, '2017-04-19 00:18:16', 5000),
(105, 1, 1122445599222233, '2017-04-19 00:18:16', 220000),
(105, 2, 9856854744521523, '2017-04-19 00:18:16', 50000),
(106, 3, 1254256356982785, '2017-04-19 00:18:16', 7000),
(106, 6, 1254256356982785, '2017-04-19 00:18:16', 6000),
(108, 1, 1122445599222233, '2017-04-19 00:18:16', 5000),
(108, 4, 1122445599222233, '2017-04-19 00:18:16', 10000),
(109, 1, 1122445599222233, '2017-04-19 00:18:17', 3000),
(109, 6, 1254256356982785, '2017-04-19 00:18:17', 17000);

-- --------------------------------------------------------

--
-- Table structure for table `update`
--

CREATE TABLE `update` (
  `projid` int(11) NOT NULL,
  `updatedatetime` datetime NOT NULL,
  `updatedescription` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `uname` varchar(45) NOT NULL,
  `uemail` varchar(45) NOT NULL,
  `upassword` char(64) NOT NULL,
  `uhometown` varchar(45) DEFAULT NULL,
  `ucontactno` bigint(13) DEFAULT NULL,
  `image` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `uname`, `uemail`, `upassword`, `uhometown`, `ucontactno`, `image`) VALUES
(1, 'BobInBrooklyn', 'BobtheBrooklyn123@gmail.com', 'd21a4d2d4c52638ef402b2546a014c72bb4d383c7ccb45a25d5927e250bec7fa', 'Jersey City', 7896543213, ''),
(2, 'Lisa', 'lisa123@gmail.com', '864282b76c39e6748fa8b9accb2953bc89a3ec4f6c5ca1627624d6a58edd5619', 'Los Angeles', 7854123696, ''),
(3, 'Gary', 'gary007@gmail.com', 'c5e2108863cd0519af498f65366ba883f7d2927c8e29073c8d1196d35ce82097', 'Jersey City', 1234567892, ''),
(4, 'Andrew', 'andrew234@gmail.com', 'dc7c5f8b4f733cfbc451d562a5339450d25a18b1201419832ce7fd6d0628d924', 'Pittsburgh', 8569327411, ''),
(5, 'John', 'john007@gmail.com', '068ccdf825f7a983b68cce04ef88427fd7e9b7234ffe3bb50ecefc069dc3f576', 'Chicago', 8789081234, ''),
(6, 'Mark', 'mark123@gmail.com', '191e9365bb9cd72ce89892c3496b844b1ffd963a7f295cdc410ede01e57c3fb2', 'Denver', 4352346829, ''),
(7, 'Micheal', 'michealross@gmail.com', 'c7419350c3bc20ef89806cca7b55f001593f17b7ad09d13dd2d00ed74e2158aa', 'Edison', 5516789012, ''),
(8, 'Ross', 'rosstaylor@outlook.com', 'd60bf516e2641db935721798682bd7b63dbf42c2f408ca2622a8faef0780a3e0', 'Seattle', 8912345672, ''),
(10, 'Aakar', 'adj329@nyu.edu', 'da8f55e5557a36807e8b69aa1251a4316ff231c6ca5345d43c1d2dcd616aebc1', 'Jersey CIty', 5512296555, ''),
(11, 'Aakar', 'adjdd329@nyu.edu', '2f7e2ea57f3dbf40f00a3d92b149778831cd23f399b1dcdede5c495421b698c0', 'Jersey City', 1234567892, '89c9419a7f908f6a68286ef804a0a512.jpeg'),
(15, 'Aakar', 'lala@nyu.edu', '332d1ea7aff29aee36646c3c7292ab5f3c42c3b9aa1f0ea25b312a5c6b4ad808', 'Jersey City', 1234567891, '../uploads/user/15201ebcd398aed687143fc85509c8c6.jpeg'),
(16, 'Aakar', 'a7dj329@nyu.edu', '7adaa664969595c4e4f9330b92244beaa8b7dac57009f1a049858d47d0815b98', 'Jersey City', 6567895643, '../uploads/user/a8dde702ec10b3e315f9c95258748488.jpeg'),
(17, 'Rtd', 'adj123@gmail.com', 'da8f55e5557a36807e8b69aa1251a4316ff231c6ca5345d43c1d2dcd616aebc1', 'Surat', 1123456789, '../uploads/user/5e17ae349c3bc65c5523843491d2f732.png'),
(18, 'Keith', 'Keith@gmail.com', '833b684ea8d6d9ce0920f9a1560c5955122e14144ce0edf0b14d32df402b778a', 'Jersey City', 8888888888, '../uploads/user/99e4a8197214094d6e3d019f5a95d4db.png');

-- --------------------------------------------------------

--
-- Table structure for table `usercard`
--

CREATE TABLE `usercard` (
  `cardno` bigint(13) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usercard`
--

INSERT INTO `usercard` (`cardno`, `uid`) VALUES
(1122445599222233, 1),
(1254256356982785, 2),
(9856854744521523, 2),
(1254256356982785, 3),
(9856854744521523, 3),
(1122445599222233, 4),
(7896541323652856, 4),
(7896541323652856, 5),
(1254256356982785, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carddetail`
--
ALTER TABLE `carddetail`
  ADD PRIMARY KEY (`cardno`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`projid`,`uid`,`cdatetime`),
  ADD KEY `FK_comment_user_uid_uid_idx` (`uid`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`uid`,`followsid`),
  ADD KEY `follows_user_followerid_uid_idx` (`followsid`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`projid`,`uid`),
  ADD KEY `likes_project_uid_idx` (`uid`);

--
-- Indexes for table `mediaattachment`
--
ALTER TABLE `mediaattachment`
  ADD PRIMARY KEY (`maid`),
  ADD KEY `FK_mediaattachment_mediatype_mediatypeid_idx` (`mtypeid`),
  ADD KEY `FK_update_mediaattachment` (`projid`,`updatedatetime`);

--
-- Indexes for table `mediatype`
--
ALTER TABLE `mediatype`
  ADD PRIMARY KEY (`mtypeid`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`projid`),
  ADD KEY `FK_project_category__idx` (`categoryid`),
  ADD KEY `FK_project_user_projcreatorid_uid_idx` (`projcreatorid`);

--
-- Indexes for table `projtags`
--
ALTER TABLE `projtags`
  ADD PRIMARY KEY (`projid`,`tag`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`projid`,`uid`);

--
-- Indexes for table `sponsor`
--
ALTER TABLE `sponsor`
  ADD PRIMARY KEY (`projid`,`uid`,`cardno`,`sdatetime`),
  ADD KEY `FK_sponsor_usercard` (`cardno`,`uid`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`projid`,`uid`,`cardno`,`tdatetime`);

--
-- Indexes for table `update`
--
ALTER TABLE `update`
  ADD PRIMARY KEY (`projid`,`updatedatetime`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `uemail` (`uemail`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `usercard`
--
ALTER TABLE `usercard`
  ADD PRIMARY KEY (`cardno`,`uid`),
  ADD KEY `FK_carddetail_user_uid_uid_idx` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;
--
-- AUTO_INCREMENT for table `mediaattachment`
--
ALTER TABLE `mediaattachment`
  MODIFY `maid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `projid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_comment_project_projid_projid` FOREIGN KEY (`projid`) REFERENCES `project` (`projid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_comment_user_uid_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `FK_follows_user_followsid_uid` FOREIGN KEY (`followsid`) REFERENCES `user` (`uid`),
  ADD CONSTRAINT `FK_follows_user_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_project_projid_projid` FOREIGN KEY (`projid`) REFERENCES `project` (`projid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `likes_project_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `mediaattachment`
--
ALTER TABLE `mediaattachment`
  ADD CONSTRAINT `FK_mediaattachment_mediatype_mediatypeid` FOREIGN KEY (`mtypeid`) REFERENCES `mediatype` (`mtypeid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_update_mediaattachment` FOREIGN KEY (`projid`,`updatedatetime`) REFERENCES `update` (`projid`, `updatedatetime`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `FK_project_category_` FOREIGN KEY (`categoryid`) REFERENCES `category` (`categoryid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_project_user_projcreatorid_uid` FOREIGN KEY (`projcreatorid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `projtags`
--
ALTER TABLE `projtags`
  ADD CONSTRAINT `FK_project_tag_projid` FOREIGN KEY (`projid`) REFERENCES `project` (`projid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `FK_rating_sponsor` FOREIGN KEY (`projid`,`uid`) REFERENCES `sponsor` (`projid`, `uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sponsor`
--
ALTER TABLE `sponsor`
  ADD CONSTRAINT `FK_sponsor_project_projid` FOREIGN KEY (`projid`) REFERENCES `project` (`projid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_sponsor_usercard` FOREIGN KEY (`cardno`,`uid`) REFERENCES `usercard` (`cardno`, `uid`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `FK_transaction_sponsor` FOREIGN KEY (`projid`,`uid`,`cardno`) REFERENCES `sponsor` (`projid`, `uid`, `cardno`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `update`
--
ALTER TABLE `update`
  ADD CONSTRAINT `FK_update_project_projid_projid` FOREIGN KEY (`projid`) REFERENCES `project` (`projid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `usercard`
--
ALTER TABLE `usercard`
  ADD CONSTRAINT `FK_usercard_carddetail_cardno` FOREIGN KEY (`cardno`) REFERENCES `carddetail` (`cardno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_usercard_user_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `Project_EVENT` ON SCHEDULE EVERY 40 SECOND STARTS '2017-04-25 02:08:35' ON COMPLETION NOT PRESERVE ENABLE DO CALL UPDATE_PROJECT()$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
