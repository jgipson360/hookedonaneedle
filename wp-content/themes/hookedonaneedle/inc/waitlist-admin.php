<?php
/**
 * Waitlist Admin Interface
 *
 * Provides admin interface for managing waitlist entries:
 * - View all entries in a table
 * - Delete individual entries
 * - Export to CSV
 * - Display entry count
 *
 * @package HookedOnANeedle
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class HOOAN_Waitlist_Admin {
    /**
     * Waitlist handler instance
     *
     * @var HOOAN_Waitlist_Handler
     */
    private $handler;

    /**
     * Constructor - set up admin hooks
     */
    public function __construct() {
        $this->handler = new HOOAN_Waitlist_Handler();

        // Add admin menu
        add_action('admin_menu', array($this, 'register_menu'));

        // Handle admin actions
        add_action('admin_init', array($this, 'handle_actions'));
    }

    /**
     * Register admin menu item
     */
    public function register_menu() {
        add_options_page(
            __('Waitlist Management', 'hookedonaneedle'),
            __('Waitlist', 'hookedonaneedle'),
            'manage_options',
            'hooan-waitlist',
            array($this, 'render_admin_page')
        );
    }

    /**
     * Handle admin actions (delete, export)
     */
    public function handle_actions() {
        // Only process on our admin page
        if (!isset($_GET['page']) || $_GET['page'] !== 'hooan-waitlist') {
            return;
        }

        // Handle CSV export
        if (isset($_GET['action']) && $_GET['action'] === 'export') {
            $this->handle_export();
        }

        // Handle delete
        if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
            $this->handle_delete();
        }
    }

    /**
     * Handle delete action
     */
    private function handle_delete() {
        // Verify nonce
        if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'delete_waitlist_entry')) {
            wp_die(__('Security check failed.', 'hookedonaneedle'));
        }

        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to do this.', 'hookedonaneedle'));
        }

        $id = absint($_GET['id']);

        if ($id && $this->handler->delete_email($id)) {
            // Redirect back to list with success message
            wp_redirect(add_query_arg(
                array(
                    'page'    => 'hooan-waitlist',
                    'deleted' => '1'
                ),
                admin_url('options-general.php')
            ));
            exit;
        }

        // Redirect back with error
        wp_redirect(add_query_arg(
            array(
                'page'  => 'hooan-waitlist',
                'error' => 'delete_failed'
            ),
            admin_url('options-general.php')
        ));
        exit;
    }

    /**
     * Handle export action
     */
    private function handle_export() {
        // Verify nonce
        if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'export_waitlist')) {
            wp_die(__('Security check failed.', 'hookedonaneedle'));
        }

        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to do this.', 'hookedonaneedle'));
        }

        $this->handler->export_csv();
    }

    /**
     * Render the admin page
     */
    public function render_admin_page() {
        // Get all entries
        $entries = $this->handler->get_all_emails('DESC');
        $total   = $this->handler->get_count();

        // Build export URL
        $export_url = wp_nonce_url(
            add_query_arg(
                array(
                    'page'   => 'hooan-waitlist',
                    'action' => 'export'
                ),
                admin_url('options-general.php')
            ),
            'export_waitlist'
        );
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">
                <?php _e('Waitlist Management', 'hookedonaneedle'); ?>
            </h1>

            <a href="<?php echo esc_url($export_url); ?>" class="page-title-action">
                <?php _e('Export CSV', 'hookedonaneedle'); ?>
            </a>

            <hr class="wp-header-end">

            <?php $this->render_notices(); ?>

            <div class="waitlist-stats" style="background: #fff; padding: 20px; margin: 20px 0; border: 1px solid #ccd0d4; border-radius: 4px;">
                <h2 style="margin-top: 0;">
                    <span class="dashicons dashicons-groups" style="font-size: 24px; margin-right: 8px;"></span>
                    <?php
                    printf(
                        _n(
                            '%s subscriber on the waitlist',
                            '%s subscribers on the waitlist',
                            $total,
                            'hookedonaneedle'
                        ),
                        '<strong>' . number_format_i18n($total) . '</strong>'
                    );
                    ?>
                </h2>
            </div>

            <?php $this->render_list_table($entries); ?>
        </div>
        <?php
    }

    /**
     * Render admin notices
     */
    private function render_notices() {
        // Success notice for deletion
        if (isset($_GET['deleted']) && $_GET['deleted'] === '1') {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php _e('Entry deleted successfully.', 'hookedonaneedle'); ?></p>
            </div>
            <?php
        }

        // Error notice for failed deletion
        if (isset($_GET['error']) && $_GET['error'] === 'delete_failed') {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><?php _e('Failed to delete entry. Please try again.', 'hookedonaneedle'); ?></p>
            </div>
            <?php
        }
    }

    /**
     * Render the entries table
     *
     * @param array $entries Array of waitlist entries
     */
    private function render_list_table($entries) {
        ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th scope="col" class="column-id" style="width: 60px;">
                        <?php _e('ID', 'hookedonaneedle'); ?>
                    </th>
                    <th scope="col" class="column-email">
                        <?php _e('Email', 'hookedonaneedle'); ?>
                    </th>
                    <th scope="col" class="column-date" style="width: 180px;">
                        <?php _e('Date Signed Up', 'hookedonaneedle'); ?>
                    </th>
                    <th scope="col" class="column-actions" style="width: 100px;">
                        <?php _e('Actions', 'hookedonaneedle'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($entries)) : ?>
                    <tr>
                        <td colspan="4">
                            <?php _e('No waitlist entries yet.', 'hookedonaneedle'); ?>
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($entries as $entry) : ?>
                        <tr>
                            <td class="column-id">
                                <?php echo esc_html($entry['id']); ?>
                            </td>
                            <td class="column-email">
                                <a href="mailto:<?php echo esc_attr($entry['email']); ?>">
                                    <?php echo esc_html($entry['email']); ?>
                                </a>
                            </td>
                            <td class="column-date">
                                <?php
                                echo esc_html(
                                    date_i18n(
                                        get_option('date_format') . ' ' . get_option('time_format'),
                                        strtotime($entry['created_at'])
                                    )
                                );
                                ?>
                            </td>
                            <td class="column-actions">
                                <?php
                                $delete_url = wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'page'   => 'hooan-waitlist',
                                            'action' => 'delete',
                                            'id'     => $entry['id']
                                        ),
                                        admin_url('options-general.php')
                                    ),
                                    'delete_waitlist_entry'
                                );
                                ?>
                                <a href="<?php echo esc_url($delete_url); ?>"
                                   class="button button-small"
                                   onclick="return confirm('<?php esc_attr_e('Are you sure you want to delete this entry?', 'hookedonaneedle'); ?>');">
                                    <?php _e('Delete', 'hookedonaneedle'); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col" class="column-id">
                        <?php _e('ID', 'hookedonaneedle'); ?>
                    </th>
                    <th scope="col" class="column-email">
                        <?php _e('Email', 'hookedonaneedle'); ?>
                    </th>
                    <th scope="col" class="column-date">
                        <?php _e('Date Signed Up', 'hookedonaneedle'); ?>
                    </th>
                    <th scope="col" class="column-actions">
                        <?php _e('Actions', 'hookedonaneedle'); ?>
                    </th>
                </tr>
            </tfoot>
        </table>
        <?php
    }
}

// Initialize admin interface
if (is_admin()) {
    new HOOAN_Waitlist_Admin();
}
