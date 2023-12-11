<?php
/**
 * Theme functions and definitions.
 */
function charityhomenew_child_enqueue_styles() {

    if ( SCRIPT_DEBUG ) {
        wp_enqueue_style( 'charityhomenew-style' , get_template_directory_uri() . '/style.css' );
    } else {
        wp_enqueue_style( 'charityhomenew-minified-style' , get_template_directory_uri() . '/style.css' );
    }

    wp_enqueue_style( 'charityhomenew-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'charityhomenew-style' ),
        wp_get_theme()->get('Version')
    );
}

add_action(  'wp_enqueue_scripts', 'charityhomenew_child_enqueue_styles' );

function my_upload_mimes( $mimes ) {
        return array_merge($mimes, array (
            'xls' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'csv' => 'text/csv'
        ));
}
add_filter( 'upload_mimes', 'my_upload_mimes' );

function remove_version_info() {
return '';
}
add_filter('the_generator', 'remove_version_info');

function addTooltip($my_text){
	preg_match_all('#\b[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $my_text, $match);
	foreach($match[0] as $file) {
		$originalFile = $file;
		$file = str_replace('http://', 'https://', $file);
        if(!str_contains($file, 'https://')){
            $file = 'https://www.ia.gov.sk'.$file;
        }
		if (str_contains(pathinfo($file)['extension'], '?')) {
			$fileExtension = substr(pathinfo($file)['extension'], 0, strpos(pathinfo($file)['extension'], "?"));
		} else {
			$fileExtension = pathinfo($file)['extension'];
		}

				if(!in_array($fileExtension, ['sk', 'cz', 'eu', 'com', 'us', 'html', null])) {
				    $uploads = wp_upload_dir();

				    // Generate full file path and set extension to $type.
				    // substr($data, strpos($data, "_") + 1);
				    $customFileName = substr($file, strpos($file, '/wp-content/uploads/') + 19);
				    if (str_contains($customFileName, '?')) {
				    	$filename = $uploads['basedir'] . substr($customFileName, 0, strpos($customFileName, "?"));
				    } else {
				    	$filename = $uploads['basedir'] . $customFileName;
				    }

				    if ( file_exists( $filename ) ) {
				        $finalExtension = strtoupper($fileExtension);
						$size = filesize($filename);
						$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
						$power = $size > 0 ? floor(log($size, 1024)) : 0;
						$finalSize = number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
						
						$my_text = str_replace('href="' . $originalFile . '"', 'href="' . $originalFile .'" data-toggle="tooltip" data-placement="right" data-title="' . $finalExtension . '; ' . $finalSize . '" title="' . $finalExtension . '"', $my_text);
				    }
				}
			}

  return $my_text;
}

add_filter('the_content', 'addTooltip');

/**
 * Register meta boxes.
 */
function hcf_register_meta_boxes() {
    add_meta_box( 'hcf-1', __( 'Contact Form 7', 'hcf' ), 'hcf_display_callback', 'page' );
}
add_action( 'add_meta_boxes', 'hcf_register_meta_boxes' );

function hcf_display_callback( $post ) {
    echo '<div class="hcf_box">
    <style scoped>
        .hcf_box{
            display: grid;
            grid-template-columns: max-content 1fr;
            grid-row-gap: 10px;
            grid-column-gap: 20px;
        }
        .hcf_field{
            display: contents;
        }
    </style>
    <p class="meta-options hcf_field">
        <label for="hcf_author">Form Action</label>
        <input id="custom_contact_form_action_field"
            type="text"
            name="custom_contact_form_action_field"
            value="' . esc_attr( get_post_meta( get_the_ID(), 'custom_contact_form_action_field', true ) ) . '">
    </p>
</div>';
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function hcf_save_meta_box( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    $fields = [
        'custom_contact_form_action_field',
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $post_id, $field, sanitize_text_field( $_POST[$field] ) );
        }
     }
}
add_action( 'save_post', 'hcf_save_meta_box' );

add_filter('wpcf7_form_action_url', 'wpcf7_custom_form_action_url');
function wpcf7_custom_form_action_url($url)
{
    global $post;
    
	$customAction = get_post_meta( get_the_ID(), 'custom_contact_form_action_field', true );
    if(!empty($customAction)){
        return $customAction;
    }
    else{
        return $url;
    }
}
