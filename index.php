<?php
require_once(__DIR__ . '/../../../config.php');
//$cmid = required_param('id', PARAM_INT);
//$cm = get_coursemodule_from_id('dmarag', $cmid, 0, false, MUST_EXIST);
//$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
 
//require_login($course, true, $cm);
//$PAGE->set_url('/tool/dmarag/view.php', array('id' => $cm->id));

$PAGE->set_url(new moodle_url('/admin/tool/dmarag/view.php', array('key' => 'value', 'id' => 1)));
$PAGE->set_title('My tool plugin page title');
$PAGE->set_heading('My tool page heading');


//echo $OUTPUT->header(); 

echo get_string("hello_word", "tool_dmarag");

//echo $OUTPUT->footer();