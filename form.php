<?php
require_once("$CFG->libdir/formslib.php");

class soccerteam_form extends moodleform {
    function definition() {
        global $DB;

        $mform = $this->_form;
        $courseid = $this->_customdata['courseid'];

        $context = context_course::instance($courseid);
        $students = get_enrolled_users($context, 'mod/assign:submit');

        $playeroptions = [];
        foreach ($students as $student) {
            $playeroptions[$student->id] = fullname($student);
        }

        $positionoptions = [
            'Goalkeeper' => 'Goalkeeper',
            'Defender' => 'Defender',
            'Midfielder' => 'Midfielder',
            'Forward' => 'Forward',
        ];

        $jerseynumbers = array_combine(range(1, 25), range(1, 25));

        $mform->addElement('select', 'playerid', 'Player', $playeroptions);
        $mform->addRule('playerid', null, 'required');

        $mform->addElement('select', 'position', 'Position', $positionoptions);
        $mform->addRule('position', null, 'required');

        $mform->addElement('select', 'jerseynumber', 'Jersey Number', $jerseynumbers);
        $mform->addRule('jerseynumber', null, 'required');

        $mform->addElement('hidden', 'courseid', $courseid);
        $mform->setType('courseid', PARAM_INT);

        $mform->addElement('submit', 'submitbutton', get_string('submit'));
    }

    function validation($data, $files) {
        $errors = [];

        if (empty($data['playerid']) || !is_numeric($data['playerid'])) {
            $errors['playerid'] = 'Please select a valid player.';
        }

        $validpositions = ['Goalkeeper', 'Defender', 'Midfielder', 'Forward'];
        if (!in_array($data['position'], $validpositions)) {
            $errors['position'] = 'Invalid position selected.';
        }

        if ($data['jerseynumber'] < 1 || $data['jerseynumber'] > 25) {
            $errors['jerseynumber'] = 'Jersey number must be between 1 and 25.';
        }

        return $errors;
    }
}
