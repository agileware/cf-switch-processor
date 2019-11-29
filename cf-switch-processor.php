<?php
/* Copyright (C) Agileware
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * Plugin Name: Caldera Forms Switch Processor
 * Description: A Caldera Forms Processor to generate magic tag values based on input conditions
 * Version: 1.0.0
 * Author: Agileware
 * Author URI: https://agileware.com.au
 * Plugin URI: https://github.com/agileware/cf-switch
 * GitHub Plugin URI: agileware/cf-switch
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cf-switch
 */

namespace CF_Switch;

function register ( $processors ) {
	$processors['case'] = [
		'name' => __( 'Switch: Case', 'cf-switch-processor' ),
		'description' => __( 'Generate a value based on input conditions.', 'cf-switch-processor' ),
		'author' => 'Agileware',
		'template' => \plugin_dir_path( __FILE__ ) . '/config-case.php',
		'processor' => 'CF_Switch\sw_case',
	];

	$processors['switch'] = [
		'name' => __( 'Switch: Results', 'cf-switch-processor' ),
		'description' => __( 'Collect the values from previous Case processors and output as magic tags.', 'cf-switch-processor' ),
		'author' => 'Agileware',
		'template' => \plugin_dir_path( __FILE__ ) . '/config-switch.php',
		'processor' => 'CF_Switch\sw_switch',
		'magic_tags' => [
			'*'
		],
	];

	return $processors;
}

function &results() {
	static $results = [];

	return $results;
}

function sw_case ( $config, $form ) {
	$results =& results();

	$data = new \Caldera_Forms_Processor_Get_Data( $config, $form, case_fields() );

	$id = $data->get_value('sw_id');
	
	$results[$id] = $data->get_value('output');
}

function sw_switch ( $config, $form ) {
	$data = new \Caldera_Forms_Processor_Get_Data( $config, $form, switch_fields() );

	return results();
}

function case_fields () {
	return [
		[	'id'		=> 'sw_id',
			'type'		=> 'text',
			'required'	=> true,
			'magic'		=> false,
			'label'		=> __( 'Switch Label', 'cf-switch-processor' ),
			'desc'		=> __('Provide a label for the switch this case applies to. This determines the magic tag.  For example, if you enter ‘value’ here, the resulting tag will be ‘{switch:value}’', 'cf-switch-processor' ),
		],
		[	'id'		=> 'output',
			'type'		=> 'text',
			'required'	=> true,
			'magic'		=> true,
			'label'		=> __( 'Output', 'cf-switch-processor' ),
			'desc'		=> __( 'The value to output in the magic tag.', 'cf-switch-processor' ),
		]
	];
}

\add_filter( 'caldera_forms_get_form_processors', 'CF_Switch\register' );
