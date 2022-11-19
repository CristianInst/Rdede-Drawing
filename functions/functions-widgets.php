<?php

// class Membership_Widget extends WP_Widget {
 
 
//     public function __construct() {
//         parent::__construct(
//             'membership_widget', // Base ID
//             'Membership', // Name
//             array( 'description' => __( 'Membership upsell widget', 'membership_widget' ), ) // Args
//         );
//     }
 
//     public function widget( $args, $instance ) {
//         extract($args);
//         $title = apply_filters('widget_title', $instance['title']);

//         echo $before_widget;
//         if(!empty($title))
//             echo $before_title . $title . $after_title;
//         echo $after_widget;
//     }
 
//     public function form( $instance ) {
//         if ( isset( $instance[ 'title' ] ) ) {
//             $title = $instance[ 'title' ];
//         }
//         else {
//             $title = __( 'New title', 'text_domain' );
//         }
//         ?>
//         <p>
//             <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
//             <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
//          </p>
//     <?php
//     }
 
//     public function update( $new_instance, $old_instance ) {
//         // processes widget options to be saved
//         $instance = array();
//         $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
 
//         return $instance;
//     }
 
// }

// add_action( 'widgets_init', 'theme_widgets' );
 
// function theme_widgets() {
//     register_widget( 'Membership_Widget' );
// }