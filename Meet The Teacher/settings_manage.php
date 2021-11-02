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
use Gibbon\Domain\System\SettingGateway;

$settingGateway = $container->get(SettingGateway::class);

if (isActionAccessible($guid, $connection2, '/modules/Meet The Teacher/settings_manage.php') == false) {
    //Acess denied
    echo "<div class='error'>";
    echo __('You do not have access to this action.');
    echo '</div>';
} else {
    //Proceed!
    $page->breadcrumbs->add(__('Manage Settings'));

    $form = Form::create('settings_manage', $session->get('absoluteURL').'/modules/'.$session->get('module').'/settings_manageProcess.php');

    $form->addHiddenValue('address', $session->get('address'));

    $setting = $settingGateway->getSettingByScope('Meet The Teacher', 'version', true);
    $form->addHiddenValue('apiVersion', $setting['value']);

    $row = $form->addRow()->addHeading(__('API Settings'));

    $setting = $settingGateway->getSettingByScope('Meet The Teacher', 'lastSync', true);
    $row = $form->addRow();
        $row->addLabel($setting['name'], __($setting['nameDisplay']))->description(__($setting['description']));
        $row->addTextField($setting['name'])->setValue($setting['value'])->readonly();

    $setting = $settingGateway->getSettingByScope('Meet The Teacher', 'apiKey', true);
    $row = $form->addRow();
        $row->addLabel($setting['name'], __($setting['nameDisplay']))->description(__($setting['description']));
        $row->addTextField($setting['name'])->setValue($setting['value'])->isRequired();

    $setting = $settingGateway->getSettingByScope('Meet The Teacher', 'allowedIPs', true);
    $row = $form->addRow();
        $row->addLabel($setting['name'], __($setting['nameDisplay']))->description(__($setting['description']));
        $row->addTextArea($setting['name'])->setValue($setting['value'])->isRequired();

    $data = array();
    $sql = "SELECT gibbonRoleID as value, name FROM gibbonRole WHERE category='Staff' ORDER BY name";
    $setting = $settingGateway->getSettingByScope('Meet The Teacher', 'lsTeacherRole', true);
    $row = $form->addRow();
        $row->addLabel($setting['name'], __($setting['nameDisplay']))->description(__($setting['description']));
        $row->addSelect($setting['name'])->fromQuery($pdo, $sql, $data)->selected($setting['value'])->placeholder();

    $setting = $settingGateway->getSettingByScope('Meet The Teacher', 'lsIgnoreClasses',true);
    $row = $form->addRow();
        $row->addLabel($setting['name'],__($setting['nameDisplay']))->description(__($setting['description']));
        $row->addCheckbox($setting['name'])->checked($setting['value'] == "1" ? "on" : "off");

    $row = $form->addRow()->addHeading(__('Parent Dashboard'));

    $setting = $settingGateway->getSettingByScope('Meet The Teacher', 'url', true);
    $row = $form->addRow();
        $row->addLabel($setting['name'], __($setting['nameDisplay']))->description(__($setting['description']));
        $row->addURL($setting['name'])->setValue($setting['value'])->maxLength(100)->isRequired();

    $setting = $settingGateway->getSettingByScope('Meet The Teacher', 'text', true);
    $col = $form->addRow()->addColumn();
        $col->addLabel($setting['name'], __($setting['nameDisplay']))->description(__($setting['description']));
        $col->addEditor($setting['name'], $guid)->setValue($setting['value'])->setRows(8);

    $setting = $settingGateway->getSettingByScope('Meet The Teacher', 'textUnavailable', true);
    $col = $form->addRow()->addColumn();
        $col->addLabel($setting['name'], __($setting['nameDisplay']))->description(__($setting['description']));
        $col->addEditor($setting['name'], $guid)->setValue($setting['value'])->setRows(8);

    $row = $form->addRow()->addHeading(__('Parent Login Access'));

    $setting = $settingGateway->getSettingByScope('Meet The Teacher', 'yearGroups', true);
    $row = $form->addRow();
        $row->addLabel($setting['name'], __($setting['nameDisplay']))->description($setting['description']);
        $row->addTextarea($setting['name'])->setValue($setting['value']);

    $authentication = array('formGroup' => 'Child Class', 'dob' => 'Child Date of Birth');
    $setting = $settingGateway->getSettingByScope('Meet The Teacher', 'authenticateBy', true);
    $row = $form->addRow();
        $row->addLabel($setting['name'], __($setting['nameDisplay']))->description($setting['description']);
        $row->addSelect($setting['name'])->fromArray($authentication)->selected($setting['value']);

    $row = $form->addRow();
        $row->addFooter();
        $row->addSubmit();

    echo $form->getOutput();
}
