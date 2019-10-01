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

use Gibbon\Forms\Form;
use Gibbon\Services\Format;
use Gibbon\Module\MeetTheTeacher\Domain\LoginCodeGateway;
use Gibbon\Forms\DatabaseFormFactory;

if (isActionAccessible($guid, $connection2, '/modules/Meet The Teacher/loginCodes_manage_edit.php') == false) {
    // Access denied
    $page->addError(__('You do not have access to this action.'));
} else {
    //Proceed!
    $search = $_GET['search'] ?? '';

    $page->breadcrumbs
        ->add(__m('Manage Login Codes'), 'loginCodes_manage.php', ['search' => $search])
        ->add(__m('Edit Login Code'));

    if (isset($_GET['return'])) {
        returnProcess($guid, $_GET['return'], null, null);
    }

    if ($search != '') {
        echo "<div class='linkTop'>";
        echo "<a href='".$gibbon->session->get('absoluteURL')."/index.php?q=/modules/Meet The Teacher/loginCodes_manage.php&search=$search'>".__('Back to Search Results').'</a>';
        echo '</div>';
    }

    $meetTheTeacherLoginID = $_GET['meetTheTeacherLoginID'] ?? '';
    $loginCodeGateway = $container->get(LoginCodeGateway::class);

    if (empty($meetTheTeacherLoginID)) {
        $page->addError(__('You have not specified one or more required parameters.'));
        return;
    }

    $values = $loginCodeGateway->getByID($meetTheTeacherLoginID);
    if (empty($values)) {
        $page->addError(__('The specified record cannot be found.'));
        return;
    }

    $form = Form::create('loginCodesManage', $gibbon->session->get('absoluteURL').'/modules/Meet The Teacher/loginCodes_manage_editProcess.php?search='.$search);
    $form->setFactory(DatabaseFormFactory::create($pdo));

    $form->addHiddenValue('address', $gibbon->session->get('address'));
    $form->addHiddenValue('meetTheTeacherLoginID', $meetTheTeacherLoginID);

    $row = $form->addRow();
        $row->addLabel('personLabel', __('Parent'));
        $row->addSelectUsers('person')->readonly()->selected($values['gibbonPersonID']);

    $row = $form->addRow();
        $row->addLabel('loginCode', __m('Parent Login Code'))->description(__('Generated in the Meet The Teacher system.'));
        $row->addTextField('loginCode')->maxLength(120)->required();

    $row = $form->addRow();
        $row->addFooter();
        $row->addSubmit();

    $form->loadAllValuesFrom($values);

    echo $form->getOutput();
}
