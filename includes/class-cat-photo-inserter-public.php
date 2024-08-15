<?php
class Cat_Photo_Inserter_Public {
    private $is_updating = false;

    public function insert_cat_photo($post_id, $post, $update) {
        if ($this->is_updating || wp_is_post_revision($post_id) || wp_is_post_autosave($post_id) || get_post_meta($post_id, '_cpi_processed', true)) {
            return;
        }

        $content = $post->post_content;
        $updated_content = $this->fetch_and_insert_cat_photos($content);

        if ($updated_content !== $content) {
            $this->is_updating = true;
            wp_update_post(array(
                'ID' => $post_id,
                'post_content' => $updated_content,
            ));
            $this->is_updating = false;
            update_post_meta($post_id, '_cpi_processed', true);
        }
    }

    public function fetch_and_insert_cat_photos($content) {
        $api_key = get_option('cpi_api_key');
        $max_photos = intval(get_option('cpi_max_photos', 1));
        $insert_position = get_option('cpi_insert_position', 'bottom');

        $breeds_url = 'https://api.thecatapi.com/v1/breeds';
        $response = wp_remote_get($breeds_url, array('headers' => array('x-api-key' => $api_key)));
        
        if (is_wp_error($response)) {
            return $content;
        }

        $breeds = json_decode(wp_remote_retrieve_body($response), true);

        $photos_inserted = 0;
        $new_content = '';

        foreach ($breeds as $breed) {
            if ($photos_inserted >= $max_photos) {
                break;
            }

            if (stripos($content, $breed['name']) !== false) {
                $image_url = $this->fetch_cat_image($breed['id'], $api_key);
                if ($image_url) {
                    $new_content .= $this->create_responsive_image_tag($image_url, $breed['name']);
                    $photos_inserted++;
                }
            }
        }

        if ($insert_position === 'top') {
            return $new_content . $content;
        } else {
            return $content . $new_content;
        }
    }

    private function fetch_cat_image($breed_id, $api_key) {
        $api_url = "https://api.thecatapi.com/v1/images/search?limit=1&breed_ids={$breed_id}";
        $response = wp_remote_get($api_url, array('headers' => array('x-api-key' => $api_key)));

        if (is_wp_error($response)) {
            return false;
        }

        $images = json_decode(wp_remote_retrieve_body($response), true);

        if (empty($images)) {
            return false;
        }

        return $images[0]['url'] ?? false;
    }

    private function create_responsive_image_tag($image_url, $breed_name) {
        $image_tag = '<img src="' . esc_url($image_url) . '" ' .
                     'alt="' . esc_attr($breed_name) . '" ' .
                     'style="max-width: 100%; height: auto; display: block; margin: 10px auto;">';
        
        return '<div class="cpi-cat-image-container" style="max-width: 100%; margin: 10px 0;">' . $image_tag . '</div>';
    }
}