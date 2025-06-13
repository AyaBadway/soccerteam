<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'local/soccerteam:view' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => [
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ]
    ]
];
