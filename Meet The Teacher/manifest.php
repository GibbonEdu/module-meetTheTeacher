<?php
/*
Gibbon: the flexible, open school platform
Founded by Ross Parker at ICHK Secondary. Built by Ross Parker, Sandra Kuipers and the Gibbon community (https://gibbonedu.org/about/)
Copyright © 2010, Gibbon Foundation
Gibbon™, Gibbon Education Ltd. (Hong Kong)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//This file describes the module, including database tables

//Basic variables
$name = 'Meet The Teacher';
$description = 'Provides an API for data syncing, and and interface for acess, to making using Gibbon and the online Meet The Teacher service easy.';
$entryURL = 'meetTheTeacher_view.php';
$type = 'Additional';
$category = 'Other';
$version = '1.4.02';
$author = 'Jim Speir & Gibbon Foundation';
$url = 'http://gibbonedu.org';

//Module tables
$moduleTables[0] = "CREATE TABLE `meetTheTeacherLogin` (`meetTheTeacherLoginID` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, `gibbonPersonID` int(10) UNSIGNED ZEROFILL NOT NULL,`loginCode` varchar(9) COLLATE utf8_unicode_ci NOT NULL,PRIMARY KEY (`meetTheTeacherLoginID`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$moduleTables[1] = "CREATE TABLE `meetTheTeacherCustomGroups` (`ID` int(11) NOT NULL AUTO_INCREMENT, `TeacherID` int(10) unsigned zerofill NOT NULL, `StudentID` int(10) unsigned zerofill NOT NULL, `GroupName` varchar(255) COLLATE utf8_unicode_ci NOT NULL, `GroupID` int(11) DEFAULT NULL, PRIMARY KEY (`ID`), KEY `TeacherID` (`TeacherID`), KEY `StudentID` (`StudentID`), KEY `GroupID` (`GroupID`)) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$moduleTables[2] = "CREATE TABLE `meetTheTeacherBooking` (
    `meetTheTeacherBookingID` INT(12) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
    gibbonSchoolYearID INT(3) UNSIGNED ZEROFILL NOT NULL,
    consultationName VARCHAR(120) NULL,
    appointmentID INT(10) UNSIGNED NOT NULL,
    appointmentStart DATETIME NULL,
    appointmentEnd DATETIME NULL,
    courseName VARCHAR(120) NULL,
    gibbonPersonIDStudent INT(10) UNSIGNED ZEROFILL NOT NULL,
    gibbonPersonIDTeacher INT(10) UNSIGNED ZEROFILL NOT NULL,
    gibbonPersonIDParent INT(10) UNSIGNED ZEROFILL NOT NULL,
    timestampAdded TIMESTAMP NULL,
    parentMessage TEXT NULL,
    parentTranslator VARCHAR(30) NULL,
    location VARCHAR(120) NULL,
    PRIMARY KEY (`meetTheTeacherBookingID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";

//Action rows
$actionRows[0]['name'] = 'View Meet The Teacher';
$actionRows[0]['precedence'] = '0';
$actionRows[0]['category'] = 'Meet The Teacher';
$actionRows[0]['description'] = 'Allows a user to view the Meet The Teacher information.';
$actionRows[0]['URLList'] = 'meetTheTeacher_view.php';
$actionRows[0]['entryURL'] = 'meetTheTeacher_view.php';
$actionRows[0]['menuShow'] = 'N';
$actionRows[0]['defaultPermissionAdmin'] = 'N';
$actionRows[0]['defaultPermissionTeacher'] = 'N';
$actionRows[0]['defaultPermissionStudent'] = 'N';
$actionRows[0]['defaultPermissionParent'] = 'Y';
$actionRows[0]['defaultPermissionSupport'] = 'N';
$actionRows[0]['categoryPermissionStaff'] = 'N';
$actionRows[0]['categoryPermissionStudent'] = 'N';
$actionRows[0]['categoryPermissionParent'] = 'Y';
$actionRows[0]['categoryPermissionOther'] = 'N';

$actionRows[1]['name'] = 'Manage Settings';
$actionRows[1]['precedence'] = '0';
$actionRows[1]['category'] = 'Admin';
$actionRows[1]['description'] = 'Allows a privileged user to manage Meet The Teacher settings.';
$actionRows[1]['URLList'] = 'settings_manage.php';
$actionRows[1]['entryURL'] = 'settings_manage.php';
$actionRows[1]['defaultPermissionAdmin'] = 'Y';
$actionRows[1]['defaultPermissionTeacher'] = 'N';
$actionRows[1]['defaultPermissionStudent'] = 'N';
$actionRows[1]['defaultPermissionParent'] = 'N';
$actionRows[1]['defaultPermissionSupport'] = 'N';
$actionRows[1]['categoryPermissionStaff'] = 'Y';
$actionRows[1]['categoryPermissionStudent'] = 'N';
$actionRows[1]['categoryPermissionParent'] = 'N';
$actionRows[1]['categoryPermissionOther'] = 'N';

$actionRows[2]['name'] = 'Manage Login Codes';
$actionRows[2]['precedence'] = '0';
$actionRows[2]['category'] = 'Admin';
$actionRows[2]['description'] = 'Allows a user to manage Meet The Teacher parent login codes.';
$actionRows[2]['URLList'] = 'loginCodes_manage.php,loginCodes_manage_add.php,loginCodes_manage_edit.php,loginCodes_manage_delete.php';
$actionRows[2]['entryURL'] = 'loginCodes_manage.php';
$actionRows[2]['defaultPermissionAdmin'] = 'Y';
$actionRows[2]['defaultPermissionTeacher'] = 'N';
$actionRows[2]['defaultPermissionStudent'] = 'N';
$actionRows[2]['defaultPermissionParent'] = 'N';
$actionRows[2]['defaultPermissionSupport'] = 'N';
$actionRows[2]['categoryPermissionStaff'] = 'Y';
$actionRows[2]['categoryPermissionStudent'] = 'N';
$actionRows[2]['categoryPermissionParent'] = 'N';
$actionRows[2]['categoryPermissionOther'] = 'N';

$actionRows[2]['name'] = 'Export Bookings';
$actionRows[2]['precedence'] = '0';
$actionRows[2]['category'] = 'Consultations';
$actionRows[2]['description'] = 'Allows a user to export their own Meet The Teacher bookings.';
$actionRows[2]['URLList'] = 'export.php';
$actionRows[2]['entryURL'] = 'export.php';
$actionRows[2]['defaultPermissionAdmin'] = 'Y';
$actionRows[2]['defaultPermissionTeacher'] = 'Y';
$actionRows[2]['defaultPermissionStudent'] = 'N';
$actionRows[2]['defaultPermissionParent'] = 'N';
$actionRows[2]['defaultPermissionSupport'] = 'N';
$actionRows[2]['categoryPermissionStaff'] = 'Y';
$actionRows[2]['categoryPermissionStudent'] = 'N';
$actionRows[2]['categoryPermissionParent'] = 'N';
$actionRows[2]['categoryPermissionOther'] = 'N';


//Settings
$gibbonSetting[] = "INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'yearGroups', 'Year Groups', 'List of year group short names to match against, as a comma-separated list.', 'Y07,Y08,Y09,Y10,Y11,Y12,Y13');";
$gibbonSetting[] = "INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'text', 'Text', 'Introductory text used at the top of the dashboard entry', 'Login to Meet The Teacher, using the link below, to make consultation bookings:');";
$gibbonSetting[] = "INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'url', 'URL', 'URL to use for school\'s MTT installation.', 'https://school.meettheteacher.com');";
$gibbonSetting[] = "INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'authenticateBy', 'Authenticate By', 'Which authentication method is configured in MTT.', 'formGroup');";
$gibbonSetting[] = "INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'apiKey', 'API Key', 'Long, random string controlling access to API.', '');";
$gibbonSetting[] = "INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'allowedIPs', 'Allowed IP Address', 'Comma-seperated list of IP addresses with permission to access the API.', '');";
$gibbonSetting[] = "INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'lsTeacherRole', 'LS Teacher Role', 'User role which designates who the learning support teachers in school are. Leave blank to show all teacher roles on the API.', '');";
$gibbonSetting[] = "INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'lsIgnoreClasses', 'Ignore Classes', 'Set whether teachers only show on the API if they have an assigned student or simply assign all teachers with the specified role to all children with individual needs.', '');";
$gibbonSetting[] = "INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'version', 'API Version', 'Currently installed version of the Meet The Teacher', '" . $version . "');";
$gibbonSetting[] = "INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'textUnavailable', 'Text when Unavailable', 'A message to display in the dashboard tab when MTT is unavailable for this user.', 'Login access for Meet The Teacher is not available at this time, or is not currently active for students of this year group.');";
$gibbonSetting[] = "INSERT INTO `gibbonSetting` (`gibbonSettingID` ,`scope` ,`name` ,`nameDisplay` ,`description` ,`value`) VALUES (NULL , 'Meet The Teacher', 'lastSync', 'Last Sync', '', 'N/A');";

//HOOKS
$array = array();
$array['sourceModuleName'] = 'Meet The Teacher';
$array['sourceModuleAction'] = 'View Meet The Teacher';
$array['sourceModuleInclude'] = 'hook_dashboard_meetTheTeacher.php';
$hooks[0] = "INSERT INTO `gibbonHook` (`gibbonHookID`, `name`, `type`, `options`, gibbonModuleID) VALUES (NULL, 'Meet The Teacher', 'Parental Dashboard', '".serialize($array)."', (SELECT gibbonModuleID FROM gibbonModule WHERE name='$name'));";
