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
class TFIndex_QAs extends Widget_Base {

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
		return 'qas';
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
		return __( 'TFIndex Q&A', 'elementor-tfindex' );
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
		return 'eicon-single-post';
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
				'label' => __( 'Q&A', 'elementor-tfindex' ),
			]
		);

		$this->add_control(
			'qas',
			[
				'label' => __( 'Q&A style', 'elementor-tfindex' ),
//				'type' => Controls_Manager::TEXT,
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                        'style-1' => __( 'Style 1', 'elementor-tfindex' ),
                        'style-2' => __( 'Style 2', 'elementor-tfindex' ),
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

        $args = array(
            'post_type' => 'question_answer',
            'post_status' => 'publish',
            'posts_per_page' => 10,
            'orderby' => 'title',
            'order' => 'ASC',
        );
        $loop = get_posts($args);

        foreach ( $loop as $post ) : setup_postdata( $post );
//            var_dump($post);
            $arr[] = array(
                'id'       	=> $post->ID,
                'question'		=> get_field('question', $post->ID),
                'answer'		=> get_field('answer', $post->ID),
            );
        endforeach;

        wp_reset_postdata();

        ?>

        <div class="tfindex-widget tfindex-widget-qas">
            <div class="qas">
                <?php foreach ( $arr as $el ): ?>
                    <div class="qas-item">
                        <div class="accordion">
                            <div class="question-icon">Q</div>
                            <div class="question">
                                <?php echo $el['question']; ?>
                            </div>
                        </div>
                        <div class="answer panel">
                            <div class="answer-icon">A</div>
                            <div class="answer">
                                <?php echo $el['answer']; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php
	}
}
