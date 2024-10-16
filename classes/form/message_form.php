<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Form library file
 *
 * @package     local_helloworld
 * @copyright   2024 Edisson Sigua <edissonf.sigua@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_helloworld\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');
/**
 * Clase de Definicion de un formulario
 */
class message_form extends \moodleform {
    /**
     * Definicion de formulario
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('textarea', 'message', get_string('textinfoinput', 'local_helloworld'));
        $mform->setType('message', PARAM_TEXT);

        $submitlabel = get_string('submit');
        $mform->addElement('submit', 'submitmessage', $submitlabel);
    }
}
