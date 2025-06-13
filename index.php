<?php
require('../../config.php');
require_once('form.php');

$courseid = required_param('id', PARAM_INT);
require_login($courseid);

$context = context_course::instance($courseid);
require_capability('local/soccerteam:view', $context);

$PAGE->set_url(new moodle_url('/local/soccerteam/index.php', ['id' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_title('Soccer Team');
$PAGE->set_heading('Soccer Team');

$form = new soccerteam_form(null, ['courseid' => $courseid]);

if ($form->is_cancelled()) {
    redirect(new moodle_url('/course/view.php', ['id' => $courseid]));
} else if ($data = $form->get_data()) {
    global $DB, $USER;

    $record = (object)[
        'userid' => $USER->id,
        'courseid' => $courseid,
        'playerid' => $data->playerid,
        'position' => $data->position,
        'jerseynumber' => $data->jerseynumber,
        'timecreated' => time(),
        'timemodified' => time()
    ];

    $inserted = $DB->insert_record('local_soccerteam_data', $record);

    if ($inserted) {
        redirect($PAGE->url, 'Player added successfully.', 2);
    } else {
        print_error('Could not insert data');
    }
}

echo $OUTPUT->header();
$form->display();
echo $OUTPUT->footer();
