<?php

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/lib.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/classes/tool_dmarag.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/classes/form.php');

global $DB;
$courseid = required_param('id', PARAM_INT);
$tool_dmarag_table_id = optional_param('tool_dmarag', 0, PARAM_INT);

// require_login() to the course
require_login($courseid);	
$context = context_course::instance($courseid);
require_capability('tool/dmarag:edit', $context);


// Set up the page.
$title = get_string('pluginname', 'tool_dmarag');
$pagetitle = $title;


$url = new moodle_url('/admin/tool/dmarag/edit.php?id='.courseid);
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);
 
echo $OUTPUT->header(); 
echo $OUTPUT->heading($pagetitle);
echo '<br>';
echo '<br>';

$mform = new tool_dmarag_form();

//Form processing and displaying is done here
$return_url_cancel = new moodle_url('/admin/tool/dmarag/index.php', ['id' => $courseid]);
$return_url = new moodle_url('/admin/tool/dmarag/index.php', ['id' => $courseid]);
if ($mform->is_cancelled())
{
    //Handle form cancel operation, if cancel button is present on form
    redirect($return_url_cancel);
}
else if ($data = $mform->get_data())
{
    # create tool_dmarag object
    $record = new stdClass();
    $record->courseid = $data->id;
    $record->name = $data->name;
    $record->completed = $data->completed;

    if($data->tool_dmarag_id > 0) # edit record
    {
        $record->id = $data->tool_dmarag_id;
        $record->timemodified = time();

        $DB->update_record('tool_dmarag', $record);
    }
    else { # add new record
        //In this case you process validated data. $mform->get_data() returns data posted in form.
        $record->priority = 0;
        $record->timecreated = time();
        $record->timemodified = time();

        $return_id = $DB->insert_record('tool_dmarag', $record, true, false);
    }

    redirect($return_url);
}
else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.

    //Set default data (if any)
    //$mform->set_data($course);

    $mform->course_shortname = 'sdfkjhaskfdj';
    //displays the form
    $mform->display();
}


echo $OUTPUT->footer();

