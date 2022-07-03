<?php

class Meow_DBCLNR_Items {

  public static $POSTS = [
    [ 'item' => 'posts_revision', 'name' => 'Revisions', 'clean_style' => 'auto' ],
    [ 'item' => 'posts_auto_drafts', 'name' => 'Auto Drafts', 'clean_style' => 'auto' ],
    [ 'item' => 'posts_deleted_posts', 'name' => 'Deleted Posts', 'clean_style' => 'auto' ],
  ];

  public static $POSTS_METADATA = [
    [ 'item' => 'posts_metadata_orphaned_post_meta', 'name' => 'Orphaned Post Meta', 'clean_style' => 'auto' ],
    [ 'item' => 'posts_metadata_orphaned_term_meta', 'name' => 'Orphaned Term Meta', 'clean_style' => 'auto' ],
    [ 'item' => 'posts_metadata_orphaned_term_relationship', 'name' => 'Orphaned Term Relationship', 'clean_style' => 'auto' ],
    [ 'item' => 'posts_metadata_oembed_caches_in_post_meta', 'name' => 'oEmbed Caches in Post Meta', 'clean_style' => 'auto' ],
    [ 'item' => 'posts_metadata_unused_terms', 'name' => 'Unused Terms', 'clean_style' => 'auto' ],
    [ 'item' => 'posts_metadata_duplicated_term_meta', 'name' => 'Duplicated Term Meta', 'clean_style' => 'manual' ],
    [ 'item' => 'posts_metadata_duplicated_post_meta', 'name' => 'Duplicated Post Meta', 'clean_style' => 'manual' ],
  ];

  public static $USERS = [
    [ 'item' => 'users_orphaned_user_meta', 'name' => 'Orphaned User Meta', 'clean_style' => 'auto' ],
		[ 'item' => 'users_duplicated_user_meta', 'name' => 'Duplicated User Meta', 'clean_style' => 'manual' ],
  ];

  public static $COMMENTS = [
    [ 'item' => 'comments_unapproved_comments', 'name' => 'Unapproved Comments', 'clean_style' => 'auto' ],
    [ 'item' => 'comments_spammed_comments', 'name' => 'Spammed Comments', 'clean_style' => 'auto' ],
    [ 'item' => 'comments_deleted_comments', 'name' => 'Deleted Comments', 'clean_style' => 'auto' ],
    [ 'item' => 'comments_orphaned_comments_meta', 'name' => 'Orphaned Comments Meta', 'clean_style' => 'auto' ],
    [ 'item' => 'comments_duplicated_comments_meta', 'name' => 'Duplicated Comments Meta', 'clean_style' => 'manual' ],
  ];

  public static $TRANSIENTS = [
    [ 'item' => 'options_transient_options', 'name' => 'Transient Options', 'clean_style' => 'manual' ],
  ];

  public static function getName( $item ) {
    $items = [
      [ 'prefix' => 'posts_metadata_', 'list' => self::$POSTS_METADATA ],
      [ 'prefix' => 'posts_', 'list' => self::$POSTS ],
      [ 'prefix' => 'users_', 'list' => self::$USERS ],
      [ 'prefix' => 'comments_', 'list' => self::$COMMENTS ],
      [ 'prefix' => 'options_', 'list' => self::$TRANSIENTS ],
    ];
    foreach ( $items as $itemData ) {
      if ( strpos( $item, $itemData['prefix'] ) !== 0 ) {
        continue;
      }
      foreach ( $itemData['list'] as $data ) {
        if ( $data['item'] !== $item ) {
          continue;
        }
        return $data['name'];
      }
      break;
    }
    if ( strpos($item, 'list_post_types_') === 0 ) {
      return str_replace( [ 'list_post_types_' ], '', $item );
    }
    return null;
  }
}

?>