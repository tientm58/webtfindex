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
class TFIndex_Commitment extends Widget_Base {

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
		return 'commitment';
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
		return __( 'TFIndex Commitment', 'elementor-tfindex' );
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
		return 'eicon-parallax';
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
				'label' => __( 'Commitment', 'elementor-tfindex' ),
			]
		);

//		$this->add_control(
//			'testimonials',
//			[
//				'label' => __( 'Commitment style', 'elementor-tfindex' ),
//                'type' => Controls_Manager::NUMBER,
//                'default' => 5,
//			]
//		);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'list_title', [
                'label' => esc_html__( 'Title', 'elementor-tfindex' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'List Title' , 'elementor-tfindex' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'list_content', [
                'label' => esc_html__( 'Content', 'elementor-tfindex' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'List Content' , 'elementor-tfindex' ),
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'list_color',
            [
                'label' => esc_html__( 'Color', 'elementor-tfindex' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
                ],
            ]
        );

		$repeater->add_control(
            'image_commitment', [
                'label' => esc_html__( 'Title', 'elementor-tfindex' ),
            	'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Repeater List', 'elementor-tfindex' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => esc_html__( 'Title #1', 'elementor-tfindex' ),
                        'list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'elementor-tfindex' ),
                    ],
                    [
                        'list_title' => esc_html__( 'Title #2', 'plugin-name' ),
                        'list_content' => esc_html__( 'Item content. Click the edit button to change this text.', 'elementor-tfindex' ),
                    ],
                ],
                'title_field' => '{{{ list_title }}}',
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
        ?>
        <?php if ( $settings['list'] ): ?>
            <?php
            $arr = $settings['list'];
            $listIndex = 1;
            ?>
            <div class="tfindex-widget tfindex-widget-commitment">
                <div class="commitment ast-container">
                    <div class="ast-row">
                        <div class="ast-col-md-5 swiper commitment-swiper-thumb">
                            <div class="swiper-wrapper">
                                <?php foreach ( $arr as $item ): ?>
                                    <div class="item swiper-slide">
                                        <div class="content">
                                            <div class="elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
                                                <?php echo $listIndex++ . ". " . $item['list_title']; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="ast-col-md-7 swiper commitment-swiper-content">
                            <div class="swiper-wrapper">
                                <?php foreach ( $arr as $item ): ?>
                                    <div class="item swiper-slide">
                                        <div class="content">
										<!-- <img src="<?php echo $item['image_commitment']['url']?>" /> -->
                                            <div class=" elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
                                                <?php echo $item['list_content']; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

	<?php }
}
