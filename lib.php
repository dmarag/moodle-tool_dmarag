<?php

function tool_dmarag_extend_navigation_course($navigation, $course, $context) 
{
	if (has_capability('tool/dmarag:view', $context)) {
	
		$navigation->add(
			get_string('pluginname', 'tool_dmarag'),
				new moodle_url('/admin/tool/dmarag/index.php', ['id' => $course->id]), navigation_node::TYPE_SETTING, 
				get_string('pluginname', 'tool_dmarag'), 'dmarag', new pix_icon('icon', '', 'tool_dmarag'));
	
	}
	
}


/**
 * Return the editor options when editing a tool_dmarag entry
 */
function dmarag_get_editor_options($course, $context, $entry)
{
    $maxfiles = 99;                // TODO: add some setting.
    $maxbytes = $course->maxbytes; // TODO: add some setting.

    //function: file_area_contains_subdirs(context $context, $component, $filearea, $itemid)
    $descriptionoptions = array('trusttext' => true, 'maxfiles' => $maxfiles, 'maxbytes' => $maxbytes, 'context' => $context, 'subdirs' => file_area_contains_subdirs($context, 'tool_dmarag', 'entry', $entry->id));

    return $descriptionoptions;
}

# update tool record
function dmarag_edit_entry($entry, $course, $tool_id, $context)
{
    global $CFG, $DB, $USER;

    $record = new stdClass();
    $record->id = $tool_id;
    $record->courseid = $entry->courseid;
    $record->name = $entry->name;
    $record->completed = $entry->completed;
    $record->timemodified = time();

    $record->description       = '';          // Updated later.
    $record->descriptionformat = FORMAT_HTML; // Updated later.
    $record->descriptiontrust  = 0;           // Updated later.

    $DB->update_record('tool_dmarag', $record);


    // Save and relink embedded images and save attachments.
    if (!empty($entry->description_editor)) {
        $descriptionoptions = dmarag_get_editor_options($course, $context, $record);
        $record = file_postupdate_standard_editor($record, 'description', $descriptionoptions, $context, 'tool_dmarag', 'entry', $record->id);

        $record->description = $entry->description_editor['text'];
        $record->descriptionformat = $entry->description_editor['format'];
    }

    //$record->description = $entry->description_editor;
    // Store the updated value values.
    $DB->update_record('tool_dmarag', $record);

    // Refetch complete entry.
    $record = $DB->get_record('tool_dmarag', array('id' => $record->id));

    //$courseid = $record->courseid;
    //redirect(new moodle_url($CFG->wwwroot.'/admin/tool/dmarag/index.php', ['id' => $courseid]));

    return $record;
}

# add new record
function dmarag_addnew_entry($entry, $course, $context) {
    global $CFG, $DB, $USER;

    $record = new stdClass();

    $record->courseid = $entry->courseid;
    $record->name = $entry->name;
    $record->completed = $entry->completed;
    $record->priority = 0;
    $record->timecreated = time();
    $record->timemodified = time();

    $record->description       = '';          // Updated later.
    $record->descriptionformat = FORMAT_HTML; // Updated later.
    $record->descriptiontrust  = 0;           // Updated later.

    $record->id = $DB->insert_record('tool_dmarag', $record);


    // Save and relink embedded images and save attachments.
    if (!empty($entry->description_editor)) {
        $descriptionoptions = dmarag_get_editor_options($course, $context, $record);
        $record = file_postupdate_standard_editor($record, 'description', $descriptionoptions, $context, 'tool_dmarag', 'entry', $record->id);

        $record->description = $entry->description_editor['text'];
        $record->descriptionformat = $entry->description_editor['format'];
    }

    //$record->description = $entry->description_editor;
    // Store the updated value values.
    $DB->update_record('tool_dmarag', $record);

    // Refetch complete entry.
    $record = $DB->get_record('tool_dmarag', array('id' => $record->id));

    return $record;
}


# for renderer
function get_tool_dmarag_table_data($courseid)
{
    global $DB;

    $records = $DB->get_records("tool_dmarag");

    $data[] = array('id',
                    get_string('name', 'tool_dmarag'),
                    get_string('description', 'tool_dmarag'),
                    get_string('completed', 'tool_dmarag'),
                    get_string('priority', 'tool_dmarag'),
                    get_string('timecreated', 'tool_dmarag'),
                    get_string('timemodified', 'tool_dmarag'),
                    '');

    foreach ($records as $record)
    {
        $id = $record->id;
        $name = html_writer::link(new moodle_url('/admin/tool/dmarag/edit.php', ['id' => $courseid, 'tool_dmarag' => $record->id]), $record->name);
        $description = $record->description;
        $completed = $record->completed ? get_string('yes') : get_string('no');
        $priority = $record->priority ? get_string('yes') : get_string('no');
        $timecreated = userdate($record->timecreated, '');
        $timemodified = userdate($record->timemodified, get_string('strftimedatetime'));

        $delete = html_writer::link(new moodle_url('/admin/tool/dmarag/delete.php', ['id' => $record->courseid, 'tool_dmarag' => $record->id, 'delete'=>1]), get_string('delete'));

        $data[] = array($id, $name, $description, $completed, $priority, $timecreated, $timemodified, $delete);
    }

    return $data;

}
