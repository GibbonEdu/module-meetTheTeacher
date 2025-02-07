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

namespace Gibbon\Module\MeetTheTeacher\Domain;

use Gibbon\Domain\Traits\TableAware;
use Gibbon\Domain\QueryCriteria;
use Gibbon\Domain\QueryableGateway;

class BookingGateway extends QueryableGateway
{
    use TableAware;

    private static $tableName = 'meetTheTeacherBooking';
    private static $primaryKey = 'meetTheTeacherBookingID';
    private static $searchableColumns = ['student.preferredName', 'student.surname', 'student.username', 'student.email'];
    
    /**
     * @return DataSet
     */
    public function selectBookingsByTeacher($gibbonPersonID)
    {
        $query = $this
            ->newSelect()
            ->from($this->getTableName())
            ->cols(['meetTheTeacherBooking.meetTheTeacherBookingID',
                'meetTheTeacherBooking.consultationName',
                'meetTheTeacherBooking.appointmentStart',
                'meetTheTeacherBooking.appointmentEnd',
                'meetTheTeacherBooking.courseName',
                'meetTheTeacherBooking.parentMessage',
                'meetTheTeacherBooking.parentTranslator',
                'meetTheTeacherBooking.location',
                'meetTheTeacherBooking.gibbonPersonIDStudent',
                'meetTheTeacherBooking.gibbonPersonIDTeacher',
                'meetTheTeacherBooking.gibbonPersonIDParent',
                'student.title',
                'student.preferredName',
                'student.surname',
                'student.image_240',
                'parent.title as parentTitle',
                'parent.preferredName as parentPreferredName',
                'parent.surname as parentSurname',
                'CONCAT(gibbonCourse.nameShort, ".", gibbonCourseClass.nameShort) as className',
                'gibbonCourseClass.gibbonCourseClassID'
            ])
            ->innerJoin('gibbonPerson as student', 'student.gibbonPersonID=meetTheTeacherBooking.gibbonPersonIDStudent')
            ->innerJoin('gibbonPerson as parent', 'parent.gibbonPersonID=meetTheTeacherBooking.gibbonPersonIDParent')

            ->innerJoin('gibbonCourseClassPerson', 'gibbonCourseClassPerson.gibbonPersonID=meetTheTeacherBooking.gibbonPersonIDStudent AND gibbonCourseClassPerson.role="Student"')
            ->innerJoin('gibbonCourseClass', 'gibbonCourseClassPerson.gibbonCourseClassID=gibbonCourseClass.gibbonCourseClassID')
            ->innerJoin('gibbonCourse', 'gibbonCourseClass.gibbonCourseID=gibbonCourse.gibbonCourseID AND gibbonCourse.name=meetTheTeacherBooking.courseName AND gibbonCourse.gibbonSchoolYearID=meetTheTeacherBooking.gibbonSchoolYearID')
            
            ->where('meetTheTeacherBooking.gibbonPersonIDTeacher=:gibbonPersonID')
            ->bindValue('gibbonPersonID', $gibbonPersonID)
            ->groupBy(['meetTheTeacherBooking.appointmentID'])
            ->orderBy(['meetTheTeacherBooking.appointmentStart', 'student.surname']);

        return $this->runSelect($query);
    }
}
