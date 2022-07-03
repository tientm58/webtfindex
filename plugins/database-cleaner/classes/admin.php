<?php
class Meow_DBCLNR_Admin extends MeowCommon_Admin {

	public $core;

	public function __construct( $core ) {
		parent::__construct( DBCLNR_PREFIX, DBCLNR_ENTRY, DBCLNR_DOMAIN, class_exists( 'MeowPro_DBCLNR_Core' ) );
		$this->core = $core;
		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'app_menu' ) );

			// Load the scripts only if they are needed by the current screen
			$page = isset( $_GET["page"] ) ? sanitize_text_field( $_GET["page"] ) : null;
			$is_dbclnr_screen = in_array( $page, [ 'dbclnr_settings', 'dbclnr_dashboard' ] );
			$is_meowapps_dashboard = $page === 'meowapps-main-menu';
			if ( $is_meowapps_dashboard || $is_dbclnr_screen ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			}
		}
	}

	function admin_enqueue_scripts() {

		// Load the scripts
		$physical_file = DBCLNR_PATH . '/app/index.js';
		$cache_buster = file_exists( $physical_file ) ? filemtime( $physical_file ) : DBCLNR_VERSION;
		wp_register_script( 'dbclnr_database_cleaner-vendor', DBCLNR_URL . 'app/vendor.js',
			['wp-element', 'wp-i18n'], $cache_buster
		);
		wp_register_script( 'dbclnr_database_cleaner', DBCLNR_URL . 'app/index.js',
			['dbclnr_database_cleaner-vendor', 'wp-i18n'], $cache_buster
		);
		wp_set_script_translations( 'dbclnr_database_cleaner', 'database-cleaner' );
		wp_enqueue_script('dbclnr_database_cleaner' );

		// Load the fonts
		wp_register_style( 'meow-neko-ui-lato-font', '//fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap');
		wp_enqueue_style( 'meow-neko-ui-lato-font' );

		// Localize and options
		wp_localize_script( 'dbclnr_database_cleaner', 'dbclnr_database_cleaner', array_merge( [
			'api_url' => rest_url( 'database-cleaner/v1' ),
			'rest_url' => rest_url(),
			'plugin_url' => DBCLNR_URL,
			'prefix' => DBCLNR_PREFIX,
			'db_prefix' => $this->core->prefix,
			'domain' => DBCLNR_DOMAIN,
			'is_pro' => class_exists( 'MeowPro_DBCLNR_Core' ),
			'is_registered' => !!$this->is_registered(),
			'rest_nonce' => wp_create_nonce( 'wp_rest' ),
			'core' => [
				'posts' => $this->core->add_clean_style_data( Meow_DBCLNR_Items::$POSTS ),
				'posts_metadata' => $this->core->add_clean_style_data( Meow_DBCLNR_Items::$POSTS_METADATA ),
				'users' => $this->core->add_clean_style_data( Meow_DBCLNR_Items::$USERS ),
				'comments' => $this->core->add_clean_style_data( Meow_DBCLNR_Items::$COMMENTS ),
				'transients' => $this->core->add_clean_style_data( Meow_DBCLNR_Items::$TRANSIENTS ),
			],
			'core_count' => [
				'posts' => $this->core->get_core_entry_counts( Meow_DBCLNR_Items::$POSTS ),
				'posts_metadata' => $this->core->get_core_entry_counts( Meow_DBCLNR_Items::$POSTS_METADATA ),
				'users' => $this->core->get_core_entry_counts( Meow_DBCLNR_Items::$USERS ),
				'comments' => $this->core->get_core_entry_counts( Meow_DBCLNR_Items::$COMMENTS ),
				'transients' => $this->core->get_core_entry_counts( Meow_DBCLNR_Items::$TRANSIENTS ),
			]
		], $this->get_all_options() ) );
	}

	function is_registered() {
		return apply_filters( DBCLNR_PREFIX . '_meowapps_is_registered', false, DBCLNR_PREFIX );
	}

	function app_menu() {
		add_submenu_page( 'meowapps-main-menu', 'Database Cleaner', 'Database Cleaner', 'manage_options',
			'dbclnr_settings', array( $this, 'admin_settings' ) );
	}

	function admin_settings() {
		echo wp_kses_post( '<div id="dbclnr-admin-settings"></div>' );
	}

	function list_options() {

		$options = [
			'dbclnr_aga_threshold' => '7 days',
			'dbclnr_custom_queries' => [],
			'dbclnr_bulk_batch_size' => 100,
			'dbclnr_options_limit' => 10,
			'dbclnr_cron_jobs_limit' => 10,
			'dbclnr_db_sizes' => [],
			'dbclnr_db_sizes_limit' => 10,
			'dbclnr_list_post_types_limit' => 10,
			'dbclnr_post_type_usedby' => [],
			'dbclnr_option_usedby' => [],
			'dbclnr_table_usedby' => [],
			'dbclnr_cron_job_usedby' => [],
		];

		// Clean Style Options for All Items
		$all_items = [
			Meow_DBCLNR_Items::$POSTS,
			Meow_DBCLNR_Items::$POSTS_METADATA,
			Meow_DBCLNR_Items::$USERS,
			Meow_DBCLNR_Items::$COMMENTS,
			Meow_DBCLNR_Items::$TRANSIENTS
		];
		foreach ( $all_items as $grouped_items ) {
			foreach ( $grouped_items as $item ) {
				$options['dbclnr_' . $item['item'] . '_clean_style'] = $item['clean_style'];
			}
		}

		// Clean Style Options for Post Types
		$list_post_types = $this->core->get_post_types();
		foreach ( $list_post_types as $post_type ) {
			$options['dbclnr_list_post_types_' . $post_type . '_clean_style'] = 'manual';
		}
		foreach ( Meow_DBCLNR_Support::$core_post_types as $post_type ) {
			$options['dbclnr_list_post_types_' . $post_type . '_clean_style'] = 'never';
		}

		// Set Db sizes default value
		if ( !count( $options['dbclnr_db_sizes'] ) ) {
			$this->update_db_sizes( $this->get_total_db_sizes() );
		}

		return $options;
	}

	function get_bulk_delete_threshold() {
		$key = 'dbclnr_bulk_batch_size';
		$options = $this->list_options();
		return get_option( $key, $options[$key] );
	}

	function get_all_options() {
		$options = $this->list_options();
		$current_options = array();
		foreach ( $options as $option => $default ) {
			$current_options[$option] = get_option( $option, $default );
		}
		return $current_options;
	}

	function get_db_sizes() {
		global $wpdb;
		$results = $wpdb->get_results( $wpdb->prepare( "
			SELECT TABLE_NAME 'table', ROUND(((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024), 2) 'size'
			FROM information_schema.TABLES
			WHERE table_schema = %s
			ORDER BY size DESC
			",
			DB_NAME
		), ARRAY_A );

		$total = 0;
		foreach ( $results as $item ) {
			$total += $item['size'];
		}
		foreach ( $results as &$item ) {
			$item['percent'] = floor( ( $item['size'] * 100 / $total ) * 100 ) / 100;
		}
		return $results;
	}

	function get_total_db_sizes() {
		$db_sizes = $this->get_db_sizes();
		$total = 0.0;
		foreach ( $db_sizes as $item ) {
			$total += $item['size'];
		}
		$total_size = round($total * 100) / 100;
		return $total_size;
	}

	function get_db_tables() {
		global $wpdb;
		$results = $wpdb->get_results( $wpdb->prepare( "
			SELECT TABLE_NAME 'table'
			FROM information_schema.TABLES
			WHERE table_schema = %s
			",
			DB_NAME
		), ARRAY_A );

		return $results;
	}

	function get_options() {
		global $wpdb;
		$where = "WHERE option_name NOT LIKE '_transient_%' AND option_name NOT LIKE '_site_transient_%' ";
		$result = $wpdb->get_results( "
				SELECT option_name, length(option_value) AS option_value_length, autoload
				FROM $wpdb->options
				$where
				ORDER BY option_value_length DESC
				", ARRAY_A);

		return $result;
	}

	function get_option_value( $option_name ) {
		//return [ json_encode( get_option( $option_name ) ) ];
		return [ [ 'option_value' => json_encode( get_option( $option_name ) ) ] ];
		// global $wpdb;
		// $result = $wpdb->get_results( $wpdb->prepare( "
		// 		SELECT option_value
		// 		FROM $wpdb->options
		// 		WHERE option_name = %s
		// 	", $option_name ) );
		// return $result;
	}

	function delete_options( $option_names ) {
		global $wpdb;
		$placeholder = array_fill( 0, count( $option_names ), '%s' );
		$placeholder = implode( ', ', $placeholder );
		$result = $wpdb->query( $wpdb->prepare( "
			DELETE t
			FROM $wpdb->options t
			WHERE option_name IN ($placeholder)
		", $option_names ) );

		if ($result === false) {
			throw new Error('Failed to delete the autoloaded options:' . $wpdb->last_error);
		}
		return $result;
	}

	function switch_autoloaded_option( $option_name, $autoload ) {
		global $wpdb;
		$result = $wpdb->query( $wpdb->prepare( "
			UPDATE $wpdb->options
			SET autoload = %s
			WHERE option_name = %s
		", $autoload, $option_name ) );

		return $result;
	}

	function delete_crons( $crons ) {
		foreach ( $crons as $cron ) {
			$result = $this->core->remove_cron_entry( $cron['name'], $cron['args'] );
			if ( $result === false ) {
				throw new Error('Failed to delete the cron option: ' . $cron['name'] );
			}
		}
		return true;
	}

	function delete_table( $table_name ) {
		global $wpdb;
		$result = $wpdb->query( "DROP TABLE IF EXISTS `{$this->core->prefix}{$table_name}`;" );
		if ($result === false) {
			error_log('PHP Exception: ' . $wpdb->last_error);
		}
		return $result;
	}

	function optimize_table( $table_name ) {
		global $wpdb;
		$result = $wpdb->query( "OPTIMIZE TABLE `{$this->core->prefix}{$table_name}`;" );
		if ($result === false) {
			error_log('PHP Exception: ' . $wpdb->last_error);
		}
		return $result;
	}

	function valid_item_operation( $item, $is_auto_clean = false ) {
		$all_options = $this->get_all_options();
		$clean_style = $all_options['dbclnr_' . $item . '_clean_style'];
		if ( $clean_style === 'never' ) {
			return false;
		}
		return !$is_auto_clean || ($is_auto_clean && $clean_style === 'auto');
	}

	function valid_custom_query_operation( $clean_style, $is_auto_clean = false ) {
		if ( !$clean_style || $clean_style === 'never') {
			return false;
		}

		return !$is_auto_clean || ($is_auto_clean && $clean_style === 'auto');
	}

	function valid_table_name( $table_name ) {
		$tables = array_column( $this->get_db_tables(), 'table' );
		return in_array( $this->core->prefix . $table_name, $tables, true );
	}

	function valid_deletable_table_name( $table_name ) {
		$data = apply_filters( 'dbclnr_check_table_info', $this->core->prefix . $table_name, null );
		return strtolower($data['usedBy']) !== 'wordpress';
	}

	function valid_deletable_option_name( $option_name ) {
		$data = apply_filters( 'dbclnr_check_option_info', $option_name, null );
		return strtolower($data['usedBy']) !== 'wordpress';
	}

	function valid_deletable_cron_name( $option_name ) {
		$data = apply_filters( 'dbclnr_check_cron_info', $option_name, null );
		return strtolower($data['usedBy']) !== 'wordpress';
	}

	function update_db_sizes( $db_sizes ) {
		$option_db_sizes = get_option( 'dbclnr_db_sizes', [] );
		$new_data = [ 'date' => date_i18n("Y-m-d H:i:s"), 'size' => $db_sizes ];
		if ( !count( $option_db_sizes ) ) {
			update_option( 'dbclnr_db_sizes', [ $new_data ] );
			return;
		}
		$last = $option_db_sizes[ count( $option_db_sizes ) - 1 ];
		if ( $last['size'] === $db_sizes ) {
			$i = count( $option_db_sizes ) - 1;
			$option_db_sizes[ $i ] = $new_data;
		} else {
			array_push( $option_db_sizes, $new_data );
		}

		if ( count( $option_db_sizes ) > 50 ) {
			array_shift( $option_db_sizes );
		}
		update_option( 'dbclnr_db_sizes', $option_db_sizes );
	}

	function get_previous_db_size() {
		$option_db_sizes = get_option( 'dbclnr_db_sizes', [] );
		if ( !count( $option_db_sizes ) || count( $option_db_sizes ) < 2 ) {
			return null;
		}
		return $option_db_sizes[ count( $option_db_sizes ) - 2 ]['size'];
	}
}

?>