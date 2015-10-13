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
					'label' => __( 'Alternative video files', ACFAV_DOMAIN ),
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
					'button_label' => __( 'Add another video file', ACFAV_DOMAIN ),
					'sub_fields' => array (
						array (
							'key' => 'field_561274aa2b284',
							'label' => __( 'Alternative video file', ACFAV_DOMAIN ),
							'name' => 'acfav_alt_video',
							'type' => 'file',
							'instructions' => __( 'For example .wmv or .mov. <br />Note: if the files are to big to upload here, please upload them via FTP and assign them to the media using a plugin like Media from FTP', ACFAV_DOMAIN ),
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
					'label' => __( 'Alternative audio files', ACFAV_DOMAIN ),
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
					'button_label' => __( 'Add another audio file', ACFAV_DOMAIN ),
					'sub_fields' => array (
						array (
							'key' => 'field_sub561275072b285',
							'label' => __( 'Alternative audio file', ACFAV_DOMAIN ),
							'name' => 'acfav_alt_audio',
							'type' => 'file',
							'instructions' => __( 'For example .mp3 or .wav', ACFAV_DOMAIN ),
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
					'label' => __( 'Subtitles', ACFAV_DOMAIN ),
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
					'button_label' => __( 'Add another subtitle file', ACFAV_DOMAIN ),
					'sub_fields' => array (
						array (
							'key' => 'field_561275592b287',
							'label' => 'Subtitle file',
							'name' => 'acfav_srt_file',
							'type' => 'file',
							'instructions' => __( 'Use a .srt or .vvt file', ACFAV_DOMAIN ),
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
							'mime_types' => 'srt, vvt',
						),
						array (
							'key' => 'field_5612758e2b289',
							'label' => __( 'Language subtitles', ACFAV_DOMAIN ),
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
								'ar' => 'العربية',
								'az' => 'Azərbaycan dili',
								'bg' => 'Български',
								'bs' => 'Bosanski',
								'ca' => 'Català',
								'cy' => 'Cymraeg',
								'da' => 'Dansk',
								'de' => 'Deutsch',
								'el' => 'Ελληνικά',
								'en' => 'English',
								'eo' => 'Esperanto',
								'es' => 'Español',
								'et' => 'Eesti',
								'eu' => 'Euskara',
								'fa' => 'فارسی',
								'fi' => 'Suomi',
								'fr' => 'Français',
								'gd' => 'Gàidhlig',
								'gl' => 'Galego',
								'haz' => 'هزاره گی',
								'he' => 'עִבְרִית',
								'hr' => 'Hrvatski',
								'hu' => 'Magyar',
								'id' => 'Bahasa Indonesia',
								'is' => 'Íslenska',
								'it' => 'Italiano',
								'ja' => '日本語',
								'ko' => '한국어',
								'lt' => 'Lietuvių kalba',
								'my' => 'ဗမာစာ',
								'nb' => 'Norsk bokmål',
								'nl' => 'Nederlands',
								'nn' => 'Norsk nynorsk',
								'oc' => 'Occitan',
								'pl' => 'Polski',
								'ps' => 'پښتو',
								'pt' => 'Português',
								'ro' => 'Română',
								'ru' => 'Русский',
								'sk' => 'Slovenčina',
								'sl' => 'Slovenščina',
								'sq' => 'Shqip',
								'sr' => 'Српски језик',
								'sv' => 'Svenska',
								'th' => 'ไทย',
								'tl' => 'Tagalog',
								'tr' => 'Türkçe',
								'ug' => 'Uyƣurqə',
								'uk' => 'Українська',
								'zh' => '繁體中文',
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
