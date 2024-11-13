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
 * JavaScript module greeting
 *
 * @module     local_helloworld/greetings
 * @copyright  2024 Edisson Sigua <edissonf.sigua@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import Selectors from 'local_helloworld/local/greeting/selectors';
import * as Repository from 'local_helloworld/local/greeting/repository';
import * as Str from 'core/str';

/**
 *
 * @param {Number} userid
 */
export const init = (userid) => {
    registerEventListeners(userid);
};

/**
 *
 * @param {Number} userid
 */
const registerEventListeners = (userid) => {
    document.addEventListener('click', e => {
        if (e.target.closest(Selectors.actions.showGreetingButton)) {
            const greetingBlock = document.querySelector(Selectors.regions.greetingBlock);

            Repository.getUser(userid)
            .then(function(response) {
                window.console.log({ user: response[0] });
            });

            if (greetingBlock) {
                const nameField = document.querySelector(Selectors.regions.inputField);
                const msg = document.createElement("h3");

                userGreeting(nameField.value)
                .then((greetingStr) => {
                    msg.append(greetingStr);
                    greetingBlock.append(msg);
                    nameField.value = '';
                })
                .catch();

            }
        }
        if (e.target.closest(Selectors.actions.resetButton)) {
            const nameField = document.querySelector(Selectors.regions.inputField);
            nameField.value = '';

            const greetingBlock = document.querySelector(Selectors.regions.greetingBlock);
            greetingBlock.innerHTML  = '';
        }
    });
};

/**
 * Return a personalised greeting.
 *
 * @param   {String} name The name of the person to greet
 * @returns {Promise}
 */
const userGreeting = (name) => Str.get_string('greetinguseres', 'local_helloworld', name);