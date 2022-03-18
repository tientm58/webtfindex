<?php

namespace ElementorTFIndex\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor TFIndex
 *
 * Elementor widget for tfindex.
 *
 * @since 1.0.0
 */
class TFIndex_Staff extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'staff';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'TFIndex Staff', 'elementor-tfindex' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-person';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'elementor-tfindex' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Staff', 'elementor-tfindex' ),
			]
		);

		$this->add_control(
			'staff',
			[
				'label' => __( 'Staff style', 'elementor-tfindex' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

        $numberOfStaff = $settings['staff'];

        $arr = [];

        $args = array(
            'post_type' => 'staff',
            'post_status' => 'publish',
            'posts_per_page' => $numberOfStaff,
            'orderby' => 'date',
            'order' => 'ASC',
        );
        $loop = get_posts($args);

        foreach ( $loop as $post ) : setup_postdata( $post );
            $arr[] = array(
                'id'       => $post->ID,
                'post_content'   => $post->post_content,
                'full_name'    => $post->post_title,
                'identity_or_position'    => get_field('identity_or_position', $post->ID),
            );
        endforeach;

        wp_reset_postdata();

        ?>

        <div class="tfindex-widget tfindex-widget-staff">
            <div class="staff ast-container">
                <div class="ast-row">
                    <div class="poup-template">
                        <!-- The Modal -->
                        <div id="staff-popup-template" class="modal">
                            <!-- Modal content -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <span class="close">&times;</span>
                                </div>
                                <div class="modal-body">
<!--                                    <div class="avatar"></div>-->
<!--                                    <div class="name"></div>-->
<!--                                    <div class="position"></div>-->
<!--                                    <div class="text"></div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper staff-swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ( $arr as $el ): ?>
                                <div class="item swiper-slide item-<?php echo $el['id'];?>">
                                    <div class="content">
                                        <div class="avatar"><?php echo get_the_post_thumbnail ($el['id']); ?></div>
                                        <div class="name"><?php echo $el['full_name']; ?></div>
                                        <div class="position"><?php echo $el['identity_or_position']; ?></div>
                                        <div class="text" style=""><?php echo $el['post_content']; ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php }
}
