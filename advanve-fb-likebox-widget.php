<?php
/* Plugin Name: WP FB Advance Likebox Widget
  Plugin URI:
  Description: Advance facebook like box enables you to have a facebook like box over your Wordpress website all or any pages. Equipped with the advance features it is equally easy
  to customize and integrate with your website. Advance facebook like box gives you the direct like button along with the list of users with their images who have
  already liked your facebook page. For the implementation of the like box, the admin could easily select the pages and posts they wish to show it on.
  Author: Praveen Goswami
  Author URI:  http://saurabhspeaks.com
  Version: 1.0
 */
error_reporting(E_ALL);
class facebook_likebox_widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
                'facebook_likebox_widget', // Base ID
                __('Advance FB LikeBox', 'pg_fb_likebox'), // Name
                array('description' => __('Customized Facebook LikeBox Widget for your WordPress Website.', 'pg_fb_likebox'),) // Args
        );
    }
    //output widget content    
    public function widget($args, $instance) {
        //Display widget according to user settings
        $display_widget = false;
        if (is_front_page() && $instance['fb_front_page']) {
            $display_widget = true;
        }
        if (is_page() && $instance['fb_pages']) {
            $display_widget = true;
        }
        if (is_tag() && $instance['fb_tags']) {
            $display_widget = true;
        }
        if (is_category() && $instance['fb_cats']) {
            $display_widget = true;
        }
        if (is_singular('post') && $instance['fb_posts']) {

            $display_widget = true;
        }

        if (!is_singular('post') && $instance['fb_custom_posts']) {

            $display_widget = true;
        }
        if ($display_widget) {
            //output widget
            echo $args['before_widget'];
            if (!empty($instance['title'])) {
                echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title']; //title
            }
            $facebook_page_url = (!empty($instance['fb_page_url'])) ? $instance['fb_page_url'] : ''; //fb page url
            $fb_likebox_color = (!empty($instance['fb_likebox_color'])) ? 'data-colorscheme="' . $instance['fb_likebox_color'] . '"' : 'data-colorscheme="light"'; //fb color scheme
            $fb_show_face = ($instance['fb_show_face']) ? 'data-show-faces="true"' : 'data-show-faces="false"'; //fb show faces
            $fb_show_header = ($instance['fb_show_header']) ? 'data-header="true"' : 'data-header="false"'; //fb show header
            $fb_show_posts = ($instance['fb_show_posts']) ? 'data-stream="true"' : 'data-stream="false"'; //fb show stream posts
            $fb_show_border = ($instance['fb_show_border']) ? 'data-show-border="true"' : 'data-show-border="false"'; //fb show border
            //facebook Likebox code
            echo '<div class="fb-like-box" data-href="' . $facebook_page_url . '" ' . $fb_likebox_color . ' ' . $fb_show_face . ' ' . $fb_show_header . ' ' . $fb_show_posts . ' ' . $fb_show_border . '></div>';
            echo '<div id="fb-root"></div>';
            echo '<script>(function(d, s, id) {';
            echo 'var js, fjs = d.getElementsByTagName(s)[0];';
            echo 'if (d.getElementById(id)) return;';
            echo 'js = d.createElement(s); js.id = id;';
            echo 'js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=365936720119443&version=v2.0";';
            echo 'fjs.parentNode.insertBefore(js, fjs);';
            echo '}(document, \'script\', \'facebook-jssdk\'));</script>';

            echo $args['after_widget'];
        }
    }

    //display options for widget admin 
    public function form($instance) {

        //title of widget
        $title = (isset($instance['title'])) ? $instance['title'] : __('New title', 'text_domain');
        echo '<p>';
        echo '<label for="' . $this->get_field_id('title') . '">' . _e('Title:') . '</label> ';
        echo '<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . esc_attr($title) . '">';
        echo '</p>';

        //Facebook Page URL
        $fb_page_url = (isset($instance['fb_page_url'])) ? $instance['fb_page_url'] : __('https://www.facebook.com/saurabhspeaks', 'text_domain');
        echo '<p>';
        echo '<label for="' . $this->get_field_id('fb_page_url') . '">' . _e('Facebook Page URL:') . '</label> ';
        echo '<input class="widefat" id="' . $this->get_field_id('fb_page_url') . '" name="' . $this->get_field_name('fb_page_url') . '" type="text" value="' . esc_attr($fb_page_url) . '">';
        echo '</p>';

        //Facebook LikeBox Width
        $fb_likebox_width = (isset($instance['fb_likebox_width'])) ? $instance['fb_likebox_width'] : __('300', 'text_domain');
        echo '<p>';
        echo '<label for="' . $this->get_field_id('fb_likebox_width') . '">' . _e('LikeBox Width:') . '</label> ';
        echo '<input class="widefat" id="' . $this->get_field_id('fb_likebox_width') . '" name="' . $this->get_field_name('fb_likebox_width') . '" type="text" value="' . esc_attr($fb_likebox_width) . '">';
        echo '</p>';

        //Facebook LikeBox Height
        $fb_likebox_height = (isset($instance['fb_likebox_height'])) ? $instance['fb_likebox_height'] : __('300', 'text_domain');
        echo '<p>';
        echo '<label for="' . $this->get_field_id('fb_likebox_height') . '">' . _e('LikeBox Height:') . '</label> ';
        echo '<input class="widefat" id="' . $this->get_field_id('fb_likebox_height') . '" name="' . $this->get_field_name('fb_likebox_height') . '" type="text" value="' . esc_attr($fb_likebox_height) . '">';
        echo '</p>';

        //Facebook LikeBox Color Scheme
        $fb_likebox_color = (isset($instance['fb_likebox_color'])) ? $instance['fb_likebox_color'] : '';
        echo '<p>';
        echo '<label for="' . $this->get_field_id('fb_likebox_color') . '">' . _e('LikeBox Color Scheme:') . '</label> ';
        echo '<select style="width: 100%;" id="' . $this->get_field_id('fb_likebox_color') . '" name="' . $this->get_field_name('fb_likebox_color') . '">';
        echo '<option value="light">Light</option>';
        if (esc_attr($fb_likebox_color) == "dark") {
            echo '<option value="dark" selected>Dark</option>';
        } else {
            echo '<option value="dark">Dark</option>';
        }

        echo '</select>';
        echo '</p>';

        //Facebook Customization options
        echo '<p>';
        $fb_show_face = ($instance['fb_show_face']) ? 'checked' : '';
        $fb_show_header = ($instance['fb_show_header']) ? 'checked' : '';
        $fb_show_posts = ($instance['fb_show_posts']) ? 'checked' : '';
        $fb_show_border = ($instance['fb_show_border']) ? 'checked' : '';

        echo '<label>' . _e('Facebook Look:') . '</label> ';
        echo '<ul>';
        echo '<li><input id="' . $this->get_field_name('fb_show_face') . '" class="widefat" name="' . $this->get_field_name('fb_show_face') . '" type="checkbox" value="1" ' . $fb_show_face . '><label for="' . $this->get_field_name('fb_show_face') . '">Show Friends\' Faces</label></li>';
        echo '<li><input id="' . $this->get_field_name('fb_show_header') . '" class="widefat" name="' . $this->get_field_name('fb_show_header') . '" type="checkbox" value="1" ' . $fb_show_header . '><label for="' . $this->get_field_name('fb_show_header') . '">Show Header</label></li>';
        echo '<li><input id="' . $this->get_field_name('fb_show_posts') . '" class="widefat" name="' . $this->get_field_name('fb_show_posts') . '" type="checkbox" value="1" ' . $fb_show_posts . '><label for="' . $this->get_field_name('fb_show_posts') . '">Show Posts</label></li>';
        echo '<li><input id="' . $this->get_field_name('fb_show_border') . '" class="widefat" name="' . $this->get_field_name('fb_show_border') . '" type="checkbox" value="1" ' . $fb_show_border . '><label for="' . $this->get_field_name('fb_show_border') . '">Show Border</label></li>';
        echo '</ul>';
        echo '</p>';

        //Display Zones options
        echo '<p>';
        $fb_front_page = ($instance['fb_front_page']) ? 'checked' : '';
        $fb_pages = ($instance['fb_pages']) ? 'checked' : '';
        $fb_tags = ($instance['fb_tags']) ? 'checked' : '';
        $fb_cats = ($instance['fb_cats']) ? 'checked' : '';
        $fb_posts = ($instance['fb_posts']) ? 'checked' : '';
        $fb_custom_posts = ($instance['fb_custom_posts']) ? 'checked' : '';
        echo '<label>' . _e('Display Zones:') . '</label> ';
        echo '<ul>';
        echo '<li><input id="' . $this->get_field_name('fb_front_page') . '" class="widefat" name="' . $this->get_field_name('fb_front_page') . '" type="checkbox" value="1" ' . $fb_front_page . '><label for="' . $this->get_field_name('fb_front_page') . '">Front Page</label></li>';
        echo '<li><input id="' . $this->get_field_name('fb_pages') . '" class="widefat" name="' . $this->get_field_name('fb_pages') . '" type="checkbox" value="1" ' . $fb_pages . '><label for="' . $this->get_field_name('fb_pages') . '">All Pages </label></li>';
        echo '<li><input id="' . $this->get_field_name('fb_tags') . '" class="widefat" name="' . $this->get_field_name('fb_tags') . '" type="checkbox" value="1" ' . $fb_tags . '><label for="' . $this->get_field_name('fb_tags') . '">All Tagged Pages </label></li>';
        echo '<li><input id="' . $this->get_field_name('fb_cats') . '" class="widefat" name="' . $this->get_field_name('fb_cats') . '" type="checkbox" value="1" ' . $fb_cats . '><label for="' . $this->get_field_name('fb_cats') . '">All Category Pages </label></li>';
        echo '<li><input id="' . $this->get_field_name('fb_posts') . '" class="widefat" name="' . $this->get_field_name('fb_posts') . '" type="checkbox" value="1" ' . $fb_posts . '><label for="' . $this->get_field_name('fb_posts') . '">Show On Default Post Type </label></li>';
        echo '<li><input id="' . $this->get_field_name('fb_custom_posts') . '" class="widefat" name="' . $this->get_field_name('fb_custom_posts') . '" type="checkbox" value="1" ' . $fb_custom_posts . '><label for="' . $this->get_field_name('fb_custom_posts') . '">Show On Custom Post Type </label></li>';
        echo '</ul>';
        echo '</p>';
    }

    //processes widget options to be saved 
    public function update($new_instance, $old_instance) {
        $instance = array();
        //We simply add values to $instance array for saving.
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['fb_page_url'] = (!empty($new_instance['fb_page_url']) ) ? strip_tags($new_instance['fb_page_url']) : '';
        $instance['fb_likebox_width'] = (!empty($new_instance['fb_likebox_width']) ) ? strip_tags($new_instance['fb_likebox_width']) : '';
        $instance['fb_likebox_height'] = (!empty($new_instance['fb_likebox_height']) ) ? strip_tags($new_instance['fb_likebox_height']) : '';
        $instance['fb_likebox_color'] = (!empty($new_instance['fb_likebox_color']) ) ? strip_tags($new_instance['fb_likebox_color']) : '';
        $instance['fb_show_face'] = (!empty($new_instance['fb_show_face']) ) ? strip_tags($new_instance['fb_show_face']) : '';
        $instance['fb_show_header'] = (!empty($new_instance['fb_show_header']) ) ? strip_tags($new_instance['fb_show_header']) : '';
        $instance['fb_show_posts'] = (!empty($new_instance['fb_show_posts']) ) ? strip_tags($new_instance['fb_show_posts']) : '';
        $instance['fb_show_border'] = (!empty($new_instance['fb_show_border']) ) ? strip_tags($new_instance['fb_show_border']) : '';
        $instance['fb_front_page'] = (!empty($new_instance['fb_front_page']) ) ? strip_tags($new_instance['fb_front_page']) : '';
        $instance['fb_pages'] = (!empty($new_instance['fb_pages']) ) ? strip_tags($new_instance['fb_pages']) : '';
        $instance['fb_tags'] = (!empty($new_instance['fb_tags']) ) ? strip_tags($new_instance['fb_tags']) : '';
        $instance['fb_cats'] = (!empty($new_instance['fb_cats']) ) ? strip_tags($new_instance['fb_cats']) : '';
        $instance['fb_posts'] = (!empty($new_instance['fb_posts']) ) ? strip_tags($new_instance['fb_posts']) : '';
        $instance['fb_custom_posts'] = (!empty($new_instance['fb_custom_posts']) ) ? strip_tags($new_instance['fb_custom_posts']) : '';
        return $instance;
    }

}

//register widget using the widgets_init
add_action('widgets_init', 'reg_facebook_likebox_widget');

function reg_facebook_likebox_widget() {
    register_widget('facebook_likebox_widget');
}
