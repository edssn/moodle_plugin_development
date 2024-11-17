<?php
// This file is part of the Allocation form plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
//

/**
 * Setup the webservices for the plugin.
 *
 * @package    local_helloworld
 * @copyright  2024 Edisson Sigua <edissonf.sigua@gmail.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'local_helloworld_create_message' => [
        'classname' => 'local_helloworld\external\create_message',
        'methodname' => 'execute',
        'classpath' => 'local/helloworld/classes/external/create_message.php',
        'description' => "Add a post.",
        'type' => 'write',
        'capabilities'  => 'local/helloworld:postmessages',
        'services' => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
];
