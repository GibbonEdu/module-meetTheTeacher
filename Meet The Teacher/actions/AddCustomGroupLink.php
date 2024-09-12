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

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
include '../controllers/CustomGroupController.php';

$cgc = new CustomGroupController( new PDO("mysql:host=" . $databaseServer . ";dbname=" . $databaseName . ";charset=utf8", $databaseUsername, $databasePassword));
if($_POST['teacherid'] == null || $_POST['studentid'] == null || $_POST['groupname'] == null || $_POST['groupid'] == null)
{
	http_response_code(400);
	print "Required data is not provided";
}
else
{
	$gl = new CustomGroupLink(null,$_POST['teacherid'],$_POST['studentid'],$_POST['groupname'],$_POST['groupid']);
}
try
{
	print json_encode($cgc->AddGroupLink($gl));
}
catch(Exception $e)
{
	print json_encode($e);
}

?>
