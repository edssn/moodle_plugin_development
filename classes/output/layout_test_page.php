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

namespace local_helloworld\output;

use renderable;
use renderer_base;
use templatable;
use stdClass;

/**
 * Class layout_test_page
 *
 * @package     local_helloworld
 * @copyright   2024 Edisson Sigua <edissonf.sigua@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class layout_test_page implements renderable, templatable {

    /** @var string $sometext Some text */
    private $sometext;

    /**
     * Construct for layout_test_page class
     *
     * @return stdClass
     */
    public function __construct($sometext) {
        $this->sometext = $sometext;
    }

    /**
     * Export this data for a mustache remplate
     *
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        $data = new stdClass();
        $data->sometext = $this->sometext;
        return $data;
    }
}
