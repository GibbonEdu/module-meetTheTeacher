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

class LoginCodeGateway extends QueryableGateway
{
    use TableAware;

    private static $tableName = 'meetTheTeacherLogin';
    private static $primaryKey = 'meetTheTeacherLoginID';
    private static $searchableColumns = ['gibbonPerson.preferredName', 'gibbonPerson.surname', 'gibbonPerson.username', 'gibbonPerson.email'];
    
    /**
     * @param QueryCriteria $criteria
     * @return DataSet
     */
    public function queryLoginCodes(QueryCriteria $criteria)
    {
        $query = $this
            ->newQuery()
            ->from($this->getTableName())
            ->cols(['meetTheTeacherLogin.meetTheTeacherLoginID', 'gibbonPerson.title', 'gibbonPerson.preferredName', 'gibbonPerson.username', 'gibbonPerson.surname', 'gibbonPerson.status', 'gibbonPerson.email', 'meetTheTeacherLogin.loginCode'])
            ->innerJoin('gibbonPerson', 'gibbonPerson.gibbonPersonID=meetTheTeacherLogin.gibbonPersonID');

        return $this->runQuery($query, $criteria);
    }
}
