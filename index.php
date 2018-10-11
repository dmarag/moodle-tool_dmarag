<?php
require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/lib.php');

global $DB;
$courseid = required_param('id', PARAM_INT);

# get course object 
//$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
//$context_course = context_course::instance($courseid);

// Set up the page.
$title = get_string('pluginname', 'tool_dmarag');
$pagetitle = $title;
//$url = new moodle_url("/admin/tool/dmarag/index.php");
$url = new moodle_url('/admin/tool/dmarag/index.php', ['id' => $courseid]);
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);
 
echo $OUTPUT->header(); 
echo $OUTPUT->heading($pagetitle);

$out .= html_writer::tag('br', '');
$out .= html_writer::start_div('hello_word_div');
$out .= html_writer::start_span('hello_word_span') . ''.get_string("hello_word", "tool_dmarag").'' . html_writer::end_span();

$out .= html_writer::tag('br', '');

$out .= html_writer::start_span('courseid_span') . ''.get_string("course").': '.$courseid.'' . html_writer::end_span();

html_writer::end_div();

echo $out;

echo $OUTPUT->footer(); 