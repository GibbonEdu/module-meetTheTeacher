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
use Gibbon\Forms\DatabaseFormFactory;

if (isActionAccessible($guid, $connection2, '/modules/Meet The Teacher/loginCodes_manage_add.php') == false) {
    // Access denied
    $page->addError(__('You do not have access to this action.'));
} else {
    // Proceed!
    $search = $_GET['search'] ?? '';

    $page->breadcrumbs
        ->add(__m('Manage Login Codes'), 'loginCodes_manage.php', ['search' => $search])
        ->add(__m('Add Login Code'));

    $editLink = '';
    if (isset($_GET['editID'])) {
        $editLink = $session->get('absoluteURL').'/index.php?q=/modules/Meet The Teacher/loginCodes_manage_edit.php&meetTheTeacherLoginID='.$_GET['editID'].'&search='.$search;
    }
    $page->return->setEditLink($editLink);

    if ($search != '') {
        $params = [
            "search" => $search
        ];
        $page->navigator->addSearchResultsAction(Url::fromModuleRoute('Meet The Teacher', 'loginCodes_manage.php')->withQueryParams($params));
    }

    $form = Form::create('loginCodesManage', $session->get('absoluteURL').'/modules/Meet The Teacher/loginCodes_manage_addProcess.php?search='.$search);
    $form->setFactory(DatabaseFormFactory::create($pdo));

    $form->addHiddenValue('address', $session->get('address'));

    $row = $form->addRow();
        $row->addLabel('gibbonPersonID', __('Parent'));
        $row->addSelectUsers('gibbonPersonID')->placeholder()->required();

    $row = $form->addRow();
        $row->addLabel('loginCode', __m('Parent Login Code'))->description(__('Generated in the Meet The Teacher system.'));
        $row->addTextField('loginCode')->maxLength(120)->required();

    $row = $form->addRow();
        $row->addFooter();
        $row->addSubmit();

    echo $form->getOutput();
}
