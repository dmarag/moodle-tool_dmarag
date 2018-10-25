<?php
require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/lib.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/classes/tool_dmarag.php');

global $DB;
$courseid = required_param('id', PARAM_INT);

// require_login() to the course
require_login($courseid);	
$context = context_course::instance($courseid);
require_capability('tool/dmarag:view', $context);

// Set up the page.
$title = get_string('pluginname', 'tool_dmarag');
$pagetitle = $title;

$url = new moodle_url('/admin/tool/dmarag/index.php', ['id' => $courseid]);
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);

# get page renderer 
$output = $PAGE->get_renderer('tool_dmarag');
echo $output->header();

//echo $OUTPUT->header();


$headings = array(get_string('table_title', 'tool_dmarag'), "", "", "", "", "", "", "" );
$align = array('left'); 

$content = array();
$content = get_tool_dmarag_table_data($courseid);


//echo $output->render_index($headings, $align, $content);

//print_r($content);
//echo '<br/>';echo '<br/>';echo '<br/>';echo '<br/>';


$indexpage = new \tool_dmarag\output\indexpage($headings, $content);

echo $output->render_indexpage($indexpage);


# Add new entry.
if (has_capability('tool/dmarag:edit', $context))
{
    echo '</br></br>';
    echo html_writer::div(html_writer::link(new moodle_url('/admin/tool/dmarag/edit.php', ['id' => $courseid]), get_string('add_new', 'tool_dmarag')));
}

//echo $OUTPUT->header(); 
//echo $OUTPUT->heading($pagetitle);

# table data from db table tool_dmarag
//$table = new tool_dmarag_table('tool_dmarag', $courseid);
//$table->out(0, false);

# Add new entry.
//if (has_capability('tool/dmarag:edit', $context)) {
//    echo html_writer::div(html_writer::link(new moodle_url('/admin/tool/dmarag/edit.php', ['id' => $courseid]), get_string('new')));
//}

//echo $OUTPUT->footer();
echo $output->footer();

# RENDERER
# In the pre-renderer index file, I used PHP's echo statement with Moodle's global $OUTPUT object and html_writer helper class to display the screen output. 
# The global $OUTPUT object is the global renderer object available to any script in Moodle. 
# If a script is not using renderers, it will likely use this object to perform its necessary output operations. 
# When a plugin uses its own renderer, it instantiates its own renderer object and uses it in place of $OUTPUT.
