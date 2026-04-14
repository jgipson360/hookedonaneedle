<?php
/**
 * Waitlist Handler Class
 *
 * Handles all waitlist database operations including:
 * - Table creation
 * - Email validation and sanitization
 * - Duplicate checking
 * - CRUD operations
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HOOAN_Waitlist_Handler {
    /**
     * Database table name (with prefix)
     *
     * @var string
     */
    private $table_name;

    /**
     * Constructor - sets up table name
     */
    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'waitlist_emails';
    }

    /**
     * Create the waitlist database table
     *
     * Called on theme activation.
     *
     * @return bool True on success, false on failure
     */
    public function create_table() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255) NOT NULL DEFAULT '',
            email VARCHAR(255) NOT NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY email (email),
            KEY created_at (created_at)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Check if table was created
        $table_exists = $wpdb->get_var(
            $wpdb->prepare(
                "SHOW TABLES LIKE %s",
                $this->table_name
            )
        ) === $this->table_name;

        return $table_exists;
    }

    /**
     * Validate email format
     *
     * @param string $email Email address to validate
     * @return bool True if valid email format
     */
    public function validate_email($email) {
        // Use WordPress built-in email validation
        return is_email($email) !== false;
    }

    /**
     * Sanitize email address
     *
     * @param string $email Email address to sanitize
     * @return string Sanitized email address
     */
    public function sanitize_email($email) {
        return sanitize_email(trim($email));
    }

    /**
     * Check if email already exists in database
     *
     * @param string $email Email address to check
     * @return bool True if email exists
     */
    public function email_exists($email) {
        global $wpdb;

        $email = $this->sanitize_email($email);

        $result = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT COUNT(*) FROM {$this->table_name} WHERE email = %s",
                $email
            )
        );

        return (int) $result > 0;
    }

    /**
     * Add a new email to the waitlist
     *
     * @param string $email Email address to add
     * @param string $name  Subscriber name (optional)
     * @return array Result array with 'success' and 'message' keys
     */
    public function add_email($email, $name = '') {
        global $wpdb;

        // Sanitize inputs
        $email = $this->sanitize_email($email);
        $name  = sanitize_text_field(trim($name));

        // Validate email format
        if (!$this->validate_email($email)) {
            return array(
                'success' => false,
                'message' => __('Please enter a valid email address.', 'hookedonaneedle'),
                'code'    => 'invalid_email'
            );
        }

        // Check for duplicates
        if ($this->email_exists($email)) {
            return array(
                'success' => false,
                'message' => __('This email is already on the waitlist.', 'hookedonaneedle'),
                'code'    => 'duplicate_email'
            );
        }

        // Insert email into database
        $inserted = $wpdb->insert(
            $this->table_name,
            array(
                'name'       => $name,
                'email'      => $email,
                'created_at' => current_time('mysql')
            ),
            array('%s', '%s', '%s')
        );

        if ($inserted === false) {
            return array(
                'success' => false,
                'message' => __('An error occurred. Please try again.', 'hookedonaneedle'),
                'code'    => 'db_error'
            );
        }

        // Fire action hook for successful submission
        do_action('hooan_waitlist_submitted', $email, $wpdb->insert_id, $name);

        return array(
            'success' => true,
            'message' => __("Thank you! You've been added to the waitlist.", 'hookedonaneedle'),
            'code'    => 'success',
            'id'      => $wpdb->insert_id
        );
    }

    /**
     * Get all waitlist emails
     *
     * @param string $order Sort order (ASC or DESC)
     * @param int $limit Number of results (0 for all)
     * @param int $offset Offset for pagination
     * @return array Array of waitlist entries
     */
    public function get_all_emails($order = 'DESC', $limit = 0, $offset = 0) {
        global $wpdb;

        // Validate order
        $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

        $sql = "SELECT * FROM {$this->table_name} ORDER BY created_at {$order}";

        // Add limit and offset if specified
        if ($limit > 0) {
            $sql .= $wpdb->prepare(" LIMIT %d OFFSET %d", $limit, $offset);
        }

        $results = $wpdb->get_results($sql, ARRAY_A);

        return $results ? $results : array();
    }

    /**
     * Get a single waitlist entry by ID
     *
     * @param int $id Entry ID
     * @return array|null Entry data or null if not found
     */
    public function get_email_by_id($id) {
        global $wpdb;

        $result = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_name} WHERE id = %d",
                $id
            ),
            ARRAY_A
        );

        return $result;
    }

    /**
     * Delete a waitlist entry by ID
     *
     * @param int $id Entry ID to delete
     * @return bool True on success, false on failure
     */
    public function delete_email($id) {
        global $wpdb;

        $deleted = $wpdb->delete(
            $this->table_name,
            array('id' => $id),
            array('%d')
        );

        return $deleted !== false;
    }

    /**
     * Get total count of waitlist entries
     *
     * @return int Total count
     */
    public function get_count() {
        global $wpdb;

        $count = $wpdb->get_var(
            "SELECT COUNT(*) FROM {$this->table_name}"
        );

        return (int) $count;
    }

    /**
     * Export all emails to CSV
     *
     * Outputs CSV directly to browser for download.
     */
    public function export_csv() {
        // Get all emails
        $emails = $this->get_all_emails('DESC');

        // Set headers for CSV download
        $filename = 'waitlist-' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Pragma: no-cache');
        header('Expires: 0');

        // Create output stream
        $output = fopen('php://output', 'w');

        // Add UTF-8 BOM for Excel compatibility
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Add header row
        fputcsv($output, array('ID', 'Name', 'Email', 'Date Signed Up'));

        // Add data rows
        foreach ($emails as $entry) {
            fputcsv($output, array(
                $entry['id'],
                isset($entry['name']) ? $entry['name'] : '',
                $entry['email'],
                $entry['created_at']
            ));
        }

        fclose($output);
        exit;
    }

    /**
     * Get table name
     *
     * @return string Table name with prefix
     */
    public function get_table_name() {
        return $this->table_name;
    }
}
