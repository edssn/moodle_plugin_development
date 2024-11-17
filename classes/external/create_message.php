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
 * Webservices for the plugin.
 *
 * @package    local_helloworld
 * @copyright  2024 Edisson Sigua <edissonf.sigua@gmail.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_helloworld\external;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');

use external_api;
use external_description;
use external_function_parameters;
use external_single_structure;
use external_value;
use external_warnings;
use invalid_parameter_exception;
use stdClass;
use context_system;

/**
 * Post a message
 *
 * @package    local_helloworld
 * @copyright  2024 Edisson Sigua <edissonf.sigua@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class create_message extends external_api {

    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'message' => new external_value(
                PARAM_TEXT,
                'Message to be added',
                VALUE_REQUIRED
            ),
        ]);
    }

    /**
     * Add post to database.
     *
     * @param  string $message Message.
     * @return array Result as defined in execute_returns.
     */
    public static function execute($message) {
        global $DB, $USER;

        $context = context_system::instance();

        $params = self::validate_parameters(
            self::execute_parameters(),
            ['message' => $message]
        );

        require_capability('local/helloworld:postmessages', $context);

        $userid = $USER->id;
        $message = trim($params['message']);

        if (empty($message)) {
            throw new invalid_parameter_exception(get_string('emptymessage', 'local_helloworld'));
        }

        $record = new stdClass;
        $record->message = $message;
        $record->timecreated = time();
        $record->userid = $userid;

        $DB->insert_record('local_helloworld_messages', $record);

        return ['warnings' => []];
    }

    /**
     * Returns the description of the webservice response.
     *
     * @return external_description
     */
    public static function execute_returns(): external_description {
        return new external_single_structure([
            'warnings' => new external_warnings(),
        ]);
    }
}
