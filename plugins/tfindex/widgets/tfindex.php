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
class TFIndex_TFindex extends Widget_Base {

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
		return 'tfindex';
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
		return __( 'TFIndex', 'elementor-tfindex' );
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
		return 'eicon-price-list';
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
				'label' => __( 'TFindex', 'elementor-tfindex' ),
			]
		);

		$this->add_control(
			'tfindex',
			[
				'label' => __( 'TFindex number', 'elementor-tfindex' ),
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

        $numberOfPost = $settings['tfindex'];

        $arr = [];

        $args = array(
            'post_type' => 'tfindex',
            'post_status' => 'publish',
            'posts_per_page' => $numberOfPost,
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $loop = get_posts($args);

        foreach ( $loop as $post ) : setup_postdata( $post );
            $arr[] = array(
                'id'       => $post->ID,
                'post_name'    => $post->post_title,
                'sub_header'   => get_field('sub_header', $post->ID),
                'description'   => get_field('description', $post->ID),
                'icon'   => get_field('icon', $post->ID),
            );
        endforeach;

        wp_reset_postdata();

        ?>

        <div class="tfindex-widget tfindex-widget-tfindex">
            <div class="tfindex ast-container">
                <div class="ast-row tfindex-middle">
                    <div class="ast-col-md-2 tfindex-swiper-thumb-block">
                        <div class="slide-arrow slide-arrow-up"></div>
                        <div class="swiper tfindex-swiper tfindex-swiper-thumb">
                            <div class="swiper-wrapper">
                                <?php foreach ( $arr as $el ): ?>
                                    <div class="item swiper-slide">
                                        <div class="content">
                                            <div class="post post-title"><?php echo $el['post_name']; ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="slide-arrow slide-arrow-down"></div>
                    </div>
                    <div class="ast-col-md-10 swiper tfindex-swiper-content">
                        <div class="swiper-wrapper">
                            <?php foreach ( $arr as $el ): ?>
                                <div class="item swiper-slide">
                                    <div class="content">
                                        <div class="ast-row tfindex-row">
                                            <div class="ast-col-md-6">
                                                <div class="avatar"><?php echo get_the_post_thumbnail ($el['id'], 'full'); ?></div>
                                            </div>
                                            <div class="ast-col-md-6 tfindex-content-block">
                                                <div class="tfindex-content">
                                                    <div class="icon"><img src="<?php echo $el['icon']; ?>" alt="<?php echo $el['post_name']; ?>"></div>
                                                    <div class="sub-header"><?php echo $el['sub_header']; ?></div>
                                                    <div class="description"><?php echo $el['description']; ?></div>
                                                    <div class="view-more"><button class="btn btn-primary"><a class="btn-link" href="">Xem chi tiết</a></button></div>
                                                </div>
                                             </div>
                                        </div>
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
