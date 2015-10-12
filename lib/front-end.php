<?php


// retrieves the attachment ID from the file URL
function acfav_get_image_id( $image_url ) {

    global $wpdb;

    $video_id = 0;

    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
    if ( $attachment != NULL )
         $video_id = $attachment[0];

    return $video_id;
}

add_filter( 'wp_video_shortcode', 'acfav_wp_video_shortcode', 10, 5 );
function acfav_wp_video_shortcode( $html, $atts, $video, $post_id, $library ) {

    if ( is_admin() ) {
        return;
    }


    $formats = wp_get_video_extensions();
    $subtitle = "";

    // get the attachment ID ($video_id), would be nice if attachment ID was in atts...
    if ( $atts[ "src" ] ) {

        $video_id = acfav_get_image_id( $atts[ "src" ] );

    } else {

        foreach ( $atts as $key => $attr ) {

            if ( in_array( $key, $formats ) ) {

                if ( ( $atts[ $key ] != "" ) ) {
                    $video_id = acfav_get_image_id( $atts[ $key ] );
                }
            }

        }

    }

    if ( $video_id ) {

        // get subtitles
        if ( have_rows('acfav_subtitles', $video_id ) ):

            while ( have_rows('acfav_subtitles', $video_id ) ) : the_row();

                $language_obj =  get_sub_field_object( 'acfav_srt_language' );
                $language_code = $language_obj['value'];
                $language_name = $language_obj['choices'][$language_code];

                $srt_obj = get_sub_field( 'acfav_srt_file');

                $subtitle .= '<track srclang="' . $language_code . '" label="' . $language_name . '" kind="subtitles" src="' . $srt_obj['url'] . '"></track>';

            endwhile;

        endif;

        // add tracks to the shortcode
        $replace_value = array(
            '</video>'
        );

        $replace_with  = array(
            $subtitle .  '</video>'
        );

        $html = str_ireplace( $replace_value, $replace_with, $html );


        // if alt videos or audio or caption
        $alt_files = acfav_list_item( $video_id, "Video" );

        if ( have_rows('acfav_alt_videos', $video_id) ) {

          $alts = true;

          while ( have_rows( 'acfav_alt_videos', $video_id ) ) : the_row();

            $alt_video = get_sub_field( 'acfav_alt_video' );
            $alt_files .= acfav_list_item( $alt_video['ID'], __( 'Video', ACFAV_DOMAIN ) );

          endwhile;

        }

        if ( have_rows('acfav_alt_audios', $video_id) ) {

          $alts = true;

          while ( have_rows( 'acfav_alt_audios', $video_id ) ) : the_row();

            $alt_audio = get_sub_field( 'acfav_alt_audio' );
            $alt_files .= acfav_list_item( $alt_audio['ID'], __( 'Audio', ACFAV_DOMAIN ) );

          endwhile;

        }


        if ( have_rows('acfav_subtitles', $video_id ) ) {

          while ( have_rows( 'acfav_subtitles', $video_id ) ) : the_row();

            $alt_srt = get_sub_field('acfav_srt_file' );
            $alt_files .= acfav_list_item( $alt_srt['ID'], __( 'Caption', ACFAV_DOMAIN ) );

          endwhile;

        }

        // if description
        $file_data = wp_prepare_attachment_for_js( $video_id );
        if (  $file_data['description'] != "" ) {
          $alt_descr = '<p>'.$file_data['description'].'</p>';
        }

        if ( ! is_admin() && ( $alt_files != "" ||  $alt_descr !="" ) ) {

            $video_name = get_the_title( $video_id);

            $html .= '<div class="acfav-alt-video block">';

            if ( $alt_files != "" ) {
                $html .= '<button class="toggle-link">' . sprintf( __( 'Download %s in other file formats', ACFAV_DOMAIN ), $video_name ) . '</button>';
                $html .= '<ul class="toggle">';
                $html .= $alt_files;
                $html .= '</ul>';
            }

            if ( $alt_descr != "" ) {
                $html .= '<button class="toggle-link">' . sprintf(__( 'Full text of %s ', ACFAV_DOMAIN ), $video_name )  . '</button>';
                $html .= '<div class="toggle">';
                $html .= $alt_descr;
                $html .= '</div>';
            }

        }

        $html .= '</div>';

    }

    return $html;

}

function acfav_list_item( $attachment_id, $kind ) {

    $file_data = wp_prepare_attachment_for_js( $attachment_id );
    $filetype = wp_check_filetype( $file_data['url'] );
    $type = acfav_description_attachment( $filetype['ext'] );

    $length = "";

    if ( $file_data['type']  == 'audio' || $file_data['type']  == 'video' ) {
        $length = $file_data['fileLength'] . ' min. | ';
    }

    $img = "";

    if ( $file_data['icon'] != "" ) {
        $img = '<img src="' . $file_data['icon'] . '" alt="">';
    }

    return '<li><a href="' . $file_data['url'] . '" download="' . $file_data['filename'] . '">' . $type . '
            <span class="meta">' . $kind . ' | ' . $file_data['dateFormatted'] . ' | ' . $length . $img . $filetype['ext'] . ' | ' . $file_data['filesize'] . '</span></a></li>';

}



function acfav_description_attachment( $type ) {

  switch ( $type ) {

  case 'wmv':
    return __( 'Video for Windows Media Player', ACFAV_DOMAIN );
  break;

  case 'mov':
    return __( 'Video for Apple Quicktime Player', ACFAV_DOMAIN );
  break;

  case 'mp4':
    return __( 'Video for Apple Quicktime Player', ACFAV_DOMAIN );
  break;

  case 'mp3':
    return __( 'Audio trac', ACFAV_DOMAIN );
  break;

  case 'wav':
    return __( 'Audio trac', ACFAV_DOMAIN );
  break;

  case 'srt':
    return __( 'Subtitles', ACFAV_DOMAIN );
  break;

  default:
    return ucfirst ( $type ) . __( ' file', ACFAV_DOMAIN );

  }

}