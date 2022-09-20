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
 * Plugin renderer.
 *
 * @package    report_reportcard
 * @copyright  2022 Iader E. Garcia Gomez <iadergg@gmail.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_reportcard\output;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/gradelib.php');
require_once($CFG->dirroot.'/grade/querylib.php');

use plugin_renderer_base;
use report_reportcard\user_manager;
use report_reportcard\user;
use html_table;
use html_writer;
use moodle_url;
use stdClass;

/**
 * Plugin renderer.
 *
 * @package    local_deleteoldcourses
 * @copyright  2022 Iader E. Garcia Gomez <iadergg@gmail.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {

    /**
     * Returns HTML users table.
     *
     * @return string $htmltable
     */
    public function render_users_table() {

        $usermanager = new user_manager();
        $htmlwriter = new html_writer();

        $table = new html_table();
        $table->head  = array(
            get_string('username'),
            get_string('name'),
            get_string('lastname'),
            get_string('email'),
            get_string('report'));
        $table->id = 'report-card-users-table';
        $table->colclasses = array('mdl-left', 'mdl-align', 'mdl-align', 'mdl-align', 'mdl-align');
        $table->data  = array();
        $table->attributes['class'] = 'table table-striped';

        $users = $usermanager->get_users();

        foreach ($users as $user) {
            $url = new moodle_url('/report/reportcard/user.php', array('id' => $user->id));
            unset($user->id);
            $img = $htmlwriter->img(new moodle_url('/report/reportcard/pix/report.png'), '', array('height' => 20, 'width' => 20));
            $user->report = $htmlwriter->link($url, $img);
        }

        $table->data = $users;

        return html_writer::table($table);
    }

    /**
     * Returns HTML courses table.
     *
     * @return string $htmltable
     */
    public function render_user_courses_table($userid) {

        $usermanager = new user();
        $htmlwriter = new html_writer();

        $table = new html_table();
        $table->head  = array(
            get_string('course_shortname', 'report_reportcard'),
            get_string('course_fullname', 'report_reportcard'),
            get_string('grade', 'report_reportcard'));
        $table->id = 'report-card-courses-table';
        $table->colclasses = array('mdl-left', 'mdl-left', 'mdl-align');
        $table->data  = array();
        $table->attributes['class'] = 'table table-striped';

        $coursesraw = $usermanager->get_student_courses($userid);
        $coursestoprint = array();

        foreach ($coursesraw as $courseraw) {
            $url = new moodle_url('/course/view.php', array('id' => $courseraw->id));

            $finalgrade = grade_get_course_grade($userid, $courseraw->id)->str_grade;

            if (!$finalgrade) {
                $finalgrade = get_string('no_grade', 'report_reportcard');
            }

            $coursetoprint = new stdClass();
            $coursetoprint->shortname = $htmlwriter->link($url, $courseraw->shortname, array('target' => '_blank'));
            $coursetoprint->fullname = $htmlwriter->link($url, $courseraw->fullname, array('target' => '_blank'));
            $coursetoprint->finalgrade = $finalgrade;

            array_push($coursestoprint, $coursetoprint);
        }

        $table->data = $coursestoprint;

        return $htmlwriter->table($table);
    }

}
