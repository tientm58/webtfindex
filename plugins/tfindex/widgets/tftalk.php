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
class TFIndex_TFTalk extends Widget_Base {

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
		return 'tftalk';
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
		return __( 'TFIndex TFTalk', 'elementor-tfindex' );
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
		return 'eicon-posts-ticker';
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
				'label' => __( 'TFTalk', 'elementor-tfindex' ),
			]
		);

		$this->add_control(
			'tfindex',
			[
				'label' => __( 'TFTalk style', 'elementor-tftalk' ),
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

        $numberOfPost = $settings['tftalk'];

        $arr = [];

        $args = array(
            'post_type' => 'tftalk',
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
                'content'    => $post->post_content,
                'author'   => get_field('author', $post->ID),
                'avatar'   => get_field('avatar', $post->ID),
                'time'   => get_field('time', $post->ID),
                'type'   => get_field('type', $post->ID),
                'fee'   => get_field('fee', $post->ID),
                'students'   => get_field('students', $post->ID),
            );
        endforeach;

        wp_reset_postdata();

        ?>

        <div class="tfindex-widget tftalk-widget tftalk-widget-tftalk">
            <div class="tftalk">
                <div class="row">
                    <div class="tfindex-swiper-control">
                        <div class="slide-arrow slide-arrow-left" tabindex="0" role="button" aria-label="Previous slide"></div>
                        <div class="slide-arrow slide-arrow-right" tabindex="0" role="button" aria-label="Next slide"></div>
                    </div>
                    <div class="swiper tftalk-swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ( $arr as $el ): ?>
                                <div class="item swiper-slide">
                                    <div class="content">
                                        <div class="avatar">
                                            <?php
                                            $explode = explode('/', $el['time']);
                                            $upcoming = $explode[2] . '-' . $explode[1] . '-' . $explode[0];
                                            $upcoming = date("Y-m-d", strtotime($upcoming));
                                            $today = date("Y-m-d");
                                            if ($upcoming >= $today) {
                                                echo '<div class="upcoming-event">UPCOMING</div>';
                                            }
                                            ?>
                                            <?php echo get_the_post_thumbnail ($el['id']); ?>
                                        </div>
                                        <div class="content-block ast-container">
                                            <div class="category-title"><span>WORKSHOP</span></div>
                                            <div class="title"><?php echo $el['post_name']; ?></div>
                                            <div class="author border-bottom">
                                                <div class="ast-row">
                                                    <div class="ast-col-xs-3">
                                                        <div class="author-avatar"><img src="<?php echo $el['avatar']; ?>" alt="<?php echo $el['author']; ?>"></div>
                                                    </div>
                                                    <div class="ast-col-xs-9">
                                                        <div class="author-text">Diễn giả</div>
                                                        <div class="author"><?php echo $el['author']; ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="course-info">
                                                <div class="ast-row">
                                                    <div class="ast-col-xs-6">
                                                        <div class="time-text">Thời gian</div>
                                                        <div class="time"><?php echo $el['time']; ?></div>
                                                    </div>
                                                    <div class="ast-col-xs-6">
                                                        <div class="type-text">Hình thức</div>
                                                        <div class="type"><?php echo $el['type']; ?></div>
                                                    </div>
                                                    <div class="ast-col-xs-6">
                                                        <div class="fee-text">Học phí</div>
                                                        <div class="fee"><?php echo number_format( $el['fee'], absint( 0 ), null, '.' ) ?> vnđ</div>
                                                    </div>
                                                    <div class="ast-col-xs-6">
                                                        <div class="fee-text">Số lượng học viên</div>
                                                        <div class="fee"><?php echo $el['students']; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <div class="description-title">Nội dung</div>
                                                <div class="description-content">
                                                    <?php echo $el['content']; ?>
                                                </div>
                                            </div>
                                            <div class="view-more tfindex-register" data-event="<?php echo $el['post_name']; ?>">
                                                <div class="btn btn-primary">
                                                    <a class="btn-link" href="#" onclick='return false;'>Đăng ký</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>


                <!-- The Modal -->
                <div id="tfindex-form-popup" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="close">&times;</span>
                        </div>
                        <div class="modal-body">
                            <div class="tfindex-form-events">
                                <h3 class="title-center">Đăng ký tham gia sự kiện</h3>
                                <form id="tfindex-form-events" class="needs-validation">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="tfindex-event">Sự kiện</label>
                                            <input type="text" class="form-control" id="tfindex-event" placeholder="Sự kiện" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="tfindex-register-name">Họ và Tên</label>
                                            <input type="text" class="form-control" id="tfindex-register-name" placeholder="Họ và Tên" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="tfindex-register-email">Email</label>
                                            <input type="email" class="form-control" id="tfindex-register-email" placeholder="Email" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="tfindex-register-phone">Số điện thoại</label>
                                            <input type="text" class="form-control" id="tfindex-register-phone" placeholder="Số điện thoại" required minlength="10" maxlength="11">
                                        </div>
                                    </div>
                                    <button class="btn btn-primary tfindex-register-this" type="submit">Đăng ký</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php }
}
