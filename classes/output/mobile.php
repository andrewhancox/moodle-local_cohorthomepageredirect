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
 * @package local_cohorthomepageredirect
 * @author Andrew Hancox <andrewdchancox@googlemail.com>
 * @author Open Source Learning <enquiries@opensourcelearning.co.uk>
 * @link https://opensourcelearning.co.uk
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2021, Andrew Hancox
 */

namespace local_cohorthomepageredirect\output;

defined('MOODLE_INTERNAL') || die();

use context_system;

class mobile {

    /**
     * Returns the course view for the mobile app.
     *
     * @param array $args Arguments from tool_mobile_get_content WS
     *
     * @return array HTML, javascript and otherdata
     */
    public static function mobile_course_view($args) {
        return [
                'templates'  => [
                        [
                                'id'   => 'unused',
                                'html' => 'unused',
                        ],
                ],
                'javascript' => '',
        ];
    }

    private static function get_cohort_redirect_url() {
        global $USER, $CFG;

        require_once("$CFG->dirroot/cohort/lib.php");

        $context = context_system::instance();
        $cohorts = cohort_get_user_cohorts($USER->id);
        $pluginconfig = get_config('local_cohorthomepageredirect');

        foreach ($cohorts as $cohort) {
            if ($cohort->contextid != $context->id) {
                continue;
            }
            if (empty($pluginconfig->{"cohorthomepageredirect_mobile_$cohort->id"})) {
                continue;
            }
            return ($pluginconfig->{"cohorthomepageredirect_mobile_$cohort->id"});
        }

        return false;
    }

    public static function init_corecourseoptionsdelegate($args) {
        $retval = ['templates' => [], 'javascript' => ""];
        $cohorturl = self::get_cohort_redirect_url();

        if (!empty($cohorturl)) {
            $retval['javascript'] = "
                    var navservice = this.CoreNavigatorService;
                    navservice.navigateCore = navservice.navigate;
                    navservice.navigate = async function (path, options = {}) {
                        if (path == '/main/home/site' || path == '/main/home' || path == '/main/home/dashboard') {
                            return navservice.navigateToSitePath('$cohorturl' , {reset: true});
                        } else {
                            return navservice.navigateCore(path, options);
                        }
                    };
                    navservice.navigateToSitePath('$cohorturl', {reset: true});
                    ";
        }
        return $retval;
    }
}
