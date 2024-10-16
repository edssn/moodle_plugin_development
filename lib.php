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
 * Library of functions for local_helloworld
 *
 * @package     local_helloworld
 * @copyright   2024 Edisson Sigua <edissonf.sigua@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 *  Obtener un mensaje basado en el idioma preferido del usuario
 *
 * @param \stdClass $user
 * @return string
 */
function local_helloworld_get_greeting($user) {
    if ($user == null) {
        return get_string('greetinguser', 'local_helloworld');
    }

    $lang = $user->lang;
    switch ($lang) {
        case 'es':
            $langstr = 'greetinguseres';
            break;
        case 'fr':
            $langstr = 'greetinguserfr';
            break;
        case 'it':
            $langstr = 'greetinguserit';
            break;
        default:
            $langstr = 'greetingloggedinuser';
            break;
    }

    return get_string($langstr, 'local_helloworld', fullname($user));
}

/**
 * Inserta un enlace a index.php en el menu de navegacion de la pagina principal
 *
 * @param navigation_node $frontpage Nodo que almacena la pagina principal en el arbol de navegacion
 */
function local_helloworld_extend_navigation_frontpage(navigation_node $frontpage) {
    $frontpage->add(
        get_string('pluginname', 'local_helloworld'),
        new moodle_url('/local/helloworld/index.php'),
        navigation_node::TYPE_CUSTOM
    );
}

/**
 * Inserta un enlace a index.php en el menu de navegacion de la pagina principal con el tema Clasico
 *
 * @param navigation_node $frontpage Nodo que almacena la pagina principal en el arbol de navegacion
 */
function local_helloworld_extend_navigation(global_navigation $root) {
    $node = navigation_node::create(
        get_string('pluginname', 'local_helloworld'),
        new moodle_url('/local/helloworld/index.php'),
        navigation_node::TYPE_CUSTOM,
        null,
        null,
        new pix_icon('t/message', '')
    );

    $node->showinflatnavigation = true;
    $root->add_node($node);
}
