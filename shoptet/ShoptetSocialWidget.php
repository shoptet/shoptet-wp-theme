<?php
 
class ShoptetSocialWidget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  public function __construct() {
    parent::__construct( 'shoptet_social_widget', 'Shoptet Social Widget' );
  }

  private function get_widget_fields() {
    return [
      [
        'label' => __('Facebook', 'shoptet'),
        'id' => 'facebook',
        'default' => true,
        'type' => 'checkbox',
      ],
      [
        'label' => __('Twitter', 'shoptet'),
        'id' => 'twitter',
        'default' => true,
        'type' => 'checkbox',
      ],
    ];
  }
 
  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
    extract( $args );
    $title = apply_filters( 'widget_title', $instance['title'] );
    $facebook = ( isset($instance['facebook']) && true === $instance['facebook']);
    $twitter = ( isset($instance['facebook']) && true === $instance['twitter']);

    echo $before_widget;
    if ( ! empty( $title ) ) {
        echo $before_title . $title . $after_title;
    }

    $current_url = get_permalink(get_the_ID());
    $encoded_url = urlencode($current_url);
    ?>
    <ul class="social-share">
      <?php if ($facebook): ?>
        <li>
          <a class="social-share-link social-share-link-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $encoded_url; ?>" title="<?php _e( 'Share on Facebook', 'shoptet' ); ?>" target="_blank">
            <i class="fab fa-facebook-f"></i>
          </a>
        </li>
      <?php endif; ?>
      <?php if ($twitter): ?>
        <li>
          <a class="social-share-link social-share-link-twitter" href="https://twitter.com/intent/tweet?text=<?php echo $encoded_url; ?>" title="<?php _e( 'Tweet on Twitter', 'shoptet' ); ?>" target="_blank">
            <i class="fab fa-twitter"></i>
          </a>
        </li>
      <?php endif; ?>
    </ul>
    <?php
    echo $after_widget;
  }

  public function field_generator( $instance ) {
		$output = '';
		foreach ( $this->get_widget_fields() as $widget_field ) {
			$default = '';
			if ( isset($widget_field['default']) ) {
				$default = $widget_field['default'];
			}
      $widget_value = ! empty( $instance[$widget_field['id']] ) ? $instance[$widget_field['id']] : esc_html( $default );
			switch ( $widget_field['type'] ) {
        case 'checkbox':
          $widget_value = boolval( isset( $instance[$widget_field['id']] ) ? $instance[$widget_field['id']] : $default );
					$output .= '<p>';
					$output .= '<input class="checkbox" type="checkbox" '.checked( $widget_value, true, false ).' id="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" name="'.esc_attr( $this->get_field_name( $widget_field['id'] ) ).'" value="1">';
					$output .= '<label for="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'">'.esc_attr( $widget_field['label'] ).'</label>';
					$output .= '</p>';
					break;
				default:
					$output .= '<p>';
					$output .= '<label for="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'">'.esc_attr( $widget_field['label'] ).':</label> ';
					$output .= '<input class="widefat" id="'.esc_attr( $this->get_field_id( $widget_field['id'] ) ).'" name="'.esc_attr( $this->get_field_name( $widget_field['id'] ) ).'" type="'.$widget_field['type'].'" value="'.esc_attr( $widget_value ).'">';
					$output .= '</p>';
			}
		}
		echo $output;
	}
 
  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = '';
    }
    ?>
    <p>
      <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
    $this->field_generator( $instance );
  }
 
  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {
    $instance = [];
    $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    foreach ( $this->get_widget_fields() as $widget_field ) {
      switch ( $widget_field['type'] ) {
        case 'checkbox':
          $instance[$widget_field['id']] = ( ! empty( $new_instance[$widget_field['id']] ) && '1' == $new_instance[$widget_field['id']] );
          break;
				default:
					$instance[$widget_field['id']] = ( ! empty( $new_instance[$widget_field['id']] ) ) ? strip_tags( $new_instance[$widget_field['id']] ) : '';
			}
		}
    return $instance;
  }
 
}
 
?>