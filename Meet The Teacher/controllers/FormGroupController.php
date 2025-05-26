<?php

/* Gibbon: the flexible, open school platform
Founded by Ross Parker at ICHK Secondary. Built by Ross Parker, Sandra Kuipers and the Gibbon community (https://gibbonedu.org/about/)
Copyright © 2010, Gibbon Foundation
Gibbon™, Gibbon Education Ltd. (Hong Kong)

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

class FormGroupController implements PESAPIController
{
	private $sqlCommands = array(
		"GetAll" => "
			select
				s.gibbonPersonID as 'StudentID',
				se.gibbonFormGroupID as 'RollGroupID',
				TRIM(LEADING '0' FROM rg.name) as 'RollGroupName',
				TRIM(LEADING '0' FROM rg.nameShort) as 'RollGroupShortName',
				rg.gibbonPersonIDTutor as 'TeacherID1',
				(CASE WHEN rg.gibbonPersonIDTutor2<>rg.gibbonPersonIDTutor THEN rg.gibbonPersonIDTutor2 ELSE null END) as 'TeacherID2',
				(CASE WHEN rg.gibbonPersonIDTutor3<>rg.gibbonPersonIDTutor THEN rg.gibbonPersonIDTutor3 ELSE null END) as 'TeacherID3'
			from 
				gibbonPerson s
			inner join gibbonStudentEnrolment se on se.gibbonPersonID = s.gibbonPersonID
			inner join gibbonFormGroup rg on rg.gibbonFormGroupID = se.gibbonFormGroupID
            where rg.gibbonSchoolYearID=(select gibbonSchoolYearID from gibbonSchoolYear where status='Current')
		;",

		"GetByID" => "
			select
				s.gibbonPersonID as 'StudentID',
				se.gibbonFormGroupID as 'RollGroupID',
				TRIM(LEADING '0' FROM rg.name) as 'RollGroupName',
				TRIM(LEADING '0' FROM rg.nameShort) as 'RollGroupShortName',
				rg.gibbonPersonIDTutor as 'TeacherID1',
				(CASE WHEN rg.gibbonPersonIDTutor2<>rg.gibbonPersonIDTutor THEN rg.gibbonPersonIDTutor2 ELSE null END) as 'TeacherID2',
				(CASE WHEN rg.gibbonPersonIDTutor3<>rg.gibbonPersonIDTutor THEN rg.gibbonPersonIDTutor3 ELSE null END) as 'TeacherID3'
			from 
				gibbonPerson s
			inner join gibbonStudentEnrolment se on se.gibbonPersonID = s.gibbonPersonID
			inner join gibbonFormGroup rg on rg.gibbonFormGroupID = se.gibbonFormGroupID
			where
				s.gibbonPersonID = :ID
                and rg.gibbonSchoolYearID=(select gibbonSchoolYearID from gibbonSchoolYear where status='Current')
		;"
	);

	private $db;

	function __construct($_db)
	{
		$this->db = new DatabaseHelper($_db);
	}

	public function GetAll()
	{
		try
		{
			return $this->db->RunSQL($this->sqlCommands['GetAll'],"FormGroup",null);
		}
		catch(PDOException $_e)
		{
			throw $_e;
		}
	}

	public function GetByID($id)
	{
		try
		{
			return $this->db->RunSQL($this->sqlCommands['GetByID'],"FormGroup",null);
		}
		catch(PDOException $_e)
		{
			throw $_e;
		}

	}


}

?>
