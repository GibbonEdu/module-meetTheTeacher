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
use Gibbon\Forms\Form;
use Gibbon\Module\MeetTheTeacher\Domain\BookingGateway;

if (isActionAccessible($guid, $connection2, '/modules/Meet The Teacher/export.php') == false) {
    // Access denied
    $page->addError(__('You do not have access to this action.'));
} else {
    // Proceed!
    $page->breadcrumbs->add(__m('Export Bookings'));

    $bookingGateway = $container->get(BookingGateway::class);

    $form = Form::create('export', $session->get('absoluteURL').'/modules/Meet The Teacher/exportProcess.php');
    $form->setTitle(__('Export'));

    $consultations = $bookingGateway->selectConsultationsBySchoolYear($session->get('gibbonSchoolYearID'))->fetchKeyPair();

    $row = $form->addRow();
        $row->addLabel('consultationName', __m('Consultation'));
        $row->addSelect('consultationName')->fromArray($consultations)->required()->placeholder();

    $row = $form->addRow();
        $row->addContent(__m('When you click Export, this tool will create a spreadsheet of your bookings, including photos and links to student profiles. This can be uploaded to Google Sheets to add your own notes and comments.'))->addClass('text-sm');

    $row = $form->addRow();
        $row->addSubmit(__('Export'));

    echo $form->getOutput();
}
