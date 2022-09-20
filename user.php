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

/**
 * User report card
 *
 * @package    report_reportcard
 * @copyright  2022 Iader E. Garcia Gomez <iadergg@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

require_login();

if (isguestuser()) {
    throw new moodle_exception('noguest');
}

$context = context_system::instance();

require_capability('report/reportcard:view_own_report', $context);

if (is_siteadmin($USER->id)) {
    $userid = required_param('id', PARAM_INT);
} else {
    $userid = $USER->id;
}

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/report/reportcard/index.php'));
$PAGE->set_pagelayout('admin');
$PAGE->set_title($SITE->fullname);
$PAGE->set_heading(get_string('pluginname', 'report_reportcard'));

$user = $DB->get_record('user', array('id' => $userid));

$rendererplugin = $PAGE->get_renderer('report_reportcard');

$data = new stdClass();
$data->photo = $OUTPUT->user_picture($user, array('size' => 1, 'class' => 'userpicture'));
$data->firstname = $user->firstname;
$data->lastname = $user->lastname;
$data->coursestable = $rendererplugin->render_user_courses_table($user->id);

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('report_reportcard/user', $data);
echo $OUTPUT->footer();
