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
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

use Gibbon\Domain\System\SettingGateway;

//Load Gibbon includes
include '../../config.php';
include '../../gibbon.php';

//Get system settings
getSystemSettings($guid, $connection2);

//Set gibbon absolutePath
$GIBBON_DIR = $session->get('absolutePath');
$PESMOD_DIR = $GIBBON_DIR . '/modules/Meet The Teacher';

$settingGateway = $container->get(SettingGateway::class);
$APIKey = $settingGateway->getSettingByScope('Meet The Teacher', 'apiKey');
$allowedIPsTemp = $settingGateway->getSettingByScope('Meet The Teacher', 'allowedIPs');
if ($allowedIPsTemp == '') {
	$ALLOWED_IPS = null;
}
else {
	$ALLOWED_IPS = explode(",", $allowedIPsTemp);
}

include $PESMOD_DIR . '/common/DatabaseHelper.php';

include $PESMOD_DIR . '/domains/GroupLink.php';
include $PESMOD_DIR . '/domains/Person.php';
include $PESMOD_DIR . '/domains/CustomGroupLink.php';
include $PESMOD_DIR . '/domains/ActivityGroupLink.php';
include $PESMOD_DIR . '/domains/Student.php';
include $PESMOD_DIR . '/domains/StaffMember.php';
include $PESMOD_DIR . '/domains/IndividualNeedsGroupLink.php';
include $PESMOD_DIR . '/domains/Contact.php';
include $PESMOD_DIR . '/domains/ContactLink.php';
include $PESMOD_DIR . '/domains/FormGroup.php';
include $PESMOD_DIR . '/domains/ClassLink.php';

include $PESMOD_DIR . '/controllers/interfaces/PESAPIController.php';
include $PESMOD_DIR . '/controllers/ActivityGroupController.php';
include $PESMOD_DIR . '/controllers/CustomGroupController.php';
include $PESMOD_DIR . '/controllers/StudentController.php';
include $PESMOD_DIR . '/controllers/StaffController.php';
include $PESMOD_DIR . '/controllers/IndividualNeedsGroupController.php';
include $PESMOD_DIR . '/controllers/ContactController.php';
include $PESMOD_DIR . '/controllers/ContactLinkController.php';
include $PESMOD_DIR . '/controllers/FormGroupController.php';
include $PESMOD_DIR . '/controllers/ClassController.php';
include $PESMOD_DIR . '/controllers/HeadOfYearController.php';

?>
