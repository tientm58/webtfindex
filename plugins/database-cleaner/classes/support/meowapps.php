<?php

class Meow_DBCLNR_Support_MeowApps {

  public function __construct() {
    add_filter( 'dbclnr_check_support_for_option', array( $this, 'check_support_for_option' ), 10, 3 );
	}

  function check_support_for_option_for( $plugin, $pluginName, $active_plugins ) {
    if ( in_array( $plugin, $active_plugins ) ) {
      return [ 'status' => 'ok', 'usedBy' => $pluginName ];
    }
    if ( in_array( $plugin . '-pro', $active_plugins ) ) {
      return [ 'status' => 'ok', 'usedBy' => $pluginName ];
    }
    return [ 'status' => 'warn', 'usedBy' => $pluginName ];
  }

  function check_support_for_option( $status, $option, $active_plugins ) {
    if ( substr( $option, 0, 7 ) === "dbclnr_" ) {
      return $this->check_support_for_option_for( 'database-cleaner', 'Database Cleaner', $active_plugins );
    }
    if ( substr( $option, 0, 5 ) === "mgcl_" ) {
      return $this->check_support_for_option_for( 'custom-gallery-links', 'Custom Gallery Links', $active_plugins );
    }
    if ( substr( $option, 0, 5 ) === "mfrh_" ) {
      return $this->check_support_for_option_for( 'media-file-renamer', 'Media File Renamer', $active_plugins );
    }
    if ( substr( $option, 0, 5 ) === "wr2x_" ) {
      return $this->check_support_for_option_for( 'wp-retina-2x', 'Perfect Images', $active_plugins );
    }
    if ( substr( $option, 0, 5 ) === "wpmc_" ) {
      return $this->check_support_for_option_for( 'media-cleaner', 'Media Cleaner', $active_plugins );
    }
    if ( substr( $option, 0, 4 ) === "mct_" ) {
      return $this->check_support_for_option_for( 'media-cleaner', 'Media Cleaner', $active_plugins );
    }
    if ( substr( $option, 0, 9 ) === "meowapps_" ) {
      return [ 'status' => 'ok', 'usedBy' => 'Meow Apps' ];
    }
    return $status;
  }

}