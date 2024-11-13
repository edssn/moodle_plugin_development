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

/**
 * Javascript Greeting module selectors
 *
 * @module     local_helloworld/local/greetings/selectors
 * @copyright  2024 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

export default {
    actions: {
        showGreetingButton: '[data-action="local_helloworld/greeting-greet_button"]',
        resetButton: '[data-action="local_helloworld/greeting-reset_button"]',
    },
    regions: {
        greetingBlock: '[data-region="local_helloworld/greeting-usergreeting"]',
        inputField: '[data-region="local_helloworld/greeting-input"]',
    },
};