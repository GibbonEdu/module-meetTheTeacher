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
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

use Gibbon\Http\Url;
use Gibbon\Forms\Form;
use Gibbon\Services\Format;
use Gibbon\Forms\DatabaseFormFactory;
use Gibbon\Module\MeetTheTeacher\Domain\LoginCodeGateway;

if (isActionAccessible($guid, $connection2, '/modules/Meet The Teacher/loginCodes_manage_edit.php') == false) {
    // Access denied
    $page->addError(__('You do not have access to this action.'));
} else {
    //Proceed!
    $search = $_GET['search'] ?? '';

    $page->breadcrumbs
        ->add(__m('Manage Login Codes'), 'loginCodes_manage.php', ['search' => $search])
        ->add(__m('Edit Login Code'));

    if ($search != '') {
        $params = [
            "search" => $search
        ];
        $page->navigator->addSearchResultsAction(Url::fromModuleRoute('Meet The Teacher', 'loginCodes_manage.php')->withQueryParams($params));
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

    $form = Form::create('loginCodesManage', $session->get('absoluteURL').'/modules/Meet The Teacher/loginCodes_manage_editProcess.php?search='.$search);
    $form->setFactory(DatabaseFormFactory::create($pdo));

    $form->addHiddenValue('address', $session->get('address'));
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
