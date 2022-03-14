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
class TFIndex_Chart extends Widget_Base {

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
		return 'chart';
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
		return __( 'TFIndex Chart', 'elementor-tfindex' );
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
		return 'eicon-product-upsell';
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
				'label' => __( 'Chart', 'elementor-tfindex' ),
			]
		);

		$this->add_control(
			'chart',
			[
				'label' => __( 'Chart number', 'elementor-tfindex' ),
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

        $numberOfChart = $settings['chart'];

        $arr = [];

        $args = array(
            'post_type' => 'chart',
            'post_status' => 'publish',
            'posts_per_page' => $numberOfChart,
            'orderby' => 'date',
            'order' => 'ASC',
        );
        $loop = get_posts($args);

        foreach ( $loop as $post ) : setup_postdata( $post );
            $arr[] = array(
                'id'       => $post->ID,
                'post_title'    => $post->post_title,
                'post_content'   => $post ->post_content,
                'stocks'    => get_field('stocks', $post->ID),
            );
        endforeach;

        wp_reset_postdata();

        ?>

        <div class="tfindex-widget tfindex-widget-chart">
            <div class="chart">
                <div class="row">
                    <div class="swiper chart-swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ( $arr as $el ): ?>
                                <div class="item swiper-slide">
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="title">
                                                    <h3 class="tfindex-text"><?php echo $el['post_title']; ?></h3>
                                                </div>
                                                <div class="description">
                                                    <?php echo $el['post_content']; ?>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="chart chart-image"><?php echo get_the_post_thumbnail ($el['id']); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="swiper chart-swiper-thumb">
                    <div class="swiper-wrapper">
                        <?php foreach ( $arr as $el ): ?>
                            <div class="item swiper-slide">
                                <div class="content">
                                    <div class="stock stock-name"><?php echo $el['stocks']; ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
	<?php }
}