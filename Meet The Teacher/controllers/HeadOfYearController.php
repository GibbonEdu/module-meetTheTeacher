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


class HeadOfYearController implements PESAPIController
{

	private $db;

    //Need the distinct in both cases since it could be possible IN has different levels assigned.
	private $sqlCommands = array(
        "GetAll" => "
			select
				gse.gibbonPersonID as 'StudentID',
				gyg.gibbonYearGroupID as 'GroupID',
				gyg.name as 'GroupName',
				gyg.gibbonPersonIDHOY as 'TeacherID'
			from gibbonYearGroup gyg
			inner join gibbonStudentEnrolment gse on gse.gibbonYearGroupID = gyg.gibbonYearGroupID
			inner join gibbonPerson gp on gp.gibbonPersonID = gse.gibbonPersonID
			where
				gyg.gibbonPersonIDHOY is not null
				and gp.status != 'Left'
        ;",

		"GetByID" => "
			select
				gse.gibbonPersonID as 'StudentID',
				gyg.gibbonYearGroupID as 'GroupID',
				gyg.name as 'GroupName',
				gyg.gibbonPersonIDHOY as 'TeacherID'
			from gibbonYearGroup gyg
			inner join gibbonStudentEnrolment gse on gse.gibbonYearGroupID = gyg.gibbonYearGroupID
			inner join gibbonPerson gp on gp.gibbonPersonID = gse.gibbonPersonID
			where
				gyg.gibbonPersonIDHOY is not null
				and gibbonYearGroupID = :ID
				and gp.status != 'Left'
        ;"
	);

	function __construct($_db)
	{
		$this->db = new DatabaseHelper($_db);
    }

    public function GetAll()
	{
		try
		{
			return $this->db->RunSQL($this->sqlCommands['GetAll'],"GroupLink",null);
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
			return $this->db->RunSQL($this->sqlCommands['GetByID'],"GroupLink",array("ID" => $id));
		}
		catch(PDOException $_e)
		{
			throw $_e;
		}

	}
}
?>