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
 * User manager class
 *
 * @package    report_reportcard
 * @copyright  2022 Iader E. Garcia Gomez <iadergg@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_reportcard;

defined('MOODLE_INTERNAL') || die;

/**
 * User manager class
 *
 * @package    report_reportcard
 * @copyright  2022 Iader E. Garcia Gomez <iadergg@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class user_manager {

    /**
     * Get users
     *
     * @return array $users
     * @since  Moodle 4.0
     */
    public function get_users() {

        global $DB, $CFG;

        $siteadmins = explode(',', $CFG->siteadmins);
        $siteguest = explode(',', $CFG->siteguest);

        $whereclause = '';

        foreach ($siteadmins as $index => $admin) {
            if ($index == count($siteadmins) - 1 && count($siteguest) == 0) {
                $whereclause .= 'id <> ' . $admin;
            } else {
                $whereclause .= 'id <> ' . $admin . ' AND ';
            }
        }

        foreach ($siteguest as $index => $guest) {
            if ($index == count($siteguest) - 1) {
                $whereclause .= 'id <> ' . $guest;
            } else {
                $whereclause .= 'id <> ' . $guest . ' AND ';
            }
        }

        $sqlquery = 'SELECT username, firstname, lastname, email, id
                     FROM {user}
                     WHERE ' . $whereclause;

        $users = $DB->get_records_sql($sqlquery);

        return $users;
    }
}
