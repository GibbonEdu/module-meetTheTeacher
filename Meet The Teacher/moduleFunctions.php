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

use Gibbon\Services\Format;
use Gibbon\Domain\System\SettingGateway;

function getMeetTheTeacher($connection2, $guid, $gibbonPersonIDChild = null)
{
    global $session, $container;

    $output = '';

	$settingGateway = $container->get(SettingGateway::class);
    $text = $settingGateway->getSettingByScope('Meet The Teacher', 'text');

    $url = $settingGateway->getSettingByScope('Meet The Teacher', 'url');
    $url = trim($url, '/').'/Auth/ParentUniversalLogin?prompt=login';

    $output .= '<div class="message" style="padding-top: 14px">';
    $output .= __($text).'<br/>';

    $output .= '<div class="text-base leading-normal">';
    $output .= '<a href="'.$url.'" target="_blank" class="">';
    $output .= '<button type="button" class="button rounded-md px-6 py-3 text-base bg-gray-100 text-gray-800 inline-flex align-middle items-center border border-gray-400 hover:border-gray-700 gap-2 no-underline font-medium shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-500">';
    $output .= __('Login to Meet The Teacher');
    $output .= icon('basic', 'arrow-move', 'text-gray-600 block size-5 lg:-ml-0.5 lg:mr-1.5');
    $output .= '</button>';
    $output .= '</a>';
    $output .= '</div>';
    $output .= '<br/>';
    
    return $output;
}
