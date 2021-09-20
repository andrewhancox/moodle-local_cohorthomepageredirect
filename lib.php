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

function local_cohorthomepageredirect_after_require_login($courseorid, $autologinguest, $cm, $setwantsurltome, $preventredirect) {
    global $SCRIPT, $USER, $CFG, $SESSION;
    require_once("$CFG->dirroot/cohort/lib.php");

    if (isset($cm)) {
        return;
    }

    if (is_siteadmin()) {
        return;
    }

    if (!empty(WS_SERVER) || !empty(AJAX_SCRIPT)) {
        return;
    }

    if (!empty($SESSION->local_cohorthomepageredirect_loop_protect)) {
        return;
    }

    $courseid = null;

    $context = context_system::instance();
    $pluginconfig = get_config('local_cohorthomepageredirect');

    if (
            ($SCRIPT == '/index.php' && !empty($pluginconfig->redirectsitehome))
            ||
            ($SCRIPT == '/my/index.php' && !empty($pluginconfig->redirectdashboard))
    ) {
        $cohorts = cohort_get_user_cohorts($USER->id);

        foreach ($cohorts as $cohort) {
            if ($cohort->contextid != $context->id) {
                continue;
            }
            if (empty($pluginconfig->{"cohorthomepageredirect_$cohort->id"})) {
                continue;
            }
            $SESSION->local_cohorthomepageredirect_loop_protect = true;
            redirect($pluginconfig->{"cohorthomepageredirect_$cohort->id"});
        }
    }
}

function local_cohorthomepageredirect_before_footer() {
    global $SESSION;
    unset($SESSION->local_cohorthomepageredirect_loop_protect);
}
