<?php
/**
 * Custom Orders — Commission CPT, AJAX handler, uploads, and email notification.
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the hooan_commission custom post type.
 */
function hooan_register_commission_cpt() {
    register_post_type('hooan_commission', array(
        'labels' => array(
            'name'               => __('Commissions', 'hookedonaneedle'),
            'singular_name'      => __('Commission', 'hookedonaneedle'),
            'all_items'          => __('All Commissions', 'hookedonaneedle'),
            'view_item'          => __('View Commission', 'hookedonaneedle'),
            'add_new_item'       => __('Add New Commission', 'hookedonaneedle'),
            'edit_item'          => __('Edit Commission', 'hookedonaneedle'),
            'search_items'       => __('Search Commissions', 'hookedonaneedle'),
            'not_found'          => __('No commissions found.', 'hookedonaneedle'),
            'not_found_in_trash' => __('No commissions found in Trash.', 'hookedonaneedle'),
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-art',
        'supports'     => array('title', 'custom-fields'),
        'capability_type' => 'post',
    ));
}
add_action('init', 'hooan_register_commission_cpt');

/**
 * AJAX handler for commission form submissions.
 */
function hooan_ajax_submit_commission() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'hooan_commission_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed. Please refresh and try again.', 'hookedonaneedle')));
    }

    // Sanitise inputs
    $firstname  = isset($_POST['firstname'])  ? sanitize_text_field(wp_unslash($_POST['firstname']))  : '';
    $lastname   = isset($_POST['lastname'])   ? sanitize_text_field(wp_unslash($_POST['lastname']))   : '';
    $email      = isset($_POST['email'])      ? sanitize_email(wp_unslash($_POST['email']))           : '';
    $category   = isset($_POST['category'])   ? sanitize_text_field(wp_unslash($_POST['category']))   : '';
    $vision     = isset($_POST['vision'])     ? sanitize_textarea_field(wp_unslash($_POST['vision'])) : '';
    $size       = isset($_POST['size'])       ? sanitize_text_field(wp_unslash($_POST['size']))       : '';
    $color_desc = isset($_POST['color_description']) ? sanitize_text_field(wp_unslash($_POST['color_description'])) : '';
    $link       = isset($_POST['inspiration_link'])  ? esc_url_raw(wp_unslash($_POST['inspiration_link']))          : '';
    $gift       = isset($_POST['gift'])       ? sanitize_text_field(wp_unslash($_POST['gift']))       : '';
    $notes      = isset($_POST['notes'])      ? sanitize_textarea_field(wp_unslash($_POST['notes'])) : '';

    $colors    = isset($_POST['colors'])    && is_array($_POST['colors'])    ? array_map('sanitize_text_field', wp_unslash($_POST['colors']))    : array();
    $materials = isset($_POST['materials']) && is_array($_POST['materials']) ? array_map('sanitize_text_field', wp_unslash($_POST['materials'])) : array();

    // Validate required fields
    if (empty($vision)) {
        wp_send_json_error(array('message' => __('Please describe your vision.', 'hookedonaneedle')));
    }
    if (empty($firstname) || empty($lastname)) {
        wp_send_json_error(array('message' => __('Please provide your first and last name.', 'hookedonaneedle')));
    }
    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('Please provide a valid email address.', 'hookedonaneedle')));
    }

    // Create commission post
    $title   = sprintf('%s %s — %s', $firstname, $lastname, $category ? $category : __('Commission', 'hookedonaneedle'));
    $post_id = wp_insert_post(array(
        'post_type'   => 'hooan_commission',
        'post_title'  => sanitize_text_field($title),
        'post_status' => 'publish',
    ));

    if (is_wp_error($post_id)) {
        wp_send_json_error(array('message' => __('Something went wrong. Please try again.', 'hookedonaneedle')));
    }

    // Store post meta
    update_post_meta($post_id, '_co_firstname',         $firstname);
    update_post_meta($post_id, '_co_lastname',          $lastname);
    update_post_meta($post_id, '_co_email',             $email);
    update_post_meta($post_id, '_co_category',          $category);
    update_post_meta($post_id, '_co_vision',            $vision);
    update_post_meta($post_id, '_co_size',              $size);
    update_post_meta($post_id, '_co_colors',            $colors);
    update_post_meta($post_id, '_co_color_description', $color_desc);
    update_post_meta($post_id, '_co_materials',         $materials);
    update_post_meta($post_id, '_co_inspiration_link',  $link);
    update_post_meta($post_id, '_co_gift',              $gift);
    update_post_meta($post_id, '_co_notes',             $notes);

    // Handle file uploads
    $attachment_ids = hooan_handle_commission_uploads($post_id);

    // Send admin notification
    hooan_send_commission_notification($post_id, compact(
        'firstname', 'lastname', 'email', 'category', 'vision',
        'size', 'colors', 'color_desc', 'materials', 'link', 'gift', 'notes'
    ), $attachment_ids);

    wp_send_json_success(array('message' => __('Your request has been submitted!', 'hookedonaneedle')));
}
add_action('wp_ajax_hooan_submit_commission',        'hooan_ajax_submit_commission');
add_action('wp_ajax_nopriv_hooan_submit_commission', 'hooan_ajax_submit_commission');

/**
 * Process inspiration image uploads and attach to commission post.
 *
 * @param int $post_id The commission post ID.
 * @return array Attachment IDs.
 */
function hooan_handle_commission_uploads($post_id) {
    if (empty($_FILES['inspiration_images']) || empty($_FILES['inspiration_images']['name'][0])) {
        return array();
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $allowed_types = array('image/jpeg', 'image/png', 'image/webp');
    $max_size      = 10 * 1024 * 1024; // 10 MB
    $max_files     = 3;
    $attachment_ids = array();

    $files = $_FILES['inspiration_images'];
    $count = min(count($files['name']), $max_files);

    for ($i = 0; $i < $count; $i++) {
        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            continue;
        }
        if ($files['size'][$i] > $max_size) {
            continue;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $files['tmp_name'][$i]);
        finfo_close($finfo);

        if (!in_array($mime, $allowed_types, true)) {
            continue;
        }

        // Restructure for media_handle_upload
        $_FILES['inspiration_image'] = array(
            'name'     => $files['name'][$i],
            'type'     => $files['type'][$i],
            'tmp_name' => $files['tmp_name'][$i],
            'error'    => $files['error'][$i],
            'size'     => $files['size'][$i],
        );

        $attach_id = media_handle_upload('inspiration_image', $post_id);
        if (!is_wp_error($attach_id)) {
            $attachment_ids[] = $attach_id;
        }
    }

    if (!empty($attachment_ids)) {
        update_post_meta($post_id, '_co_attachments', $attachment_ids);
    }

    return $attachment_ids;
}

/**
 * Send admin email notification for a new commission.
 *
 * @param int   $post_id        The commission post ID.
 * @param array $fields         Sanitised field values.
 * @param array $attachment_ids Uploaded attachment IDs.
 */
function hooan_send_commission_notification($post_id, $fields, $attachment_ids = array()) {
    $to      = get_option('admin_email');
    $subject = sprintf('New Commission Request from %s %s', $fields['firstname'], $fields['lastname']);

    $body  = "A new commission request has been submitted.\n\n";
    $body .= sprintf("Name: %s %s\n", $fields['firstname'], $fields['lastname']);
    $body .= sprintf("Email: %s\n", $fields['email']);
    $body .= sprintf("Category: %s\n", $fields['category']);
    $body .= sprintf("Vision: %s\n", $fields['vision']);
    $body .= sprintf("Size: %s\n", $fields['size']);
    $body .= sprintf("Colors: %s\n", implode(', ', $fields['colors']));
    $body .= sprintf("Color Description: %s\n", $fields['color_desc']);
    $body .= sprintf("Materials: %s\n", implode(', ', $fields['materials']));
    $body .= sprintf("Inspiration Link: %s\n", $fields['link']);
    $body .= sprintf("Gift: %s\n", $fields['gift']);
    $body .= sprintf("Notes: %s\n\n", $fields['notes']);
    $body .= sprintf("Edit in admin: %s\n", admin_url("post.php?post={$post_id}&action=edit"));

    $attachments = array();
    foreach ($attachment_ids as $id) {
        $path = get_attached_file($id);
        if ($path) {
            $attachments[] = $path;
        }
    }

    wp_mail($to, $subject, $body, '', $attachments);
}
