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
class TFIndex_Testimonials extends Widget_Base {

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
		return 'testimonials';
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
		return __( 'TFIndex Testimonials', 'elementor-tfindex' );
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
		return 'eicon-editor-quote';
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
				'label' => __( 'Testimonials', 'elementor-tfindex' ),
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label' => __( 'Testimonials style', 'elementor-tfindex' ),
//				'type' => Controls_Manager::TEXT,
                'type' => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                        'carousel' => __( 'Carousel', 'elementor-tfindex' ),
                        'grid' => __( 'Grid', 'elementor-tfindex' ),
                ],
//                'selectors' => [
//                    '{{WRAPPER}} .title' => 'text-transform: {{VALUE}};',
//                ],
			]
		);

		$this->end_controls_section();

//		$this->start_controls_section(
//			'section_style',
//			[
//				'label' => __( 'Style', 'elementor-tfindex' ),
//				'tab' => Controls_Manager::TAB_STYLE,
//			]
//		);
//
//		$this->add_control(
//			'text_transform',
//			[
//				'label' => __( 'Text Transform', 'elementor-tfindex' ),
//				'type' => Controls_Manager::SELECT,
//				'default' => '',
//				'options' => ['' => __( 'None', 'elementor-tfindex' )],
//				'selectors' => [
//					'{{WRAPPER}} .title' => 'text-transform: {{VALUE}};',
//				],
//			]
//		);
//
//		$this->end_controls_section();
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

        $arr = [];

//        if ($settings['testimonials'] == 'carousel') {
//
//        }
        $args = array(
            'post_type' => 'testimonials',
            'post_status' => 'publish',
            'posts_per_page' => 10,
            'orderby' => 'title',
            'order' => 'ASC',
        );
        $loop = get_posts($args);

        foreach ( $loop as $post ) : setup_postdata( $post );
            $arr[] = array(
                'id'       => $post->ID,
                'post_content'   => $post ->post_content,
                'full_name'    => get_field('full_name', $post->ID),
                'identity_or_position'    => get_field('identity_or_position', $post->ID),
            );
        endforeach;

        wp_reset_postdata();

        ?>

        <?php if ($settings['testimonials'] == 'carousel') { ?>
            <div class="tfindex-widget testimonials-style-1 tfindex-widget-testimonials">
                <div class="owl-custom-nav">
                    <div class="owl-prev">
                        <span class="previous" aria-label="Previous"></span>
                    </div>
                    <div class="owl-next">
                        <span class="next" aria-label="Next"></span>
                    </div>
                </div>
                <div class="testimonials owl-carousel owl-theme">
                    <?php foreach ( $arr as $el ): ?>
                        <div class="item">
                            <div class="content">
                                <div class="client-say">
                                    <?php echo $el['post_content']; ?>
                                </div>
                                <div class="client"><?php echo $el['full_name']; ?> - <?php echo $el['identity_or_position']; ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="tfindex-widget testimonials-style-2 tfindex-widget-testimonials">
                <div class="testimonials row">
                    <?php foreach ( $arr as $el ): ?>
                        <div class="item col-md-3">
                            <div class="content">
                                <div class="client-say">
                                    <?php echo $el['post_content']; ?>
                                </div>
                                <div class="client"><?php echo $el['full_name']; ?> - <?php echo $el['identity_or_position']; ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php }
	}
}
