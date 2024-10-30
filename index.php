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
 * Plugin main file
 *
 * @package     local_helloworld
 * @copyright   2024 Edisson Sigua <edissonf.sigua@gmail.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot. '/local/helloworld/lib.php');

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/helloworld/index.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading(get_string('pluginname', 'local_helloworld'));

require_login();

if (isguestuser()) {
    throw new moodle_exception("noguest");
}

$allowpost = has_capability('local/helloworld:postmessages', $context);
$deleteanypost = has_capability('local/helloworld:deleteanymessage', $context);
$deletepost = has_capability('local/helloworld:deleteownmessage', $context);

$action = optional_param('action', '', PARAM_TEXT);

if ($action == 'del') {
    require_sesskey();

    if ($deleteanypost || $deletepost) {
        $id = required_param('id', PARAM_TEXT);

        $params = ['id' => $id];

        if (!$deleteanypost) {
            $params += ['userid' => $USER->id];
        }

        $DB->delete_records('local_helloworld_messages', $params);

        redirect($PAGE->url);
    }

}


$messageform = new \local_helloworld\form\message_form();

if ($data = $messageform->get_data()) {
    require_capability('local/helloworld:postmessages', $context);
    $message = required_param('message', PARAM_TEXT);

    if (!empty($message) && !empty(trim($message))) {
        $record = new stdClass;
        $record->message = $message;
        $record->timecreated = time();
        $record->userid = $USER->id;

        $DB->insert_record('local_helloworld_messages', $record);

        redirect($PAGE->url);
    }
}


echo $OUTPUT->header();

if (isloggedin()) {
    echo local_helloworld_get_greeting($USER);
} else {
    echo get_string('greetinguser', 'local_helloworld');
}

if ($allowpost) {
    $messageform->display();
}

if (has_capability('local/helloworld:viewmessages', $context)) {
    $userfields = \core_user\fields::for_name()->with_identity($context);
    $userfieldssql = $userfields->get_sql('u');

    $sql = "SELECT m.id, m.message, m.timecreated, m.userid {$userfieldssql->selects}
            FROM {local_helloworld_messages} m
        LEFT JOIN {user} u ON u.id = m.userid
        ORDER BY timecreated DESC";

    $messages = $DB->get_records_sql($sql);

    echo $OUTPUT->box_start('card-columns');

    $cardbgcolor = get_config('local_helloworld', 'messagecardbgcolor');

    foreach ($messages as $m) {
        echo html_writer::start_tag('div', ['class' => 'card', 'style' => "background: $cardbgcolor"]);
        echo html_writer::start_tag('div', ['class' => 'card-body']);
        echo html_writer::tag('p', format_text($m->message), ['class' => 'card-text']);
        echo html_writer::tag('p', get_string('postedby', 'local_helloworld', $m->firstname), ['class' => 'card-text']);
        echo html_writer::start_tag('p', ['class' => 'card-text']);
        echo html_writer::tag('small', userdate($m->timecreated), ['class' => 'card-muted']);
        echo html_writer::end_tag('p');

        if ($deleteanypost || ($deletepost && $m->userid == $USER->id)) {
            echo html_writer::start_tag('p', ['class' => 'card-footer text-center']);
            echo html_writer::link(
                new moodle_url(
                    '/local/helloworld/index.php',
                    ['action' => 'del', 'id' => $m->id, 'sesskey' => sesskey()]
                ),
                $OUTPUT->pix_icon('t/delete', '') . get_string('delete'),
                ['role' => 'button', 'aria-label' => get_string('delete'), 'title' => get_string('delete')]
            );
            echo html_writer::end_tag('p');
        }

        echo html_writer::end_tag('div');
        echo html_writer::end_tag('div');
    }

    echo $OUTPUT->box_end();
}

echo $OUTPUT->footer();
