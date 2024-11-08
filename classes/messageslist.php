<?php
// This file is part of Moodle - http://moodle.org/
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

namespace local_helloworld;

defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/tablelib.php");

/**
 * Class messageslist
 *
 * @package     local_helloworld
 * @copyright   2024 Edisson Sigua <edissonf.sigua@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class messageslist extends \table_sql {
    /**
     * Constructor
     * @param int $uniqueid all tables have to have a unique id, this is used
     *      as a key when storing table properties like sort order in the session.
     */
    public function __construct($uniqueid) {
        parent::__construct($uniqueid);
        // Define the list of columns to show.
        $columns = ['message', 'userid', 'timecreated'];
        $this->define_columns($columns);

        // Define the titles of columns to show in header.
        $headers = [
            get_string('message'),
            get_string('user'),
            get_string('timecreated'),
        ];
        $this->define_headers($headers);
    }

    /**
     * This function is called for each data row to allow processing of the
     * userid value.
     *
     * @param object $row Contains object with all the values of record.
     * @return $string Return a href html tag with url to user profile.
     */
    public function col_userid($row) {
        return \html_writer::link(
            new \moodle_url('/user/view.php',
            ['id' => $row->userid]), fullname($row)
        );
    }

    /**
     * This function is called for each data row to allow processing of
     * timecreated value
     * @param object $row Contains object with all the values of record.
     * @return string Return human readable date
     */
    public function col_timecreated($row) {
        return userdate($row->timecreated);
    }

    /**
     * This function is called for each data row to allow processing of
     * message value
     * @param object $row Contains object with all the values of record.
     * @return string Return formatted message.
     */
    public function col_message($row) {
        return format_text($row->message);
    }
}
