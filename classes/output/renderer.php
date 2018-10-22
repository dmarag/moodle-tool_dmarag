<?PHP

# I will need to create a renderer file.
# To create a renderer, I need to create a file called renderer.php for my plugin, that contains a class that extends the core plugin_renderer_base class. 
# My class will contain functions with names that define the output.
# I wish to render and/or overrides to existing core render output functions. 
# For this example, since I am rendering the index page, I will create a function called render_index.

# The location of the file can be in one of two places in my plugin's file structure. 
# The most common place currently is in the root of the plugin directory. 
# At the time of this writing, most of the core module plugins use the root of their directory to hold this file (mod/lti is the only one that doesn't). 
# The other location is within the subdirectory classes/output/

############################

# Namespaces allow for my classes to be more specifically identified, allowing Moodle's autoloading system to find them much quicker. 
# They also allow me to have class names identical to other class names in Moodle without causing a coding error. 
# This is because the full class name also contains the namespace to identify it.

# Moodle's renderer autoloading system automatically looks in both the classes/output/ space and the plugin root for plugin renderers. 
# But, other class definitions will only be looked for in the classes/ structure.
# To use autoloading and namespaces, I will move my renderer.php file from the plugin root to the classes/output/ directory.
# If I don't use namespaces, then that file must be located in either the plugin root or in classes/
namespace tool_dmarag\output;

defined('MOODLE_INTERNAL') || die();

# Class tool_dmarag_renderer
class renderer extends \plugin_renderer_base
{
	# My class will contain functions with names that define the output.
	# For this example, since I am rendering the index page, I will create a function called render_index.
	
	# Renders the HTML for the index page.
    # @param array $headings Headings for the display columns.
    # @param array $align Alignment for each column.
    # @param array $data All of the table data.
    # @return string
     
    public function render_index($headings, $align, $data)
    {
        $table = new \html_table();
        $table->head = $headings;
        $table->align = $align;
        $table->data = $data;
        return \html_writer::table($table);
    } 
	
}

# Note.
# There is a backslash ("\") in front of the plugin_renderer_base, the html_table and the html_writer statements. 
# This defines the namespace for those constructs as the root (core) namespace. 
# This is necessary, since I have specified that the code in this file is in the tool_dmarag\output namespace. 
# Unless otherwise specified, all definitions will be expected to be in that same namespace. 
# Since those items are contained in other namespaces (namely Moodle core or "\"), I need to specifically identify where they can be found for my code to work.

 