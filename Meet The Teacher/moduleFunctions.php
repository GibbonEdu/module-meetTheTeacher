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
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

use Gibbon\Services\Format;
use Gibbon\Domain\System\SettingGateway;

function getMeetTheTeacher($connection2, $guid, $gibbonPersonIDChild = null)
{
    global $session, $container;

    $output = '';

	$settingGateway = $container->get(SettingGateway::class);
    $url = $settingGateway->getSettingByScope('Meet The Teacher', 'url');
    $text = $settingGateway->getSettingByScope('Meet The Teacher', 'text');
    $textUnavailable = $settingGateway->getSettingByScope('Meet The Teacher', 'textUnavailable');
    $yearGroups = $settingGateway->getSettingByScope('Meet The Teacher', 'yearGroups');
    $authenticateBy = $settingGateway->getSettingByScope('Meet The Teacher', 'authenticateBy');

    // Get parent details to be passed to URL params
    $data = array('gibbonPersonID' => $session->get('gibbonPersonID'));
    $sql = "SELECT DISTINCT email AS parentEmailAddress, email AS parentEmailAddressConfirm, meetTheTeacherLogin.loginCode as parentCode
            FROM gibbonPerson
            LEFT JOIN meetTheTeacherLogin ON (gibbonPerson.gibbonPersonID=meetTheTeacherLogin.gibbonPersonID)
            WHERE gibbonPerson.gibbonPersonID=:gibbonPersonID";
    $result = $connection2->prepare($sql);
    $result->execute($data);

    if ($result->rowCount() == 1) {
        $params = $result->fetch();
    } else {
        $output .= "<div class='warning'>";
        $output .= $textUnavailable;
        $output .= '</div>';
        return $output;
    }

    // Get student details for this parent
    $data = array(
        'gibbonPersonID' => $session->get('gibbonPersonID'),
        'gibbonPersonIDChild' => $gibbonPersonIDChild,
        'date' => date('Y-m-d'),
        'gibbonSchoolYearID' => $session->get('gibbonSchoolYearID'),
        'yearGroups' => $yearGroups,
    );
    $sql = "SELECT gibbonPerson.gibbonPersonID, gibbonPerson.surname, gibbonPerson.preferredName, gibbonYearGroup.nameShort as yearGroupName, gibbonFormGroup.nameShort as formGroupName, gibbonPerson.dob
        FROM gibbonFamilyChild
        JOIN gibbonFamily ON (gibbonFamilyChild.gibbonFamilyID=gibbonFamily.gibbonFamilyID)
        JOIN gibbonFamilyAdult ON (gibbonFamilyAdult.gibbonFamilyID=gibbonFamily.gibbonFamilyID)
        JOIN gibbonPerson ON (gibbonFamilyChild.gibbonPersonID=gibbonPerson.gibbonPersonID)
        JOIN gibbonStudentEnrolment ON (gibbonStudentEnrolment.gibbonPersonID=gibbonPerson.gibbonPersonID)
        JOIN gibbonYearGroup ON (gibbonYearGroup.gibbonYearGroupID=gibbonStudentEnrolment.gibbonYearGroupID)
        JOIN gibbonFormGroup ON (gibbonFormGroup.gibbonFormGroupID=gibbonStudentEnrolment.gibbonFormGroupID)
        WHERE gibbonStudentEnrolment.gibbonSchoolYearID=:gibbonSchoolYearID
        AND FIND_IN_SET(gibbonYearGroup.nameShort, :yearGroups)
        AND gibbonPerson.status='Full' AND (dateEnd IS NULL OR dateEnd>=:date)
        AND gibbonFamilyAdult.gibbonPersonID=:gibbonPersonID
        AND gibbonFamilyAdult.childDataAccess='Y'
        AND gibbonFamilyChild.gibbonPersonID=:gibbonPersonIDChild
        ORDER BY gibbonYearGroup.sequenceNumber ASC";
    $result = $connection2->prepare($sql);
    $result->execute($data);

    if ($result->rowCount() != 1) {
        $output .= "<div class='warning'>";
        $output .= $textUnavailable;
        $output .= '</div>';
    } else {
        $output .= '<div class="message" style="padding-top: 14px">';
        $output .= "<b>".__($text).'</b><br/>';

        $student = $result->fetch();
        if ($authenticateBy == 'dob') {
            $dob = new DateTime($student['dob']);
            $params['DateOfBirthHelper_Day'] = $dob->format('j');
            $params['DateOfBirthHelper_Month'] = $dob->format('n');
            $params['DateOfBirthHelper_Year'] = $dob->format('Y');
        } else {
            $params['StudentClass'] = $student['formGroupName'];
        }

        $output .= '<br/>';
        $output .= '<div class="text-base leading-normal">';
        $output .= '<b>'.__('Click to Login').': </b>';
        $output .= '<a href="'.$url.'?isPostback=true&'.http_build_query($params).'" target="_blank">';
        $output .= Format::name('', $student['preferredName'], $student['surname'], 'Student', false, true);
        $output .= ' - '.$student['yearGroupName'];
        $output .= '</a>';
        $output .= '</div>';
        $output .= '<br/>';

        $output .= '<div class="text-sm leading-normal">';
        $output .= '<b>'.__('Login Code').': </b>'.$params['parentCode'].'<br/>';
        $output .= '<b>'.__('Form Group').': </b>'.$params['StudentClass'].'<br/><br/>';
        $output .= '</div>';

        $output .= '<p class="noMargin emphasis"><b>'.__('Note').':</b> ';
        $output .= __m('Please do not share the bookings URL with anyone, as it contains your unique login code.').'</p>';
        $output .= '</div><br/>';
    }

    return $output;
}
