<?php

// Add ACF Group
add_action( 'wp_loaded',  'acfav_init' );

function acfav_init() {

	add_filter( 'acf/location/rule_values/attachment', 'acfav_acf_location_rules_values_attachment' );
	function acfav_acf_location_rules_values_attachment( $choices ) {

	    $choices[ 'video' ] = 'Video';
	    return $choices;
	}

	add_filter( 'acf/location/rule_match/attachment', 'acfav_acf_location_rules_match_attachment', 10, 3 );
	function acfav_acf_location_rules_match_attachment( $match, $rule, $options ) {

		// vars
	    $attachment = $options['attachment'];

	    // validate
	    if( ! $attachment ) {
	        return false;
	    }

	    // compare
	    if( $rule['operator'] == "==" ) {

	        $match = ( $attachment == $rule['value'] );

	        if ( $rule['value'] == "video" ) {
	            global $post;
	            if ( empty( $post ) ) {
	            	return false;
	            }
	            return ( substr($post->post_mime_type, 0, 5) == 'video' );

	        }

	        // override for "all"
	        if ( $rule['value'] == "all" ) {
	            $match = true;
	        }


	    } elseif ( $rule['operator'] == "!=" ) {

	        $match = ( $attachment != $rule['value'] );

	        // override for "all"
	        if( $rule['value'] == "all" )
	            $match = false;

	    }

	    return $match;
	}


	if ( function_exists('acf_add_local_field_group') ) :

		acf_add_local_field_group(array (
			'key' => 'group_561274370036a',
			'title' => 'Accessible video',
			'fields' => array (
				array (
					'key' => 'field_561274902b283',
					'label' => 'Alternative video formats',
					'name' => 'acfav_alt_videos',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'min' => '',
					'max' => '',
					'layout' => 'table',
					'button_label' => 'Add alternative video format',
					'sub_fields' => array (
						array (
							'key' => 'field_561274aa2b284',
							'label' => 'Alternative video format',
							'name' => 'acfav_alt_video',
							'type' => 'file',
							'instructions' => 'For example .wmv or .mov',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'library' => 'all',
							'min_size' => '',
							'max_size' => '',
							'mime_types' => '',
						),
					),
				),
				array (
					'key' => 'field_561275072b285',
					'label' => 'Alternative audio format',
					'name' => 'acfav_alt_audios',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'min' => '',
					'max' => '',
					'layout' => 'table',
					'button_label' => 'Add audio trac',
					'sub_fields' => array (
						array (
							'key' => 'field_sub561275072b285',
							'label' => 'Alternative video format',
							'name' => 'acfav_alt_audio',
							'type' => 'file',
							'instructions' => 'For example .mp3 or .wav',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'library' => 'all',
							'min_size' => '',
							'max_size' => '',
							'mime_types' => '',
						),
					),
				),
				array (
					'key' => 'field_561275402b286',
					'label' => 'Subtitles',
					'name' => 'acfav_subtitles',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'min' => '',
					'max' => '',
					'layout' => 'table',
					'button_label' => 'Add another subtitle file',
					'sub_fields' => array (
						array (
							'key' => 'field_561275592b287',
							'label' => 'Subtitle file (.srt)',
							'name' => 'acfav_srt_file',
							'type' => 'file',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'library' => 'all',
							'min_size' => '',
							'max_size' => '',
							'mime_types' => '',
						),
						array (
							'key' => 'field_5612758e2b289',
							'label' => 'Language subtitle language',
							'name' => 'acfav_srt_language',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'choices' => array (
								'af' => 'Afrikaans',
								'de' => 'Deutch',
								'en' => 'English',
								'nl' => 'Nederlands',
								'es' => 'Espanol',
							),
							'default_value' => array (
								'en' => 'en',
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
							'disabled' => 0,
							'readonly' => 0,
						),
					),
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'attachment',
						'operator' => '==',
						'value' => 'video',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));

	endif;

}
