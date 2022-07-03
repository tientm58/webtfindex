<?php

class Meow_DBCLNR_Core
{
	public $admin = null;
	public $is_rest = false;
	public $is_cli = false;
	public $site_url = null;
	public $prefix = null;

	protected $log_file = 'database-cleaner.log';
	protected $log_dir_path = '';
	protected $log_file_path = '';

	public function __construct() {
		global $wpdb;
		$this->prefix = $wpdb->prefix;
		$this->site_url = get_site_url();
		$this->is_rest = MeowCommon_Helpers::is_rest();
		$this->is_cli = defined( 'WP_CLI' ) && WP_CLI;
		add_action( 'plugins_loaded', array( $this, 'init' ) );
		new Meow_DBCLNR_Support( $this );
		$this->log_dir_path = DBCLNR_PATH . '/logs/';
		$this->log_file_path = DBCLNR_PATH . '/logs/' . $this->log_file;

		// Advanced core
		if ( class_exists( 'MeowPro_DBCLNR_Core' ) ) {
			new MeowPro_DBCLNR_Core( $this );
		}
	}

	function init() {
		// Part of the core, settings and stuff
		$this->admin = new Meow_DBCLNR_Admin( $this );

		// Only for REST
		if ( $this->is_rest ) {
			new Meow_DBCLNR_Rest( $this, $this->admin );
		}

		// Dashboard
		if ( is_admin() ) {
			new Meow_DBCLNR_UI( $this, $this->admin );
		}
	}

	/**
	 *
	 * Roles & Access Rights
	 *
	 */
	function can_access_settings() {
		return apply_filters( 'dbclnr_allow_setup', current_user_can( 'manage_options' ) );
	}

	function can_access_features() {
		return apply_filters( 'dbclnr_allow_usage', current_user_can( 'administrator' ) );
	}

	/**
	 *
	 * Actions for Settings
	 *
	 */
	function get_post_types() {
		global $wpdb;
		return $wpdb->get_col( "SELECT DISTINCT post_type FROM $wpdb->posts" );
	}

	function calculate_posts_query_parameters( $post_type, $post_status, $age_threshold ) {
		global $wpdb;
		$before_date = new DateTime( '-' . $age_threshold );
			$where_type = "";
			$where_status = "";
			if ($post_type) {
				$where_type = $wpdb->prepare( " AND post_type = %s ", $post_type );
			}
			if ($post_status) {
				$where_status = $wpdb->prepare( " AND post_status = %s ", $post_status );
			}
		return [ $where_type, $where_status, $before_date ];
	}

	function get_entry_count( $post_type, $post_status, $age_threshold ) {
		global $wpdb;
    list( $where_type, $where_status, $before_date ) = 
      $this->calculate_posts_query_parameters( $post_type, $post_status, $age_threshold );
		return $wpdb->get_var( $wpdb->prepare( "
			SELECT COUNT(ID) 
			FROM   $wpdb->posts 
			WHERE  post_modified < %s 
			$where_type
			$where_status
			",
			$before_date->format('Y-m-d H:i:s')
		) );
	}

	function get_entries( $post_type, $post_status, $age_threshold ) {
		global $wpdb;
    list( $where_type, $where_status, $before_date ) =
		$this->calculate_posts_query_parameters( $post_type, $post_status, $age_threshold );
		return $wpdb->get_results( $wpdb->prepare( "
			SELECT *
			FROM   $wpdb->posts
			WHERE  post_modified < %s
			$where_type
			$where_status
			LIMIT 0, %d
			",
			$before_date->format('Y-m-d H:i:s'), Meow_DBCLNR_Queries::$GET_LIMIT
		), ARRAY_A );
	}

	function do_custom_query_count( $query ) {
		global $wpdb;
		$result = $wpdb->get_var( $query );
		if ( $result === null ) {
			throw new RuntimeException($wpdb->last_error);
		}
		return $result;
	}

	function do_custom_query_delete( $query ) {
		global $wpdb;
		$result = $wpdb->query( $query );
		if ( $result === false ) {
			throw new RuntimeException($wpdb->last_error);
		}
		return $result;
	}

	function delete_entries( $post_type, $post_status, $age_threshold ) {
		global $wpdb;
    list( $where_type, $where_status, $before_date ) = 
      $this->calculate_posts_query_parameters( $post_type, $post_status, $age_threshold );
		$limit = $this->admin->get_bulk_delete_threshold();
    $query =  $wpdb->prepare( "DELETE 
      FROM $wpdb->posts 
      WHERE post_modified < %s 
      $where_type
      $where_status
      LIMIT %d", $before_date->format('Y-m-d H:i:s'), $limit
    );
		$count = $wpdb->query( $query );
		if ( $count === false ) {
			throw new Error('Failed to delete entries.');
		}
		return $count;
	}

	function logs_directory_check() {
		if ( !file_exists( $this->log_dir_path ) ) {
			mkdir( $this->log_dir_path, 0777 );
		}
	}

	function remove_cron_entry( $name, $args = array() ) {
		return !!wp_clear_scheduled_hook( $name, $args );
	}

	function format_cron_info( $list ) {
		$data = array();
		foreach ( $list as $unixtime => $item ) {
			if ( !is_array( $item ) ) { 
				continue;
			}
			foreach ( $item as $cron_name => $detail ) {
				foreach ( $detail as $info ) {
					$data[] = array_merge( $info, [
						'cron_name' => $cron_name,
						'unixtime' => $unixtime,
						'args' => $info['args'],
					] );
				}
			}
		}
		return $data;
	}

	function get_core_entry_counts( $list ) {
		$age_threshold = get_option( 'dbclnr_aga_threshold', '7 days' );
		$age_threshold = $age_threshold === 'none' ? 0 : $age_threshold;
		$list = $this->add_clean_style_data( $list );
		$counts = [];
		foreach ( $list as $data ) {
			if ( $data['clean_style'] !== 'auto' ) continue;
			$counts[] = [
				'item' => $data['item'],
				'count' => Meow_DBCLNR_Queries::{Meow_DBCLNR_Queries::$COUNT[$data['item']]}($age_threshold),
			];
		}
		return $counts;
	}

	function add_clean_style_data ( $list ) {
		$options = $this->admin->get_all_options();
		$data = array();
		foreach ( $list as $item ) {
			$data[] = array_merge( $item, [
				'clean_style' => $options[ 'dbclnr_' . $item['item'] . '_clean_style' ]
			] );
		}
		return $data;
	}

	function log( $data = null ) {
		$this->logs_directory_check();
		$fh = @fopen( $this->log_file_path, 'a' );
		if ( !$fh )
			return false;
		$date = date( "Y-m-d H:i:s" );
		if ( is_null( $data ) )
			fwrite( $fh, "\n" );
		else
			fwrite( $fh, "$date: {$data}\n" );
		fclose( $fh );
		return true;
	}

	function get_logs() {
		if ( !file_exists( $this->log_file_path ) ) {
			return "No data.";
		}
		return file_get_contents( $this->log_file_path );
	}

	function clear_logs() {
		unlink( $this->log_file_path );
	}
}

?>