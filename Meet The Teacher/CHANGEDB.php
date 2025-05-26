<?php
//USE ;end TO SEPERATE SQL STATEMENTS. DON'T USE ;end IN ANY OTHER PLACES!

$sql = array();
$count = 0;

//v0.0.01
$sql[$count][0] = '0.0.01';
$sql[$count][1] = '-- First version, nothing to update';

//v0.0.02
++$count;
$sql[$count][0] = '0.0.02';
$sql[$count][1] = '';

//v0.0.03
++$count;
$sql[$count][0] = '0.0.03';
$sql[$count][1] = "
INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'authenticateBy', 'Authenticate By', 'Which authentication method is configured in MTT.', 'rollGroup');end
";

//v0.0.04
++$count;
$sql[$count][0] = '0.0.04';
$sql[$count][1] = "INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'textUnavailable', 'Text when Unavailable', 'A message to display in the dashboard tab when MTT is unavailable for this user.', 'Login access for Meet The Teacher is not available at this time, or is not currently active for students of this year group.');";

//v1.0.00
++$count;
$sql[$count][0] = '1.0.00';
$sql[$count][1] = "
UPDATE gibbonModule SET author='Jim Speir, Sandra Kuipers & Ross Parker', description='Provides an API for data syncing, and and interface for acess, to making using Gibbon and the online Meet The Teacher service easy.' WHERE name='Meet The Teacher';end
CREATE TABLE `meetTheTeacherCustomGroups` (`ID` int(11) NOT NULL AUTO_INCREMENT, `TeacherID` int(10) unsigned zerofill NOT NULL, `StudentID` int(10) unsigned zerofill NOT NULL, `GroupName` varchar(255) NOT NULL, `GroupID` int(11) DEFAULT NULL, PRIMARY KEY (`ID`), KEY `TeacherID` (`TeacherID`), KEY `StudentID` (`StudentID`), KEY `GroupID` (`GroupID`)) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;end
INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'apiKey', 'API Key', 'Long, random string controlling access to API.', '');end
INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'allowedIPs', 'Allowed IP Address', 'Comma-seperated list of IP addresses with permission to access the API.', '');end
INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'lsTeacherRole', 'LS Teacher Role', 'User role which designates who the learning support teachers in school are. Leave blank to show all teacher roles on the API.', '');end
INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'lsIgnoreClasses', 'Ignore Classes', 'Set whether teachers only show on the API if they have an assigned student or simply assign all teachers with the specified role to all children with individual needs.', '');end
INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'version', 'API Version', 'Currently installed version of the Meet The Teacher', '" . $version . "');end
";

//v1.0.01
++$count;
$sql[$count][0] = '1.0.01';
$sql[$count][1] = "";

//v1.1.00
++$count;
$sql[$count][0] = '1.1.00';
$sql[$count][1] = "";

//v1.1.01
++$count;
$sql[$count][0] = '1.1.01';
$sql[$count][1] = "";

//v1.1.02
++$count;
$sql[$count][0] = '1.1.02';
$sql[$count][1] = "";

//v1.1.03
++$count;
$sql[$count][0] = '1.1.03';
$sql[$count][1] = "";

//v1.1.04
++$count;
$sql[$count][0] = '1.1.04';
$sql[$count][1] = "";

//v1.1.05
++$count;
$sql[$count][0] = '1.1.05';
$sql[$count][1] = "";

//v1.1.06
++$count;
$sql[$count][0] = '1.1.06';
$sql[$count][1] = "
INSERT INTO `gibbonAction` (`gibbonModuleID`, `name`, `precedence`, `category`, `description`, `URLList`, `entryURL`, `defaultPermissionAdmin`, `defaultPermissionTeacher`, `defaultPermissionStudent`, `defaultPermissionParent`, `defaultPermissionSupport`, `categoryPermissionStaff`, `categoryPermissionStudent`, `categoryPermissionParent`, `categoryPermissionOther`) VALUES ((SELECT gibbonModuleID FROM gibbonModule WHERE name='Meet The Teacher'), 'Manage Login Codes', 0, 'Admin', 'Allows a user to manage Meet The Teacher parent login codes.', 'loginCodes_manage.php,loginCodes_manage_add.php,loginCodes_manage_edit.php,loginCodes_manage_delete.php', 'loginCodes_manage.php', 'Y', 'N', 'N', 'N', 'N', 'Y', 'N', 'N', 'N');end
INSERT INTO `gibbonPermission` (`gibbonRoleID` ,`gibbonActionID`) VALUES ('001', (SELECT gibbonActionID FROM gibbonAction JOIN gibbonModule ON (gibbonAction.gibbonModuleID=gibbonModule.gibbonModuleID) WHERE gibbonModule.name='Meet The Teacher' AND gibbonAction.name='Manage Login Codes'));end
";

//v1.1.07
++$count;
$sql[$count][0] = '1.1.07';
$sql[$count][1] = "";

//v1.1.08
++$count;
$sql[$count][0] = '1.1.08';
$sql[$count][1] = "UPDATE gibbonSetting SET value='1.1.08' WHERE scope='Meet The Teacher' AND name='version';end";

//v1.1.09
++$count;
$sql[$count][0] = '1.1.09';
$sql[$count][1] = "
INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'lastSync', 'Last Sync', '', 'N/A');end
";

//v1.1.10
++$count;
$sql[$count][0] = '1.1.10';
$sql[$count][1] = "UPDATE gibbonSetting SET value='1.1.10' WHERE scope='Meet The Teacher' AND name='version';end";

//v1.1.11
++$count;
$sql[$count][0] = '1.1.11';
$sql[$count][1] = "UPDATE gibbonSetting SET value='1.1.11' WHERE scope='Meet The Teacher' AND name='version';end";

//v1.1.12
++$count;
$sql[$count][0] = '1.1.12';
$sql[$count][1] = "UPDATE gibbonSetting SET value='1.1.12' WHERE scope='Meet The Teacher' AND name='version';end";

//v1.2.00
++$count;
$sql[$count][0] = '1.2.00';
$sql[$count][1] = "UPDATE gibbonSetting SET value='formGroup' WHERE scope='Meet The Teacher' AND name='authenticateBy' AND value='rollGroup';end";

//v1.2.01
++$count;
$sql[$count][0] = '1.2.01';
$sql[$count][1] = "";

//v1.2.02
++$count;
$sql[$count][0] = '1.2.02';
$sql[$count][1] = "";

//v1.2.03
++$count;
$sql[$count][0] = '1.2.03';
$sql[$count][1] = "
INSERT IGNORE INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'lastSync', 'Last Sync', '', 'N/A');end
";

//v1.2.04
++$count;
$sql[$count][0] = '1.2.04';
$sql[$count][1] = "";

//v1.2.05
++$count;
$sql[$count][0] = '1.2.05';
$sql[$count][1] = "";

//v1.2.06
++$count;
$sql[$count][0] = '1.2.06';
$sql[$count][1] = "";

//v1.2.07
++$count;
$sql[$count][0] = '1.2.07';
$sql[$count][1] = "";

//v1.3.00
++$count;
$sql[$count][0] = '1.3.00';
$sql[$count][1] = "
UPDATE gibbonModule SET author='Jim Speir & Gibbon Foundation', url='https://gibbonedu.org' WHERE name='Meet The Teacher';end";

//v1.3.01
++$count;
$sql[$count][0] = '1.3.01';
$sql[$count][1] = "";

//v1.3.02
++$count;
$sql[$count][0] = '1.3.02';
$sql[$count][1] = "";

//v1.4.00
++$count;
$sql[$count][0] = '1.4.00';
$sql[$count][1] = "CREATE TABLE `meetTheTeacherBooking` (`meetTheTeacherBookingID` INT(12) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, gibbonSchoolYearID INT(3) UNSIGNED ZEROFILL NOT NULL, consultationName VARCHAR(120) NULL, appointmentID INT(10) UNSIGNED NOT NULL, appointmentStart DATETIME NULL, appointmentEnd DATETIME NULL, courseName VARCHAR(120) NULL, gibbonPersonIDStudent INT(10) UNSIGNED ZEROFILL NOT NULL, gibbonPersonIDTeacher INT(10) UNSIGNED ZEROFILL NOT NULL, gibbonPersonIDParent INT(10) UNSIGNED ZEROFILL NOT NULL, timestampAdded TIMESTAMP NULL, parentMessage TEXT NULL, parentTranslator VARCHAR(30) NULL, location VARCHAR(120) NULL, PRIMARY KEY (`meetTheTeacherBookingID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;end
INSERT INTO `gibbonAction` (`gibbonModuleID`, `name`, `precedence`, `category`, `description`, `URLList`, `entryURL`, `defaultPermissionAdmin`, `defaultPermissionTeacher`, `defaultPermissionStudent`, `defaultPermissionParent`, `defaultPermissionSupport`, `categoryPermissionStaff`, `categoryPermissionStudent`, `categoryPermissionParent`, `categoryPermissionOther`) VALUES ((SELECT gibbonModuleID FROM gibbonModule WHERE name='Meet The Teacher'), 'Export Bookings', 0, 'Consultations', 'Allows a user to export their own Meet The Teacher bookings.', 'export.php', 'export.php', 'Y', 'Y', 'N', 'N', 'N', 'Y', 'N', 'N', 'N');end
INSERT INTO `gibbonPermission` (`gibbonRoleID` ,`gibbonActionID`) VALUES ('001', (SELECT gibbonActionID FROM gibbonAction JOIN gibbonModule ON (gibbonAction.gibbonModuleID=gibbonModule.gibbonModuleID) WHERE gibbonModule.name='Meet The Teacher' AND gibbonAction.name='Export Bookings'));end
INSERT INTO `gibbonPermission` (`gibbonRoleID` ,`gibbonActionID`) VALUES ('002', (SELECT gibbonActionID FROM gibbonAction JOIN gibbonModule ON (gibbonAction.gibbonModuleID=gibbonModule.gibbonModuleID) WHERE gibbonModule.name='Meet The Teacher' AND gibbonAction.name='Export Bookings'));end";

//v1.4.01
++$count;
$sql[$count][0] = '1.4.01';
$sql[$count][1] = "";

//v1.4.02
++$count;
$sql[$count][0] = '1.4.02';
$sql[$count][1] = "";
