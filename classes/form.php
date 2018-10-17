<?php

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir.'/formslib.php');

class tool_dmarag_form extends moodleform
{
    # Form definition. 
    protected function definition()
    {
        global $CFG, $COURSE, $DB;

        $delete = optional_param('delete', 0, PARAM_INT);

        $course_shortname = "";
        $tool_dmarag_name = "";
        $tool_dmarag_description_text = "";

        $mform = $this->_form;

        $currententry      = $this->_customdata['current'];
        $descriptionoptions = $this->_customdata['descriptionoptions'];

        $tool_dmarag_id = $this->_customdata['current']->id;
        $courseid = $this->_customdata['current']->courseid;

        if(!empty($courseid) && $courseid > 0)
        {
            $course = $DB->get_record("course", array("id" => $courseid));
            $course_shortname = $course->shortname;
        }

        if(!empty($tool_dmarag_id) && $tool_dmarag_id > 0)
        {
            $tool_dmarag = $DB->get_record("tool_dmarag", array("id" => $tool_dmarag_id));
            $tool_dmarag_name = $tool_dmarag->name;
            $tool_dmarag_completed = $tool_dmarag->completed;

            $tool_dmarag_description_text = $tool_dmarag->description;
        }


        # course shortname
        $mform->addElement('static', 'course_shortname', get_string('course_shortname', 'tool_dmarag'), $course_shortname, '');

        # hidden id: tool_dmarag table id
        $mform->addElement('hidden', 'id', $courseid);
        $mform->setType('id', PARAM_INT);

        # hidden courseid: courseid
        $mform->addElement('hidden', 'courseid', $courseid);
        $mform->setType('courseid', PARAM_INT);

        # hidden id: tool_dmarag table id
        $mform->addElement('hidden', 'tool_dmarag_id', $tool_dmarag_id);
        $mform->setType('tool_dmarag_id', PARAM_INT);

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

            # text editor
            //$mform->addElement('editor', 'description_editor', get_string('description', 'tool_dmarag'), null, $descriptionoptions);
            //$mform->setType('description_editor', PARAM_RAW);
            $mform->addElement
            (
                'editor',
                'description_editor',
                get_string('description', 'tool_dmarag'),
                null,
                array('context' => $context)
            )->setValue( array('text' => $tool_dmarag_description_text) );

            $mform->setType('description_editor', PARAM_RAW);


            $this->add_action_buttons(true);
            //$this->set_data($currententry);
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
                    else{
                        $tool_dmarag_completed_text = "-";
                    }

                    $mform->setDefault('completed', $tool_dmarag_completed_text);

                    $this->add_action_buttons(true, get_string('delete_this_record', 'tool_dmarag'));

                }
    }

    public function validation($data, $files) 
	{
        global $DB;
        $errors = parent::validation($data, $files);
        // Check that name is unique for the course.
       /* if ($DB->record_exists_select('tool_dmarag',
            'name = :name AND id <> :id AND courseid = :courseid',
            ['name' => $data['name'], 'id' => $data['id'], 'courseid' => $data['courseid']])) {
            $errors['name'] = get_string('errornameexists', 'tool_dmarag');
        }*/
        return $errors;
    }

}

