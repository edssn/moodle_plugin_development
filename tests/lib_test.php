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
 * Plugin lib test file
 *
 * @package     local_helloworld
 * @copyright   2024 Edisson Sigua <edissonf.sigua@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_helloworld;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/local/helloworld/lib.php');

/**
 * Greeting library test
 *
 * @package     local_helloworld
 * @copyright   2024 Edisson Sigua <edissonf.sigua@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class lib_test extends \advanced_testcase {

    /**
     * Testing the translation
     *
     * @covers ::local_helloworld_get_greeting
     *
     * @dataProvider local_helloworld_get_greeting_provider
     * @param string|null $lang User language
     * @param string $langstring Greeting message language string
     */
    public function test_local_helloworld_get_greeting(?string $lang, string $langstring) {
        $user = null;
        if (!empty($lang)) {
            $this->resetAfterTest(true);
            $user = $this->getDataGenerator()->create_user();
            $user->lang = $lang;
        }

        $this->assertSame(
            get_string($langstring, 'local_helloworld', fullname($user)),
            local_helloworld_get_greeting($user)
        );
    }

    /**
     * Data provider for {@see test_local_helloworld_get_greeting()}
     *
     * @return array List of data to test
     */
    public function local_helloworld_get_greeting_provider() {
        return [
            'No user' => [
                'lang' => null,
                'langstring' => 'greetinguser',
            ],
            'ES user' => [
                'lang' => 'es',
                'langstring' => 'greetinguseres',
            ],
            'FR user' => [
                'lang' => 'fr',
                'langstring' => 'greetinguserfr',
            ],
            'IT user' => [
                'lang' => 'it',
                'langstring' => 'greetinguserit',
            ],
            'DE user' => [
                'lang' => 'de',
                'langstring' => 'greetingloggedinuser',
            ],
        ];
    }
}
