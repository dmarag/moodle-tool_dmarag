
<?php

defined('MOODLE_INTERNAL') || die();

function xmldb_tool_dmarag_upgrade($oldversion) {
    global $DB;

	$dbman = $DB->get_manager();
    
	// Put any upgrade step following this.
	if ($oldversion < 2018101105) {

               // Define table tool_dmarag to be created.
        $table = new xmldb_table('tool_dmarag');

        // Adding fields to table tool_dmarag.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('completed', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('priority', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table tool_dmarag.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for tool_dmarag.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Dmarag savepoint reached.
        upgrade_plugin_savepoint(true, 2018101105, 'tool', 'dmarag');
    }
	
	if ($oldversion < 2018101105)
    {
        $table = new xmldb_table('tool_dmarag');

        // Define key courseid (foreign) to be added to tool_dmarag.
        $key = new xmldb_key('courseid', XMLDB_KEY_FOREIGN, array('courseid'), 'course', array('id'));
        // Launch add key courseid.
        $dbman->add_key($table, $key);

        // Define index index (unique) to be added to tool_dmarag.
        $index = new xmldb_index('index', XMLDB_INDEX_UNIQUE, array('courseid', 'name'));

        // Conditionally launch add index index.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Dmarag savepoint reached.
        upgrade_plugin_savepoint(true, 2018101105, 'tool', 'dmarag');
    }

    if ($oldversion < 2018101500)
    {
        $table = new xmldb_table('tool_dmarag');

        // add new field description
        $field = new xmldb_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null, 'timemodified');

        // Conditionally launch add field description.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // add new field descriptionformat
        $field2 = new xmldb_field('descriptionformat', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'description');

        // Conditionally launch add field descriptionformat.
        if (!$dbman->field_exists($table, $field2)) {
            $dbman->add_field($table, $field2);
        }


        // Dmarag savepoint reached.
        upgrade_plugin_savepoint(true, 2018101500, 'tool', 'dmarag');
    }



    return true;
}