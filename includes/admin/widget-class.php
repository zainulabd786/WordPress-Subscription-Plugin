<?php 
	class sub_subscribe_widget extends WP_Widget{


		public function __construct(){
			$id = "sub_subscribe";
			$title = esc_html__("Subscribe", "sub");

			$options = array(
				"classname" => "sub-subscribe",
				"descritption" => "A simple wordpress widget plugin that lets your readers to subscribe to your blog and recieve blog updates through email."
			);

			parent::__construct($id, $title, $options);
		}

		public function widget( $args, $instance ) {
			$title = "";
			$title = $instance['title'] ;
			 
			// before and after widget arguments are defined by themes
			echo $args['before_widget'];
			if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
			 
			// This is where you run the code and display the output
			?>	<div>
					<div class="number-of-subscribers">Join <b><?php do_action("number_of_subscribers"); ?></b> People who are already subscribed to this blog.</div>
					<form name="subscribe-form" class="form-inline">
						<div class="form-group">
							<input type="text" name="subscribe-inp" class="subscribe-inp form-control" placeholder="Enter Your E-Mail">
							<button type="button" class="subscribe-btn"><?php echo __("Subscribe", "sub"); ?></button>
						</div>
					</form>
					<div class="sub-subscribe-response"></div>
				</div>
				
			<?php
			echo $args['after_widget'];
		}
		

		public function update( $new_instance, $old_instance ) {

			$instance = array();

			if ( isset( $new_instance['title'] ) && ! empty( $new_instance['title'] ) ) {

				$instance['title'] = $new_instance['title'];

			}

			return $instance;

		}

		public function form( $instance ) {

			$id = $this->get_field_id( 'title' );

			$for = $this->get_field_id( 'title' );

			$name = $this->get_field_name( 'title' );

			$label = __( 'Set Widget Title:', 'sub' );

			$title =  __( 'Subscribe.', 'sub' );

			if ( isset( $instance['title'] ) && ! empty( $instance['title'] ) ) {

				$title = $instance['title'];

			}

			?>

			<p>
				<label for="<?php echo esc_attr( $for ); ?>"><?php echo esc_html( $label ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $title ); ?>">
			</p> <?php  
		}
	}
	// register widget
function myplugin_register_widgets() {

	register_widget( 'sub_subscribe_widget' );

}
add_action( 'widgets_init', 'myplugin_register_widgets' ); 
