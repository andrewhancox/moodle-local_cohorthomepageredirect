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

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    require_once("$CFG->dirroot/cohort/lib.php");
    $context = context_system::instance();
    $cohorts = cohort_get_cohorts($context->id);

    $settingspage =
            new admin_settingpage('local_cohorthomepageredirect', new lang_string('pluginname', 'local_cohorthomepageredirect'));

    $settingspage->add(new admin_setting_configcheckbox("local_cohorthomepageredirect/redirectsitehome",
            new lang_string('redirectsitehome', 'local_cohorthomepageredirect'), '', true));

    $settingspage->add(new admin_setting_configcheckbox("local_cohorthomepageredirect/redirectdashboard",
            new lang_string('redirectdashboard', 'local_cohorthomepageredirect'), '', true));

    foreach ($cohorts['cohorts'] as $cohort) {
        $name = format_string($cohort->name);
        $settingspage->add(new admin_setting_configtext("local_cohorthomepageredirect/cohorthomepageredirect_$cohort->id",
            $name, '', '', PARAM_URL));
        $settingspage->add(new admin_setting_configtext("local_cohorthomepageredirect/cohorthomepageredirect_mobile_$cohort->id",
                $name . get_string('mobileapp', 'local_cohorthomepageredirect'), '', '', PARAM_URL));
    }

    $ADMIN->add('accounts', $settingspage);
}
