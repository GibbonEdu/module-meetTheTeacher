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

use Gibbon\Tables\DataTable;
use Gibbon\Services\Format;
use Gibbon\Module\MeetTheTeacher\Domain\LoginCodeGateway;
use Gibbon\Forms\Form;

if (isActionAccessible($guid, $connection2, '/modules/Meet The Teacher/loginCodes_manage.php') == false) {
    // Access denied
    $page->addError(__('You do not have access to this action.'));
} else {
    // Proceed!
    $page->breadcrumbs->add(__m('Manage Login Codes'));

    if (isset($_GET['return'])) {
        returnProcess($guid, $_GET['return'], null, null);
    }

    $search = $_GET['search'] ?? '';
    $loginCodeGateway = $container->get(LoginCodeGateway::class);

    // QUERY
    $criteria = $loginCodeGateway->newQueryCriteria()
        ->searchBy($loginCodeGateway->getSearchableColumns(), $search)
        ->sortBy(['surname', 'preferredName'])
        ->fromPOST();

    $form = Form::create('filter', $_SESSION[$guid]['absoluteURL'].'/index.php', 'get');
    $form->setTitle(__('Search'));
    $form->setClass('noIntBorder fullWidth');

    $form->addHiddenValue('q', '/modules/Meet The Teacher/loginCodes_manage.php');

    $row = $form->addRow();
        $row->addLabel('search', __('Search For'))->description(__('Preferred, surname, username'));
        $row->addTextField('search')->setValue($criteria->getSearchText());

    $row = $form->addRow();
        $row->addSearchSubmit($gibbon->session, __('Clear Search'));

    echo $form->getOutput();


    $loginCodes = $loginCodeGateway->queryLoginCodes($criteria);

    // DATA TABLE
    $table = DataTable::createPaginated('loginCodes', $criteria);
    $table->setTitle(__('View'));
    $table->setDescription(__m('This page enables you to manage Parent Login Codes, which are generated in the Meet The Teacher system, and used to connect the parent dashboard to the Meet The Teacher page via automated login.'));

    $table->addHeaderAction('add', __('Add'))
        ->addParam('search', $criteria->getSearchText())
        ->setURL('/modules/Meet The Teacher/loginCodes_manage_add.php')
        ->displayLabel();

    $table->modifyRows(function ($loginCode, $row) {
        if ($loginCode['status'] != 'Full') $row->addClass('error');
        return $row;
    });

    $table->addColumn('name', __('Name'))
        ->sortable(['surname', 'preferredName'])
        ->format(function ($person) {
            return Format::name($person['title'], $person['preferredName'], $person['surname'], 'Staff', true, true);
        });
    $table->addColumn('loginCode', __m('Login Code'));


    // ACTIONS
    $table->addActionColumn()
        ->addParam('search', $criteria->getSearchText())
        ->addParam('meetTheTeacherLoginID')
        ->format(function ($loginCode, $actions) {
            $actions->addAction('edit', __('Edit'))
                    ->setURL('/modules/Meet The Teacher/loginCodes_manage_edit.php');

            $actions->addAction('delete', __('Delete'))
                    ->setURL('/modules/Meet The Teacher/loginCodes_manage_delete.php');
        });

    echo $table->render($loginCodes);
}
