<?php
defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir.'/tablelib.php');

class tool_dmarag_table extends table_sql 
{
	protected $context;
	
	public function __construct($uniqueid, $courseid) 
	{
        global $PAGE;
        parent::__construct($uniqueid);

        $this->define_columns(array('id', 'name', 'completed', 'priority', 'timecreated', 'timemodified'));
        $this->define_headers(array(
            'id',
            get_string('name', 'tool_dmarag'),
            get_string('completed', 'tool_dmarag'),
            get_string('priority', 'tool_dmarag'),
            get_string('timecreated', 'tool_dmarag'),
            get_string('timemodified', 'tool_dmarag'),
        ));
        $this->pageable(false);
        $this->collapsible(false);
        $this->sortable(false);
        $this->is_downloadable(false);
        $this->define_baseurl($PAGE->url);
        $this->context = context_course::instance($courseid);
        $this->set_sql( 'id, name, completed, priority, timecreated, timemodified', '{tool_dmarag}', 'courseid = ?', [$courseid]);
    }
	
	// Display name
    protected function col_name($row)
    {
        $courseid = optional_param('id', 0, PARAM_INT);
        $name = html_writer::link(new moodle_url('/admin/tool/dmarag/edit.php', ['id' => $courseid, 'tool_dmarag' => $row->id]), $row->name);
        return $name;
    }
	
	// Display completed
	 protected function col_completed($row) {
        return $row->completed ? get_string('yes') : get_string('no');
    }
	
    // Display  priority
    protected function col_priority($row) {
        return $row->priority ? get_string('yes') : get_string('no');
    }
	
    // Display timecreated
    protected function col_timecreated($row) {
        return userdate($row->timecreated, '');
    }
	
    // Display timemodified
    protected function col_timemodified($row) {
        return userdate($row->timemodified, get_string('strftimedatetime'));
    }
}