<?php
class Cat_Photo_Inserter_Admin {
    public function add_menu_page() {
        add_menu_page(
            __('Cat Photo Inserter Settings', 'cat-photo-inserter'),
            __('Cat Photo Inserter', 'cat-photo-inserter'),
            'manage_options',
            'cpi-settings',
            array($this, 'display_options_page'),
            'dashicons-camera',
            100
        );
    }

    public function register_settings() {
        register_setting('cpi_options_group', 'cpi_api_key');
        register_setting('cpi_options_group', 'cpi_max_photos', array($this, 'validate_max_photos'));
        register_setting('cpi_options_group', 'cpi_insert_position');
    }

    public function validate_max_photos($input) {
        return max(1, min(10, intval($input)));
    }

    public function display_options_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields('cpi_options_group'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('API Key', 'cat-photo-inserter'); ?></th>
                        <td><input type="text" name="cpi_api_key" value="<?php echo esc_attr(get_option('cpi_api_key')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Maximum Number of Photos', 'cat-photo-inserter'); ?></th>
                        <td>
                            <select name="cpi_max_photos">
                                <?php for ($i = 1; $i <= 10; $i++) : ?>
                                    <option value="<?php echo $i; ?>" <?php selected(get_option('cpi_max_photos', 1), $i); ?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Insert Position', 'cat-photo-inserter'); ?></th>
                        <td>
                            <select name="cpi_insert_position">
                                <option value="top" <?php selected(get_option('cpi_insert_position'), 'top'); ?>><?php _e('Top of content', 'cat-photo-inserter'); ?></option>
                                <option value="bottom" <?php selected(get_option('cpi_insert_position'), 'bottom'); ?>><?php _e('Bottom of content', 'cat-photo-inserter'); ?></option>
                            </select>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}