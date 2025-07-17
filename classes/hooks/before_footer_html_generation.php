<?php

namespace local_cohorthomepageredirect\hooks;

class before_footer_html_generation {
    public static function execute() {
        global $SESSION;
        unset($SESSION->local_cohorthomepageredirect_loop_protect);
    }
}