<?PHP

# Since my template file is called indexpage.mustache,
# I create a new file called indexpage.php in the classes/output directory, and add a class called indexpage that implements \renderable and \templatable.

namespace tool_dmarag\output;
defined('MOODLE_INTERNAL') || die();

class indexpage implements \renderable, \templatable {

    # An array of headings @var array
    protected $headings;

    # An array of rows @var array
    protected $rows;

    # Contruct
    # @param array $headings An array of renderable headings


    # I pass all the necessary data for the template to the constructor, and then process it for output in the export function.
    # The class contains two property variables, $headings and $rows, which will hold the table headings and each row of content for the index page based on what is passed into the constructor.
    # My export_for_template function processes these variables and creates the expected data construct for the template.

    public function __construct(array $titles = [], array $content = []) {
        $this->headings = [];
        $this->rows = [];
        $colnum = 1;
        foreach ($titles as $key => $title) {
            $this->headings['title'.$colnum++] = $title;
        }
        foreach ($content as $key => $row) {
            $this->rows[] = $row;
        }
    }

    # The purpose of this script is to collect the output data for the template and make it available to the renderer.
    # The only real required function is the export_for_template function, as renderers require that function to retrieve the data structure that is passed into the template.
    # Other functions can be provided as necessary including those that process the data for the template. The code for the export function looks like this:

    # Prepare data for use in a template
    # @param \renderer_base $output
    #@return array
    public function export_for_template(\renderer_base $output)
    {
        $data = ['headings' => [], 'rows' => []];

        foreach ($this->headings as $key => $heading) {
            $data['headings'][$key] = $heading;
        }

        foreach ($this->rows as $row)
        {
            list($id, $name, $description, $completed, $priority, $timecreated, $timemodified, $delete) = $row;

            $data['rows'][] = ['id' => $id, 'name' => $name, 'description' => $description, 'completed'=>$completed, 'priority' => $priority, 'timecreated' => $timecreated, 'timemodified' => $timemodified, 'delete'=>$delete];

            //'id, name, completed, description, priority, timecreated, timemodified, delete'
        }

        return $data;
    }
}
