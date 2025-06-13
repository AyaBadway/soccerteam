<?php
defined('MOODLE_INTERNAL') || die();

// add new item to internal menu in courses in moodle that have name Soccer Team.
// this will be accessed only by users who has roles mangers and teachers.
function local_soccerteam_extend_navigation_course($navigation, $course, $context) {
    if (has_capability('local/soccerteam:view', $context)) {
        $url = new moodle_url('/local/soccerteam/index.php', ['id' => $course->id]);
        $navigation->add(get_string('soccerteam', 'local_soccerteam'), $url, navigation_node::TYPE_CUSTOM);
    }
}
