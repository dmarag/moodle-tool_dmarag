<?php

require_once($CFG->libdir . "/externallib.php");

require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/lib.php');
require_once($CFG->dirroot. '/admin/tool/dmarag/classes/tool_dmarag.php');


class tool_dmarag_external extends external_api
{

    # Returns description of method parameters
    # @return external_function_parameters
    public static function test_parameters()
    {
        //$arr_param = array('welcomemessage' => new external_value(PARAM_TEXT, 'The welcome message. By default it is "Hello world,"', VALUE_DEFAULT, 'Hello world, '));
        $arr_param = array('courseid' => new external_value(PARAM_INT, 'Course id', VALUE_REQUIRED));

        $external_params = new external_function_parameters($arr_param);
        return $external_params;
    }


    # List of entries in the course
    # @return array
    public static function test($courseid)  //$welcomemessage = 'Hello world, '
    {
        global $PAGE;

        //Parameter validation
        //REQUIRED
       //$params = self::validate_parameters(self::test_parameters(), array('courseid' => $courseid));

        //Context validation
        //OPTIONAL but in most web service it should present
        $context = context_course::instance($courseid);
        self::validate_context($context);
        require_capability('tool/dmarag:view', $context);

        //Capability checking
        //OPTIONAL but in most web service it should present
        if (!has_capability('moodle/user:viewdetails', $context)) {
            throw new moodle_exception('cannotviewprofile');
        }

        return get_tool_dmarag_table_data_for_ws($courseid);

    }

    # Returns description of method result value
    # @return external_description
    public static function test_returns()
    {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'id' => new external_value(PARAM_INT, 'Tool dmarag id'),
                    'name' => new external_value(PARAM_RAW, 'Completed'),
                    'description' => new external_value(PARAM_RAW, 'Description'),
                    'completed' => new external_value(PARAM_NOTAGS, 'Completed'),
                    'priority' => new external_value(PARAM_NOTAGS, 'Priority'),
                    'timecreated' => new external_value(PARAM_NOTAGS, 'Time Created'),
                    'timemodified' => new external_value(PARAM_NOTAGS, 'Time Modify')
                )
            )
        );
    }

}


/*
class tool_dmarag_external extends external_api {

    # Returns description of method parameters
    # @return external_function_parameters
    public static function test_parameters() {
        return new external_function_parameters(
            array('welcomemessage' => new external_value(PARAM_TEXT, 'The welcome message. By default it is "Hello world,"', VALUE_DEFAULT, 'Hello world, '))
        );
    }

    # Returns welcome message
    # @return string welcome message
    public static function test($welcomemessage = 'Hello world, ') {
        global $USER;

        //Parameter validation
        //REQUIRED
        $params = self::validate_parameters(self::test_parameters(), array('welcomemessage' => $welcomemessage));

        //Context validation
        //OPTIONAL but in most web service it should present
        $context = get_context_instance(CONTEXT_USER, $USER->id);
        self::validate_context($context);

        //Capability checking
        //OPTIONAL but in most web service it should present
        if (!has_capability('moodle/user:viewdetails', $context)) {
            throw new moodle_exception('cannotviewprofile');
        }

        return $params['welcomemessage'] . $USER->firstname ;
    }

    # Returns description of method result value
    # @return external_description
    public static function test_returns() {
        return new external_value(PARAM_TEXT, 'The welcome message + user first name');
    }
}

*/
