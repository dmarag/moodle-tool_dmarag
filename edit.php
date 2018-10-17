<?php

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/lib.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/classes/tool_dmarag.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/classes/form.php');

global $CFG, $COURSE, $DB;
$courseid = required_param('id', PARAM_INT);
$tool_dmarag_table_id = optional_param('tool_dmarag', 0, PARAM_INT);

// require_login() to the course
require_login($courseid);	
$context = context_course::instance($courseid);

// require capability edit
require_capability('tool/dmarag:edit', $context);

# get course record
$course = $DB->get_record("course", array("id" => $courseid));

$edit = 0;

if($tool_dmarag_table_id > 0)
{
    // get tool_dmarag record
    $entry = $DB->get_record("tool_dmarag", array("id" => $tool_dmarag_table_id));
    $edit = 1;

} else {
    $entry = new stdClass();
    $entry->id = 0;
    $entry->courseid = $courseid;
}

// Set up the page.
$title = get_string('pluginname', 'tool_dmarag');
$pagetitle = $title;


$url = new moodle_url('/admin/tool/dmarag/edit.php?id='.courseid);
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);
 
echo $OUTPUT->header(); 
echo $OUTPUT->heading($pagetitle);
echo '</br></br>';


if($edit == 1)
{
    // create form and set initial data
    $descriptionoptions = dmarag_get_editor_options($course, $context, $entry);

    //prepare data
    $entry = file_prepare_standard_editor($entry, 'description', $descriptionoptions, $context, 'tool_dmarag', 'entry', $entry->id);
    $mform = new tool_dmarag_form(null, array('current'=>$entry, 'descriptionoptions'=>$descriptionoptions));

}
else{
    $mform = new tool_dmarag_form( null, array('current'=>$entry) );
}



//Form processing and displaying is done here
$return_url = new moodle_url('/admin/tool/dmarag/index.php', ['id' => $courseid]);
if ($mform->is_cancelled())
{
    //Handle form cancel operation, if cancel button is present on form
    redirect($return_url);
}
else if ($data = $mform->get_data())
{
    $entry = dmarag_edit_entry($data, $course, $context);
    redirect($return_url);
}
else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.

    //Set default data (if any)
    //$mform->set_data($course);


    //displays the form
    $mform->display();
}


echo $OUTPUT->footer();

