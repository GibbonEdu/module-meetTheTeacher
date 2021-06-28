<?php
/*
Gibbon, Flexible & Open School System
Copyright (C) 2010, Ross Parker

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

use Gibbon\Module\MeetTheTeacher\Domain\LoginCodeGateway;

require_once '../../gibbon.php';

$search = $_GET['search'] ?? '';
$meetTheTeacherLoginID = $_POST['meetTheTeacherLoginID'] ?? '';

$URL = $session->get('absoluteURL').'/index.php?q=/modules/Meet The Teacher/loginCodes_manage_edit.php&meetTheTeacherLoginID='.$meetTheTeacherLoginID.'&search='.$search;

if (isActionAccessible($guid, $connection2, '/modules/Meet The Teacher/loginCodes_manage_edit.php') == false) {
    $URL .= '&return=error0';
    header("Location: {$URL}");
    exit;
} else {
    // Proceed!
    $loginCodeGateway = $container->get(LoginCodeGateway::class);

    $data = [
        'loginCode' => $_POST['loginCode'] ?? '',
    ];

    // Validate the required values are present
    if (empty($meetTheTeacherLoginID) || empty($data['loginCode'])) {
        $URL .= '&return=error1';
        header("Location: {$URL}");
        exit;
    }

    // Validate the database relationships exist
    if (!$loginCodeGateway->exists($meetTheTeacherLoginID)) {
        $URL .= '&return=error2';
        header("Location: {$URL}");
        exit;
    }

    // Update the record
    $updated = $loginCodeGateway->update($meetTheTeacherLoginID, $data);

    $URL .= !$updated
        ? "&return=error2"
        : "&return=success0";

    header("Location: {$URL}");
}
