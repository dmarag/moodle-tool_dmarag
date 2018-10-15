<?php

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir.'/formslib.php');

class tool_dmarag_form extends moodleform
{
    # Form definition. 
    protected function definition()
    {
        global $CFG, $DB;

        $courseid = optional_param('id', 0, PARAM_INT);
        $tool_dmarag_id = optional_param('tool_dmarag', 0, PARAM_INT);
        $delete = optional_param('delete', 0, PARAM_INT);


        $course = $DB->get_record("course", array("id"=>$courseid));
        $course_shortname = "";
        if(!empty($course)) {
            $course_shortname = $course->shortname;
        }

        $tool_dmarag = $DB->get_record("tool_dmarag", array("id"=>$tool_dmarag_id));
        $tool_dmarag_name = "";
        $tool_dmarag_completed = 0;
        if(!empty($tool_dmarag)) {
            $tool_dmarag_name = $tool_dmarag->name;
            $tool_dmarag_completed = $tool_dmarag->completed;
        }

        $mform = $this->_form;

        # course shortname
        $mform->addElement('static', 'course_shortname', get_string('course_shortname', 'tool_dmarag'), $course_shortname, '');

        if($delete != 1)
        {
            # add / edit form ##############################################

            # tool_dmarag name
            $mform->addElement('text', 'name', get_string('name', 'tool_dmarag'), array('size' => '30'));
            $mform->setDefault('name', $tool_dmarag_name);
            $mform->setType('name', PARAM_RAW);

            # tool_dmarag completed
            $mform->addElement('advcheckbox', 'completed', get_string('completed', 'tool_dmarag'), '', array('group' => 1), array(0, 1));
            $mform->setDefault('completed', $tool_dmarag_completed);

            # hidden id: tool_dmarag table
            $mform->addElement('hidden', 'tool_dmarag_id', $tool_dmarag_id);
            $mform->setType('tool_dmarag_id', PARAM_INT);

            # hidden id: courseid
            $mform->addElement('hidden', 'id', $courseid);
            $mform->setType('id', PARAM_INT);

            $this->add_action_buttons(true);
        }
        else
        {
            # delete form  ##############################################

            $mform->addElement('static', 'name', get_string('name', 'tool_dmarag'));
            $mform->setDefault('name', $tool_dmarag_name);

            $tool_dmarag_completed_text = "";
            $mform->addElement('static', 'completed', get_string('completed', 'tool_dmarag'));
            if($tool_dmarag_completed == 1) {
                # completed
                $tool_dmarag_completed_text = get_string('completed', 'tool_dmarag');
            }

            $mform->setDefault('completed', $tool_dmarag_completed_text);

            # hidden id: tool_dmarag table
            $mform->addElement('hidden', 'tool_dmarag_id', $tool_dmarag_id);
            $mform->setType('tool_dmarag_id', PARAM_INT);

            # hidden id: courseid
            $mform->addElement('hidden', 'id', $courseid);
            $mform->setType('id', PARAM_INT);

            $this->add_action_buttons(true, get_string('delete_this_record', 'tool_dmarag'));

        }
    }

    public function validation($data, $files) 
	{
        global $DB;
        $errors = parent::validation($data, $files);
        // Check that name is unique for the course.
        if ($DB->record_exists_select('tool_dmarag',
            'name = :name AND id <> :id AND courseid = :courseid',
            ['name' => $data['name'], 'id' => $data['id'], 'courseid' => $data['courseid']])) {
            $errors['name'] = get_string('errornameexists', 'tool_dmarag');
        }
        return $errors;
    }
}

