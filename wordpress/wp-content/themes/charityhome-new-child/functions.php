<?php
/**
 * Theme functions and definitions.
 */
function charityhomenew_child_enqueue_styles()
{

    if (SCRIPT_DEBUG) {
        wp_enqueue_style('charityhomenew-style', get_template_directory_uri() . '/style.css');
    } else {
        wp_enqueue_style('charityhomenew-minified-style', get_template_directory_uri() . '/style.css');
    }

    wp_enqueue_style(
        'charityhomenew-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('charityhomenew-style'),
        wp_get_theme()->get('Version')
    );
}

add_action('wp_enqueue_scripts', 'charityhomenew_child_enqueue_styles');

function my_upload_mimes($mimes)
{
    return array_merge($mimes, array(
        'xls' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'csv' => 'text/csv'
    ));
}
add_filter('upload_mimes', 'my_upload_mimes');

function remove_version_info()
{
    return '';
}
add_filter('the_generator', 'remove_version_info');

function addTooltip($my_text)
{
    // 1. Získame všetky URL, ktoré sú vnútri atribútu href="...". 
    // Používame array_unique, aby sme rovnaký súbor nespracovávali viackrát.
    preg_match_all('/href="([^"]+)"/', $my_text, $match);

    if (empty($match[1])) {
        return $my_text;
    }

    $uploads = wp_upload_dir();
    $processed_urls = []; // Pomocné pole, aby sme neopakovali logiku pre rovnaké URL

    foreach (array_unique($match[1]) as $originalFile) {

        // Ak sme túto URL už v rámci tohto volania spracovali, preskočíme ju
        if (isset($processed_urls[$originalFile]))
            continue;

        // Ak URL neobsahuje cestu k tvojmu webu (uploads folder), ignorujeme ju (externé linky)
        if (strpos($originalFile, $uploads['baseurl']) === false) {
            continue;
        }

        // Odstránime query string (všetko za otáznikom), aby sme získali čistú cestu k súboru
        $cleanUrl = strtok($originalFile, '?');

        // Rozbijeme cestu na časti (napr. extension)
        $info = pathinfo($cleanUrl);

        // OPRAVA: Overíme, či kľúč 'extension' vôbec existuje (predíde Notice chybe)
        $fileExtension = isset($info['extension']) ? strtolower($info['extension']) : '';

        // Ak URL nemá príponu alebo ide o bežnú webovú stránku/doménu, preskočíme ju
        if (empty($fileExtension) || in_array($fileExtension, ['sk', 'cz', 'eu', 'com', 'us', 'html', 'php'])) {
            continue;
        }

        // Prevedieme URL na fyzickú cestu na serveri (z baseurl na basedir)
        $relative_path = str_replace($uploads['baseurl'], '', $cleanUrl);
        $filename = $uploads['basedir'] . $relative_path;

        // Kontrola, či súbor reálne existuje na disku servera
        if (file_exists($filename)) {
            // Výpočet veľkosti súboru v čitateľnom formáte (KB, MB...)
            $size = filesize($filename);
            $units = ['B', 'KB', 'MB', 'GB'];
            $power = $size > 0 ? floor(log($size, 1024)) : 0;
            $finalSize = number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
            $finalExtension = strtoupper($fileExtension);

            // Pripravíme si nový HTML reťazec s tooltip atribútmi
            $tooltipAttrs = sprintf(
                'href="%s" data-toggle="tooltip" data-placement="right" data-title="%s; %s" title="%s"',
                $originalFile,
                $finalExtension,
                $finalSize,
                $finalExtension
            );

            // Nahradíme pôvodný href v celom texte novým rozšíreným zápisom
            $my_text = str_replace('href="' . $originalFile . '"', $tooltipAttrs, $my_text);

            // Označíme si URL ako spracovanú
            $processed_urls[$originalFile] = true;
        }
    }

    return $my_text;
}

add_filter('the_content', 'addTooltip');

/**
 * Register meta boxes.
 */
function hcf_register_meta_boxes()
{
    add_meta_box('hcf-1', __('Contact Form 7', 'hcf'), 'hcf_display_callback', 'page');
}
add_action('add_meta_boxes', 'hcf_register_meta_boxes');

function hcf_display_callback($post)
{
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
            value="' . esc_attr(get_post_meta(get_the_ID(), 'custom_contact_form_action_field', true)) . '">
    </p>
</div>';
}

/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function hcf_save_meta_box($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if ($parent_id = wp_is_post_revision($post_id)) {
        $post_id = $parent_id;
    }
    $fields = [
        'custom_contact_form_action_field',
    ];
    foreach ($fields as $field) {
        if (array_key_exists($field, $_POST)) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'hcf_save_meta_box');

add_filter('wpcf7_form_action_url', 'wpcf7_custom_form_action_url');
function wpcf7_custom_form_action_url($url)
{
    global $post;

    $customAction = get_post_meta(get_the_ID(), 'custom_contact_form_action_field', true);
    if (!empty($customAction)) {
        return $customAction;
    } else {
        return $url;
    }
}

function allow_editors_to_edit_menus()
{
    $role = get_role('editor');
    if ($role && !$role->has_cap('edit_theme_options')) {
        $role->add_cap('edit_theme_options');
    }
}
add_action('admin_init', 'allow_editors_to_edit_menus');