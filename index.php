<?php
require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/lib.php');

global $DB;
$courseid = required_param('id', PARAM_INT);

# get course object 
$course_shortname = "";
$course_fullname = "";
//$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$course = $DB->get_record_sql("SELECT * FROM {course} WHERE id = ?", [$courseid]);
if(!empty($course))
{
	$course_shortname = format_string($course->shortname);
	$course_fullname = format_string($course->fullname);
}

// Set up the page.
$title = get_string('pluginname', 'tool_dmarag');
$pagetitle = $title;

$url = new moodle_url('/admin/tool/dmarag/index.php', ['id' => $courseid]);
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);
 
echo $OUTPUT->header(); 
echo $OUTPUT->heading($pagetitle);

$out .= html_writer::tag('br', '');
$out .= html_writer::start_div('hello_word_div');
$out .= html_writer::start_span('hello_word_span') . ''.get_string("hello_word", "tool_dmarag").'' . html_writer::end_span();
$out .= html_writer::end_div();

$out .= html_writer::tag('br', '');

$out .= html_writer::start_div('course_info_div');

$out .= get_string("course");
$out .= html_writer::tag('br', '');
$out .= 'id: '.$courseid;

$out .= html_writer::tag('br', '');

$out .= get_string("shortname").': ';
$out .= $course_shortname;

$out .= html_writer::tag('br', '');

$out .= get_string("fullname").': ';
$out .= $course_fullname;

$out .= html_writer::tag('br', '');

html_writer::end_div();

echo $out;

echo $OUTPUT->footer(); 