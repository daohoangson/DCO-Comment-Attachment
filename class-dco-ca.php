<?php
/**
 * Public functions: DCO_CA class
 *
 * @package DCO_Comment_Attachment
 * @author Denis Yanchevskiy
 * @copyright 2019
 * @license GPLv2+
 *
 * @since 1.0
 */

defined( 'ABSPATH' ) || die;

/**
 * Class with public functions.
 *
 * @since 1.0
 */
class DCO_CA {

	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init_hooks' ) );
	}

	/**
	 * Initializes hooks.
	 *
	 * @since 1.0
	 */
	public function init_hooks() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'comment_form_submit_field', array( $this, 'add_attachment_field' ) );
	}

	/**
	 * Enqueues scripts and styles.
	 *
	 * @since 1.0
	 */
	public function enqueue_scripts() {
		// Only when comments is used.
		if ( is_singular() && comments_open() ) {
			wp_enqueue_script( 'dco-comment-attachment', DCO_CA_URL . 'dco-comment-attachment.js', array( 'jquery' ), DCO_CA_VERSION, true );
		}
	}

	/**
	 * Adds file upload field to form.
	 *
	 * @since 1.0
	 * @param string $submit_field HTML markup for the submit field.
	 * @return string $submit_field_with_file_field HTML markup for the file field and submit field.
	 */
	public function add_attachment_field( $submit_field ) {
		ob_start();
		?>
		<p class="comment-form-attachment">
			<label for="attachment"><?php esc_html_e( 'Attachment', 'dco-comment-attachment' ); ?></label>
			<input id="attachment" name="attachment" type="file" />
		</p>
		<?php
		$file_field = ob_get_clean();

		return $file_field . $submit_field;
	}

}

$GLOBALS['dco_ca'] = new DCO_CA();