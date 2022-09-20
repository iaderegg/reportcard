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
 * Unit tests for user class.
 *
 * @package    report_reportcard
 * @category   phpunit
 * @author     Iader E. García Gómez <iadergg@gmail.com>
 * @copyright  2022 Iader E. Garcia Gomez <iadergg@gmail.com>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_reportcard;

use advanced_testcase;
use stdClass;

defined('MOODLE_INTERNAL') || die();

global $CFG;

class user_test extends advanced_testcase {

    public function test_get_student_courses() {

        $this->resetAfterTest(true);

        // Creating users.
        $user1 = $this->getDataGenerator()->create_user();

        $user = new user();
        $courses = $user->get_student_courses($user1->id);

        $this->assertIsArray($courses);
    }
}
