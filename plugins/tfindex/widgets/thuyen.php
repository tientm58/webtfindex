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
class TFIndex_Thuyen extends Widget_Base {

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
		return 'thuyen';
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
		return __( 'TFIndex Thuyen', 'elementor-tfindex' );
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
		return 'eicon-external-link-square';
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
				'label' => __( 'Thuyen', 'elementor-tfindex' ),
			]
		);

        $this->add_control(
            'text',
            [
                'label' => __( 'Text', 'elementor-tfindex' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Default description', 'elementor-tfindex' ),
                'placeholder' => esc_html__( 'Type your description here', 'elementor-tfindex' ),
            ]
        );

		$this->add_control(
			'thuyen',
			[
				'label' => __( 'Thuyen style', 'elementor-thuyen' ),
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

        $text = $settings['text'];
        $numberOfPost = $settings['thuyen'];

        $arr = [];

        $args = array(
            'post_type' => 'thuyen',
            'post_status' => 'publish',
            'posts_per_page' => $numberOfPost,
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $loop = get_posts($args);

        foreach ( $loop as $post ) : setup_postdata( $post );
            $arr[] = array(
                'id'            => $post->ID,
                'post_name'     => $post->post_title,
                'start'         => get_field('start_date', $post->ID),
                'end'           => get_field('end_date', $post->ID),
                'company'       => get_field('company', $post->ID),
                'profit'        => get_field('current_profit', $post->ID),
                'update'        => $post->post_modified,
            );
        endforeach;

        wp_reset_postdata();

        function interest_rate($money, $year, $percent, $newMoney = 0) {
            // (((36*105% + 36) * 105%) + 36)*105%
            if ($year == 0) return 0;
            $newMoney = (($money * 12 + $newMoney) * (100 + $percent)) / 100;
            if ($year == 1) return $newMoney;
            return interest_rate($money, $year - 1, $percent, $newMoney);
        }

//        echo interest_rate(3, 3, 5);

        function flatten_arr(array $array) {
            $return = array();
            array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
            return $return;
        }

        $years = get_field('years', 'option');
        $percents = get_field('percents', 'option');
        $money = get_field('money', 'option');
        $industry = get_field('industry', 'option');

        ?>

        <div class="tfindex-widget thuyen-widget thuyen-widget-thuyen">
            <!-- Tab links -->
            <div class="tab">
                <button class="tablinks active" onclick="return false;" data-value="first-tab">Thuyền TFSTOCK</button>
                <button class="tablinks" onclick="return false;"  data-value="second-tab">Chiến lược đầu tư</button>
            </div>

            <div class="first-tab">
                <div class="thuyen-text">
                    <?php echo $text; ?>
                </div>
                <div class="thuyen">
                    <div class="row">
                        <div class="tfindex-swiper-control">
                            <div class="slide-arrow slide-arrow-left" tabindex="0" role="button" aria-label="Previous slide"></div>
                            <div class="slide-arrow slide-arrow-right" tabindex="0" role="button" aria-label="Next slide"></div>
                        </div>
                        <div class="swiper thuyen-swiper">
                            <div class="swiper-wrapper">
                                <?php foreach ( $arr as $el ): ?>
                                    <div class="item swiper-slide">
                                        <div class="content">
                                            <div class="content-block">
                                                <div class="content-info">
                                                    <div class="content-row">
                                                        <div class="title"><?php echo $el['post_name']; ?></div>
                                                        <div class="element-thuyen">
                                                            <div class="text">Ngày khởi hành</div>
                                                            <div class="type"><?php echo $el['start']; ?></div>
                                                        </div>
                                                        <div class="element-thuyen">
                                                            <div class="text">Ngày kết thúc</div>
                                                            <div class="type"><?php echo $el['end']; ?></div>
                                                        </div>
                                                        <div class="element-thuyen">
                                                            <div class="text">Doanh nghiệp</div>
                                                            <div class="type"><img src="<?php echo $el['company']; ?>" alt=""></div>
                                                        </div>
                                                        <div class="element-thuyen">
                                                            <div class="text">Lợi nhuận hiện tại</div>
                                                            <div class="type"><?php echo $el['profit']; ?>%</div>
                                                        </div>
                                                        <div class="text small">Cập nhật đến <?php echo str_replace('/', '-', explode(" ", $el['update'])[0]) ?></div>
                                                    </div>
                                                </div>
                                                <div class="view-more tfindex-register" data-event="<?php echo $el['post_name']; ?>">
                                                    <a class="btn-link" href="#" onclick='return false;'>Xem báo cáo</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="ast-row">
                        <div class="content">
                            <div class="heading">
                                <h3>Bảng minh họa dòng tiền</h3>
                                <div class="small">Với số tiền tích lũy: <?php echo number_format($money,  0, ',', '.'); ?> Đ/Tháng, đơn vị tính: VNĐ</div>
                            </div>
                            <div class="content-area">
                                <table>
                                    <tr>
                                        <th style="max-width: 100px" rowspan="2">LỢI NHUẬN KỲ VỌNG HÀNG NĂM</th>
                                        <th colspan="<?php echo sizeof($years); ?>">SỐ NĂM TÍCH LUỸ TÀI SẢN (KHÔNG RÚT RA GIỮA KỲ)</th>
                                    </tr>
                                    <tr>
                                        <?php foreach ($years as $item) {?>
                                            <th><?php echo $item['year']; ?> Năm</th>
                                        <?php } ?>
                                    </tr>
                                    <?php foreach ($percents as $item) {
                                        ?>
                                        <tr>
                                            <td><?php echo $item['percent']; ?>%</td>
                                            <?php foreach ($years as $year) {?>
                                                <td><?php echo number_format(interest_rate($money, $year['year'], $item['percent']), 0, ',', '.'); ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- The Modal -->
                    <div id="tfindex-thuyen-form-popup" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <span class="close">&times;</span>
                            </div>
                            <div class="modal-body">
                                <div class="tfindex-form-events">
                                    <h3 class="title-center">Đăng ký nhận thông báo</h3>
                                    <form id="tfindex-form-events" class="needs-validation">
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="tfindex-event">Báo cáo</label>
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
            <div class="second-tab" style="display: none">
                <div class="top-co-phieu ast-container">
                    <div class="ast-row">
                        <div class="ast-col-xs-12 ast-col-md-6">
                            <div class="title">Top cổ phiếu đầu ngành</div>
                            <table>
                                <tr>
                                    <th>Ngành</th>
                                    <th>Top cổ phiếu</th>
                                    <th style="border-right: unset;">Báo cáo phân tích</th>
                                </tr>
                                <?php foreach ($industry as $item) {
                                    $codes = flatten_arr($item['codes']);
                                    $codes = implode(', ', $codes);
                                    ?>
                                    <tr>
                                        <td><?php echo $item['name']; ?></td>
                                        <td><?php print_r($codes); ?></td>
                                        <td style="border-right: unset;"><a href="#">Xem báo cáo</a></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="ast-col-xs-12 ast-col-md-6">
                            <div class="title">Top 5 cổ phiếu tăng trưởng</div>
                            <?php
                                $topCodes = get_field('top_codes', 'option');
                            ?>
                            <table>
                                <tr>
                                    <th>Cổ phiếu</th>
                                    <th>Ngành</th>
                                    <th>Giá khuyến nghị</th>
                                    <th>Giá hiện tại</th>
                                    <th style="border-right: unset;">Trạng thái</th>
                                </tr>
                                <?php foreach ($topCodes as $item) {
                                    ?>
                                    <tr>
                                        <td><?php echo $item['top_cod']; ?></td>
                                        <td><?php echo $item['top_industry']; ?></td>
                                        <td><?php echo $item['top_price_expected']; ?></td>
                                        <td><?php echo $item['top_price_current']; ?></td>
                                        <td style="border-right: unset;"><?php echo $item['top_status'] ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php }
}
