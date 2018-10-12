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