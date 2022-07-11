<?php

add_action( 'wp_ajax_ajax_report_for_pagination', 'ajax_report_for_pagination' );
add_action( 'wp_ajax_nopriv_ajax_report_for_pagination', 'ajax_report_for_pagination' );

function ajax_report_for_pagination() {
    global $wpdb;
    $msg = '';
    $pag_container = "";

    $paged = ( $_POST['page'] ) ? $_POST['page'] : 1;

    if($paged){
        $page = sanitize_text_field($paged);
        $cur_page = $page;
        $page -= 1;
        $per_page = 10;
        $previous_btn = true;
        $next_btn = true;
        $start = $page * $per_page;

        // Set the table where we will be querying data
        $table_name = $wpdb->prefix . "posts";

        // Query the posts
        $all_blog_posts = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM " . $table_name . " WHERE post_type = 'report' AND post_status = 'publish' ORDER BY post_date DESC LIMIT %d, %d", $start, $per_page ) );

        // At the same time, count the number of queried posts
        $count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(ID) FROM " . $table_name . " WHERE post_type = 'report' AND post_status = 'publish'", array() ) );

        // Loop into all the posts
        foreach($all_blog_posts as $key => $post):
            $msg .= '<div class = "report-thuyen">       
                        <div class="report-title"> <h3>' . $post->post_title . '</a></h3></div>
                        <div class="report-view"> <a href="#" class="top-co-phieu-report"  data-event="Báo cáo phân tích: ' . $post->post_title . ' "  onclick="return false;">Xem báo cáo</a></div>
                     </div>';
        endforeach;

        $no_of_paginations = ceil($count / $per_page);
        if ($cur_page >= 7) {
            $start_loop = $cur_page - 3;
            if ($no_of_paginations > $cur_page + 3)
                $end_loop = $cur_page + 3;
            else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
                $start_loop = $no_of_paginations - 6;
                $end_loop = $no_of_paginations;
            } else {
                $end_loop = $no_of_paginations;
            }
        } else {
            $start_loop = 1;
            if ($no_of_paginations > 7)
                $end_loop = 7;
            else
                $end_loop = $no_of_paginations;
        }

        // Pagination Buttons
        $pag_container .= "
    <div class='pagination-link'>
      <ul>";
        for ($i = $start_loop; $i <= $end_loop; $i++) {
            if ($cur_page == $i)
                $pag_container .= "<li p='$i' class = 'selected' >{$i}</li>";
            else
                $pag_container .= "<li p='$i' class='active'>{$i}</li>";
        }
        $pag_container = $pag_container . "
      </ul>
    </div>";
        echo
            '<div class = "thuyen-report-block">' .
            '<div class = "pagination-content">' . $msg . '</div>' .
            '<div class = "pagination-nav">' . $pag_container . '</div>'
            . '</div>';
    }
    die();
}
