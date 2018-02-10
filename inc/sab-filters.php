<?php
error_reporting( E_ALL );
ini_set('error_reporting', 1);
// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class for hooking core functionalities.
 */
if ( !class_exists( 'SAB_Filters' ) ) {

	class SAB_Filters {

		protected $sab_options = array();

		public function __construct() {
			$this->sab_options = get_option( 'sab_settings' );
			add_action( 'admin_menu', array( $this, 'sab_add_admin_menu' ) );
			add_action( 'admin_init', array( $this, 'sab_setting_init' ) );
			add_filter( 'the_content', array( $this, 'sab_inject_alert' ) );
		}

		public function sab_inject_alert( $content ) {
			global $post;
			$ptype = get_post_type();

			if ( is_single() && isset( $this->sab_options[ 'sab_cpts_' . $ptype ] ) && isset( $this->sab_options[ 'sab_cpt_' . $ptype ] ) && in_array( $post->ID, $this->sab_options[ 'sab_cpt_' . $ptype ] ) ) {
				$alert_text = '';
				if ( isset( $this->sab_options[ 'sab_alert_text' ] ) && !empty( $this->sab_options[ 'sab_alert_text' ] ) ) {
					$alert_text = $this->sab_options[ 'sab_alert_text' ];
				}
				echo '<script>';
				echo 'alert("' . $alert_text . '")';
				echo '</script>';
			}
			return $content;
		}

		public function sab_add_admin_menu() {
			add_options_page( __( 'Simple Alert Plugin', SAB_TEXT_DOMAIN ), __( 'Simple Alert Plugin', SAB_TEXT_DOMAIN ), 'manage_options', 'simple_alert_plugin', array( $this, 'sab_options_page' ) );
		}

		public function sab_setting_init() {
			register_setting( 'sab_plugin_page', 'sab_settings' );

			add_settings_section( 'sab_plugin_page_section', __( 'This setting section is used for display alert box under selected custom post type posts.', SAB_TEXT_DOMAIN ), array( $this, 'sab_settings_section_callback' ), 'sab_plugin_page' );

			add_settings_field( 'sab_alert_text', __( 'Alert Box Text', SAB_TEXT_DOMAIN ), array( $this, 'sab_alert_text_render' ), 'sab_plugin_page', 'sab_plugin_page_section' );

			add_settings_field( 'sab_cpts', __( 'List Of Custom Post Types', SAB_TEXT_DOMAIN ), array( $this, 'sab_cpts_render' ), 'sab_plugin_page', 'sab_plugin_page_section' );
		}

		public function sab_alert_text_render() {
			?>
			<input type='text' name='sab_settings[sab_alert_text]' value='<?php echo isset( $this->sab_options[ 'sab_alert_text' ] ) ? $this->sab_options[ 'sab_alert_text' ] : ''; ?>'>
			<?php
		}

		public function sab_cpts_render() {
			$args = array(
				'public'	 => true,
				'_builtin'	 => false,
			);

			$output		 = 'names'; // names or objects, note names is the default
			$operator	 = 'and'; // 'and' or 'or'

			$post_types = get_post_types( $args, $output, $operator );
			echo '<div class="sab-post-types">';
			foreach ( $post_types as $post_type ):
				$style = '';
				if ( isset( $this->sab_options[ 'sab_cpts_' . $post_type ] ) ) {
					$style = 'style="display:block;"';
				}
				$post_array	 = get_posts( array(
					'post_type'		 => $post_type,
					'post_status'	 => 'publish',
					'posts_per_page' => -1,
					'orderby'		 => 'post_title',
					'order'			 => 'ASC',
				) );
				$ptype_name	 = str_replace( "_", " ", $post_type );
				$ptype_name	 = ucwords( esc_html( $ptype_name ) );
				?>
				<div class="sab-post-type">
					<div class="checkbox">
						<label><input type="checkbox" data-post_type="<?php echo $post_type; ?>" name="sab_settings[sab_cpts_<?php echo $post_type; ?>]" <?php checked( $this->sab_options[ 'sab_cpts_' . $post_type ], 1 ); ?> value='1' onclick="sab_cpt_toggle( this, this.getAttribute( 'data-post_type' ) )"><b><?php echo sprintf( __( '%s', SAB_TEXT_DOMAIN ), $ptype_name ); ?></b></label>
					</div>
				</div>
				<?php if ( !empty( $post_array ) ): ?>
					<div class="sab-post-type-posts" id="sab-cpt-<?php echo $post_type; ?>" <?php echo $style; ?>>
						<h5><?php echo apply_filters( 'sab_show_alert_head_text', __( 'Allow posts below to show alert box.', SAB_TEXT_DOMAIN ) ); ?></h5>
						<select name="sab_settings[sab_cpt_<?php echo $post_type; ?>][]" multiple>
							<?php
							foreach ( $post_array as $post ):
								$selected = '';
								if ( in_array( $post->ID, $this->sab_options[ 'sab_cpt_' . $post_type ] ) ) {
									$selected = 'selected="selected"';
								}
								echo '<option value="' . $post->ID . '"' . $selected . '>' . $post->post_title . '</option>';
							endforeach;
							?>
						</select>
					</div>
					<?php
				else:
					echo '<div class="sab-post-type-posts" id="sab-cpt-' . $post_type . '"' . $style . '>';
					echo apply_filters( 'sab_no_posts_found_text', __( 'There is no posts to show.', SAB_TEXT_DOMAIN ) );
					echo '<div>';
				endif;
				?>
				<?php
			endforeach;
			echo '</div>';
		}

		public function sab_settings_section_callback() {
			echo __( 'Simple Alert Setting Section', SAB_TEXT_DOMAIN );
		}

		public function sab_options_page() {
			?>
			<form action='options.php' method='post'>
				<h2><?php _e( 'Simple Alert Plugin settings', SAB_TEXT_DOMAIN ); ?></h2>
				<?php
				settings_fields( 'sab_plugin_page' );
				do_settings_sections( 'sab_plugin_page' );
				submit_button();
				?>
			</form>
			<?php
		}

	}

	new SAB_Filters();
}