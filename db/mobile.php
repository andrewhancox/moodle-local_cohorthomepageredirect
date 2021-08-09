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
 * Questionnaire module capability definition
 *
 * @package    local_courseoptiontest
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$addons = array(
    "local_cohorthomepageredirect" => array(
        "handlers" => array(
            'corecourseoptionsdelegate' => array(
                'displaydata' => array(
                    'title' => 'unused',
                    'icon-md' => 'unused',
                    'icon' => 'unused'
                ),
                'delegate' => 'CoreCourseOptionsDelegate',
                'method' => 'mobile_course_view',
                'init' => 'init_corecourseoptionsdelegate'
            )
        ),
        'lang' => array(
            array('unused', 'local_cohorthomepageredirect'),
        )
    )
);
