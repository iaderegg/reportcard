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
 * User class
 *
 * @package    report_reportcard
 * @copyright  2022 Iader E. Garcia Gomez <iadergg@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_reportcard;

defined('MOODLE_INTERNAL') || die;

/**
 * User class
 *
 * @package    report_reportcard
 * @copyright  2022 Iader E. Garcia Gomez <iadergg@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class user {

    /**
     * Get user courses.
     *
     * @param  int $userid
     * @return array $usercourses
     * @since  Moodle 4.0
     */
    public function get_student_courses($userid) {

        $usercourses = enrol_get_users_courses($userid);

        return $usercourses;
    }
}
