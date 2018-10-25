<?php

defined('MOODLE_INTERNAL') || die();

# We defined the web service functions to install.

$functions = array(
    'tool_dmarag_test' => array(
        'classname'   => 'tool_dmarag_external',
        'methodname'  => 'test',
        'classpath'   => 'admin/tool/dmarag/externallib.php',
        'description' => 'Return Hello World FIRSTNAME. Can change the text (Hello World) sending a new text as parameter',
        'type'        => 'read',
    )
);

// We define the services to install as pre-build services. A pre-build service is not editable by administrator.
$services = array(
    'Test service' => array(
        'functions' => array ('tool_dmarag_test'),
        'restrictedusers' => 0,
        'enabled'=>1,
    )
);

/*

# example simple plugin
# This file contains one or two arrays

# The first array declares your web service functions.
# Each of these declarations reference a function in your module (usually an external function).
$functions = array(
    'local_wstemplate_hello_world' => array( # // local_PLUGINNAME_FUNCTIONNAME is the name of the web service function that the client will call.
        'classname'   => 'local_wstemplate_external', #  // local_PLUGINNAME_external: create this class in local/PLUGINNAME/externallib.php
        'methodname'  => 'hello_world', # FUNCTIONNAME implement this function into the above class
        'classpath'   => 'local/wstemplate/externallib.php',
        'description' => 'Return Hello World FIRSTNAME. Can change the text (Hello World) sending a new text as parameter',
        'type'        => 'read', # the value is 'write' if your function does any database change, otherwise it is 'read'.
        'ajax'        => true, # // true/false if you allow this web service function to be callable via ajax
        'capabilities'  => 'moodle/xxx:yyy, addon/xxx:yyy',  # List the capabilities used in the function
                                                                (missing capabilities are displayed for authorised users and also
                                                                 for manually created tokens in the web interface, this is just informative).
    )
);

# The second, optional array declares the pre-built services.
# During the plugin installation/upgrade, Moodle installs these services as pre-build services.
# A pre-build service is not editable by administrator.
$services = array(
    'My service' => array(
        'functions' => array ('local_wstemplate_hello_world'),
        'restrictedusers' => 0,  # if 1, the administrator must manually select which user can use this service.
                                 # (Administration > Plugins > Web services > Manage services > Authorised users)
        'enabled'=>1, # if 0, then token linked to this service won't work
        'shortname'=>'myservice' # the short name used to refer to this service from elsewhere including when fetching a token
    )
);
*/