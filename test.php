<?php
require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/lib.php');

global $DB;

# add test data to tool_dmarag table

$table = 'tool_dmarag';
$courseid = 2;
$my_course_name = "my course name";
$completed = 0;
$priority = 1;
$timecreated = time();
$timemodified = time();

//$DB->delete_records($table); 

$record = new stdClass();
$record->courseid = 2;
$record->name = $my_course_name;
$record->completed = $completed;
$record->priority = $priority;
$record->timecreated = $timecreated;
$record->timemodified = $timemodified;

$return_id = $DB->insert_record($table, $record, true, false); 

echo $return_id;


