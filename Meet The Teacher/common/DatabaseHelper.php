<?php

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
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class DatabaseHelper
{
	private $db;

	function __construct($_db)
	{
		$this->db = $_db;
	}

	public function RunSQL($sql,$className,$variables)
	{
		if($this->db != null)
		{
			if($sql != null)
			{
				$stmnt = $this->db->prepare($sql);
				if($variables != null)
				{
					foreach($variables as $key => $val)
					{
						switch($key)
						{
							case "ID":
								$stmnt->bindValue($key,$val,PDO::PARAM_INT);
								break;

							default:
								$stmnt->bindValue($key,$val,PDO::PARAM_STR);
								break;
						}
					}
				}

				try
				{
					if($stmnt->execute() == true)
					{
						if($className != null)
						{
							return $stmnt->fetchAll(PDO::FETCH_CLASS,$className);
						}
						else
						{
							return $stmnt->fetchAll();
						}
					}
				}
				catch(PDOException $_e)
				{
					$e = new Exception("Failed to execute SQL due to a SQL server error");
					$e->InnerException = $_e;
					throw $e;
				}
			}
			else
			{
				throw new Exception("Failed to run SQL since the sql variable was not set");
			}
		}
		else
		{
			throw new Exception("Failed to run SQL since the PDO object for DatabaseHelper hasn't been set");
		}
	}
}
?>
