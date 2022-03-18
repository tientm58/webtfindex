<?php
namespace ElementorTFIndex;

use ElementorTFIndex\PageSettings\Page_Settings;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {

//        wp_enqueue_style( 'owl-style-lib', plugins_url( '/assets/js/owl/assets/owl.carousel.min.css', __FILE__ ));
//        wp_enqueue_style( 'owl-style-theme', plugins_url( '/assets/js/owl/assets/owl.theme.default.min.css', __FILE__ ));

        wp_enqueue_style( 'swiper-style', plugins_url( '/assets/js/swiper/swiper-bundle.min.css', __FILE__ ));

        wp_enqueue_style( 'tfindex-style-plugin', plugins_url( '/assets/css/tfindex.css', __FILE__ ));

//        wp_enqueue_script('owl-js-lib', plugins_url( '/assets/js/owl/owl.carousel.min.js', __FILE__ ), [ 'jquery' ], false, true);
        wp_enqueue_script('swiper-js', plugins_url( '/assets/js/swiper/swiper-bundle.min.js', __FILE__ ), [ 'jquery' ], false, true);

        wp_register_script( 'elementor-tfindex', plugins_url( '/assets/js/tfindex.js', __FILE__ ), [ 'jquery' ], false, true );
    }

	/**
	 * Editor scripts
	 *
	 * Enqueue plugin javascript integrations for Elementor editor.
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function editor_scripts() {
		add_filter( 'script_loader_tag', [ $this, 'editor_scripts_as_a_module' ], 10, 2 );

		wp_enqueue_script(
			'elementor-tfindex-editor',
			plugins_url( '/assets/js/editor/editor.js', __FILE__ ),
			[
				'elementor-editor',
			],
			'1.2.1',
			true
		);
	}

	/**
	 * Force load editor script as a module
	 *
	 * @since 1.2.1
	 *
	 * @param string $tag
	 * @param string $handle
	 *
	 * @return string
	 */
	public function editor_scripts_as_a_module( $tag, $handle ) {
		if ( 'elementor-tfindex-editor' === $handle ) {
			$tag = str_replace( '<script', '<script type="module"', $tag );
		}

		return $tag;
	}

    /**
     * Testimonials scripts
     *
     * Enqueue plugin javascript integrations for Elementor editor.
     *
     * @since 1.0.0
     * @access public
     */
    public function testimonials_scripts() {
        add_filter( 'script_loader_tag', [ $this, 'testimonials_scripts_as_a_module' ], 10, 2 );

        wp_enqueue_script(
            'tfindex-testimonials-handle',
            plugins_url( '/assets/js/testimonials/testimonials.js', __FILE__ ),
            false,
            '1.0.0',
            true
        );
    }

    /**
     * Force load editor script as a module
     *
     * @since 1.0.0
     *
     * @param string $tag
     * @param string $handle
     *
     * @return string
     */
    public function testimonials_scripts_as_a_module( $tag, $handle ) {
        if ( 'elementor-tfindex-editor' === $handle ) {
            $tag = str_replace( '<script', '<script type="module"', $tag );
        }
        return $tag;
    }

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once(__DIR__ . '/widgets/tfindex.php');
		require_once(__DIR__ . '/widgets/tftalk.php');
		require_once(__DIR__ . '/widgets/chart.php');
		require_once(__DIR__ . '/widgets/testimonials.php');
		require_once(__DIR__ . '/widgets/staff.php');
		require_once(__DIR__ . '/widgets/commitment.php');
		require_once(__DIR__ . '/widgets/QAs.php');
		require_once(__DIR__ . '/widgets/text.php');
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\TFIndex_TFindex() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\TFIndex_TFTalk() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\TFIndex_Chart() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\TFIndex_Testimonials() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\TFIndex_Staff() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\TFIndex_Commitment() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\TFIndex_QAs() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\TFIndex_Text() );
	}

	/**
	 * Add page settings controls
	 *
	 * Register new settings for a document page settings.
	 *
	 * @since 1.2.1
	 * @access private
	 */
	private function add_page_settings_controls() {
		require_once( __DIR__ . '/page-settings/manager.php' );
		new Page_Settings();
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

		// Register editor scripts
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );

//		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'testimonials_scripts' ] );

		$this->add_page_settings_controls();
	}
}

// Instantiate Plugin Class
Plugin::instance();
