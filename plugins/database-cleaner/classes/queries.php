<?php

class Meow_DBCLNR_Queries
{

	public static $COUNT = [
		'posts_revision' => 'count_posts_revision',
		'posts_auto_drafts' => 'count_posts_auto_drafts',
		'posts_deleted_posts' => 'count_posts_deleted_posts',
		'posts_metadata_orphaned_post_meta' => 'count_posts_metadata_orphaned_post_meta',
		'posts_metadata_duplicated_post_meta' => 'count_posts_metadata_duplicated_post_meta',
		'posts_metadata_oembed_caches_in_post_meta' => 'count_posts_metadata_oembed_caches_in_post_meta',
		'posts_metadata_orphaned_term_meta' => 'count_posts_metadata_orphaned_term_meta',
		'posts_metadata_duplicated_term_meta' => 'count_posts_metadata_duplicated_term_meta',
		'posts_metadata_orphaned_term_relationship' => 'count_posts_metadata_orphaned_term_relationship',
		'posts_metadata_unused_terms' => 'count_posts_metadata_unused_terms',
		'users_orphaned_user_meta' => 'count_users_orphaned_user_meta',
		'users_duplicated_user_meta' => 'count_users_duplicated_user_meta',
		'comments_unapproved_comments' => 'count_comments_unapproved_comments',
		'comments_spammed_comments' => 'count_comments_spammed_comments',
		'comments_deleted_comments' => 'count_comments_deleted_comments',
		'comments_orphaned_comments_meta' => 'count_comments_orphaned_comments_meta',
		'comments_duplicated_comments_meta' => 'count_comments_duplicated_comments_meta',
		'options_transient_options' => 'count_options_transient_options',
	];

	public static $QUERIES = [
		'posts_revision' => 'delete_posts_revision',
		'posts_auto_drafts' => 'delete_posts_auto_drafts',
		'posts_deleted_posts' => 'delete_posts_deleted_posts',
		'posts_metadata_orphaned_post_meta' => 'delete_posts_metadata_orphaned_post_meta',
		'posts_metadata_duplicated_post_meta' => 'delete_posts_metadata_duplicated_post_meta',
		'posts_metadata_oembed_caches_in_post_meta' => 'delete_posts_metadata_oembed_caches_in_post_meta',
		'posts_metadata_orphaned_term_meta' => 'delete_posts_metadata_orphaned_term_meta',
		'posts_metadata_duplicated_term_meta' => 'delete_posts_metadata_duplicated_term_meta',
		'posts_metadata_orphaned_term_relationship' => 'delete_posts_metadata_orphaned_term_relationship',
		'posts_metadata_unused_terms' => 'delete_posts_metadata_unused_terms',
		'users_orphaned_user_meta' => 'delete_users_orphaned_user_meta',
		'users_duplicated_user_meta' => 'delete_users_duplicated_user_meta',
		'comments_unapproved_comments' => 'delete_comments_unapproved_comments',
		'comments_spammed_comments' => 'delete_comments_spammed_comments',
		'comments_deleted_comments' => 'delete_comments_deleted_comments',
		'comments_orphaned_comments_meta' => 'delete_comments_orphaned_comments_meta',
		'comments_duplicated_comments_meta' => 'delete_comments_duplicated_comments_meta',
		'options_transient_options' => 'delete_options_transient_options',
	];

	public static $GET = [
		'posts_revision' => 'get_posts_revision',
		'posts_auto_drafts' => 'get_posts_auto_drafts',
		'posts_deleted_posts' => 'get_posts_deleted_posts',
		'posts_metadata_orphaned_post_meta' => 'get_posts_metadata_orphaned_post_meta',
		'posts_metadata_duplicated_post_meta' => 'get_posts_metadata_duplicated_post_meta',
		'posts_metadata_oembed_caches_in_post_meta' => 'get_posts_metadata_oembed_caches_in_post_meta',
		'posts_metadata_orphaned_term_meta' => 'get_posts_metadata_orphaned_term_meta',
		'posts_metadata_duplicated_term_meta' => 'get_posts_metadata_duplicated_term_meta',
		'posts_metadata_orphaned_term_relationship' => 'get_posts_metadata_orphaned_term_relationship',
		'posts_metadata_unused_terms' => 'get_posts_metadata_unused_terms',
		'users_orphaned_user_meta' => 'get_users_orphaned_user_meta',
		'users_duplicated_user_meta' => 'get_users_duplicated_user_meta',
		'comments_unapproved_comments' => 'get_comments_unapproved_comments',
		'comments_spammed_comments' => 'get_comments_spammed_comments',
		'comments_deleted_comments' => 'get_comments_deleted_comments',
		'comments_orphaned_comments_meta' => 'get_comments_orphaned_comments_meta',
		'comments_duplicated_comments_meta' => 'get_comments_duplicated_comments_meta',
		'options_transient_options' => 'get_options_transient_options',
	];
	public static $GET_LIMIT = 10;

	/** ========================
	 * Count queries
	 * ======================== */

	public static function count_posts_revision( $age_threshold )
	{
		$week_ago = new DateTime('-' . $age_threshold);
		global $wpdb;
		return $wpdb->get_var( $wpdb->prepare(
			"
			SELECT COUNT(ID) 
			FROM   $wpdb->posts 
			WHERE  post_modified < %s 
			AND post_type = 'revision'
			",
			$week_ago->format('Y-m-d H:i:s')
		));
	}

	public static function count_posts_auto_drafts( $age_threshold )
	{
		$week_ago = new DateTime('-' . $age_threshold);
		global $wpdb;
		return $wpdb->get_var( $wpdb->prepare(
			"
			SELECT COUNT(ID) 
			FROM   $wpdb->posts 
			WHERE  post_modified < %s 
			AND post_status = 'auto-draft'
			",
			$week_ago->format('Y-m-d H:i:s')
		));
	}

	public static function count_posts_deleted_posts( $age_threshold )
	{
		$week_ago = new DateTime('-' . $age_threshold);
		global $wpdb;
		return $wpdb->get_var( $wpdb->prepare(
			"
			SELECT COUNT(ID) 
			FROM   $wpdb->posts 
			WHERE  post_modified < %s 
			AND post_status = 'trash'
			",
			$week_ago->format('Y-m-d H:i:s')
		));
	}

	public static function count_posts_metadata_orphaned_post_meta()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(pm.meta_id)
			FROM $wpdb->postmeta pm
			LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id
			WHERE wp.ID IS NULL;
			"
		);
	}

	public static function count_posts_metadata_duplicated_post_meta()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(t1.meta_id) FROM $wpdb->postmeta t1 
			INNER JOIN $wpdb->postmeta t2  
			WHERE  t1.meta_id < t2.meta_id 
			AND  t1.meta_key = t2.meta_key 
			AND t1.post_id = t2.post_id
			"
		);
	}

	public static function count_posts_metadata_oembed_caches_in_post_meta()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(pm.meta_id)
			FROM $wpdb->postmeta pm
			WHERE pm.meta_key LIKE '_oembed_%';
			"
		);
	}

	public static function count_posts_metadata_orphaned_term_meta()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(tm.meta_id)
			FROM $wpdb->termmeta tm
			LEFT JOIN $wpdb->terms t on t.term_id = tm.term_id
			WHERE t.term_id IS NULL;
			"
		);
	}

	public static function count_posts_metadata_duplicated_term_meta()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(tm1.meta_id)
			FROM $wpdb->termmeta tm1
			WHERE tm1.meta_id NOT IN(
				SELECT *
				FROM (
					SELECT MAX(tm2.meta_id)
					FROM $wpdb->termmeta tm2
					GROUP BY tm2.term_id, tm2.meta_key
				) x
			);
			"
		);
	}

	public static function count_posts_metadata_orphaned_term_relationship()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(tr.term_taxonomy_id)
			FROM $wpdb->term_relationships tr
			LEFT JOIN $wpdb->term_taxonomy p ON tr.term_taxonomy_id = p.term_taxonomy_id
			WHERE p.term_taxonomy_id IS NULL;
			"
		);
	}

	public static function count_posts_metadata_unused_terms()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(t.term_id)
			FROM $wpdb->terms t
			LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id
			WHERE tt.term_taxonomy_id IS NULL;
			"
		);
	}

	public static function count_users_orphaned_user_meta()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(um.umeta_id)
			FROM $wpdb->usermeta um
			LEFT JOIN $wpdb->users u ON u.ID = um.user_id
			WHERE u.ID IS NULL;
			"
		);
	}

	public static function count_users_duplicated_user_meta()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(um1.umeta_id)
			FROM $wpdb->usermeta um1
			WHERE um1.umeta_id NOT IN(
				SELECT *
				FROM (
					SELECT MAX(um2.umeta_id)
					FROM $wpdb->usermeta um2
					GROUP BY um2.user_id, um2.meta_key
				) x
			);
			"
		);
	}

	public static function count_comments_unapproved_comments()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(comment_ID)
			FROM $wpdb->comments
			WHERE comment_approved = '0'
			"
		);
	}

	public static function count_comments_spammed_comments()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(comment_ID)
			FROM $wpdb->comments
			WHERE comment_approved = 'spam'
			"
		);
	}

	public static function count_comments_deleted_comments()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(comment_ID)
			FROM $wpdb->comments
			WHERE comment_approved = 'trash'
			"
		);
	}

	public static function count_comments_orphaned_comments_meta()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(cm.comment_id)
			FROM $wpdb->commentmeta cm
			LEFT JOIN $wpdb->comments c ON c.comment_ID = cm.comment_id
			WHERE c.comment_ID IS NULL;
			"
		);
	}

	public static function count_comments_duplicated_comments_meta()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(cm1.meta_id)
			FROM $wpdb->commentmeta cm1
			WHERE cm1.meta_id NOT IN(
				SELECT *
				FROM (
					SELECT MAX(cm2.meta_id)
					FROM $wpdb->commentmeta cm2
					GROUP BY cm2.comment_id, cm2.meta_key
				) x
			);
			"
		);
	}

	public static function count_options_transient_options()
	{
		global $wpdb;
		return $wpdb->get_var(
			"
			SELECT COUNT(option_id)
			FROM $wpdb->options
			WHERE option_name LIKE '_transient_%';
			"
		);
	}

	/** ========================
	 * Load queries
	 * ======================== */
	public static function get_posts_revision( $age_threshold )
	{
		$week_ago = new DateTime('-' . $age_threshold);
		global $wpdb;
		$sql = $wpdb->prepare(
			"
			SELECT *
			FROM   $wpdb->posts
			WHERE  post_modified < %s
			AND post_type = 'revision'
			LIMIT 0, %d
			",
			$week_ago->format('Y-m-d H:i:s'), self::$GET_LIMIT
		);
		$results = $wpdb->get_results( $sql, ARRAY_A );
		return $results;
	}

	public static function get_posts_auto_drafts( $age_threshold )
	{
		$week_ago = new DateTime('-' . $age_threshold);
		global $wpdb;
		$sql = $wpdb->prepare(
			"
			SELECT *
			FROM   $wpdb->posts
			WHERE  post_modified < %s
			AND post_status = 'auto-draft'
			LIMIT 0, %d
			",
			$week_ago->format('Y-m-d H:i:s'), self::$GET_LIMIT
		);
		$results = $wpdb->get_results( $sql, ARRAY_A );
		return $results;
	}

	public static function get_posts_deleted_posts( $age_threshold )
	{
		$week_ago = new DateTime('-' . $age_threshold);
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT *
			FROM   $wpdb->posts
			WHERE  post_modified < %s
			AND post_status = 'trash'
			LIMIT 0, %d
			",
			$week_ago->format('Y-m-d H:i:s'), self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_posts_metadata_orphaned_post_meta()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT pm.*
			FROM $wpdb->postmeta pm
			LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id
			WHERE wp.ID IS NULL
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_posts_metadata_duplicated_post_meta()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT t1.*
			FROM $wpdb->postmeta t1
			INNER JOIN $wpdb->postmeta t2
			WHERE  t1.meta_id < t2.meta_id
			AND  t1.meta_key = t2.meta_key
			AND t1.post_id = t2.post_id
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_posts_metadata_oembed_caches_in_post_meta()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT *
			FROM $wpdb->postmeta pm
			WHERE pm.meta_key LIKE '_oembed_%'
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_posts_metadata_orphaned_term_meta()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT tm.*
			FROM $wpdb->termmeta tm
			LEFT JOIN $wpdb->terms t on t.term_id = tm.term_id
			WHERE t.term_id IS NULL
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_posts_metadata_duplicated_term_meta()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT tm.*
			FROM $wpdb->termmeta tm1
			WHERE tm1.meta_id NOT IN(
				SELECT *
				FROM (
					SELECT MAX(tm2.meta_id)
					FROM $wpdb->termmeta tm2
					GROUP BY tm2.term_id, tm2.meta_key
				) x
			)
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_posts_metadata_orphaned_term_relationship()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT tr.*
			FROM $wpdb->term_relationships tr
			LEFT JOIN $wpdb->term_taxonomy p ON tr.term_taxonomy_id = p.term_taxonomy_id
			WHERE p.term_taxonomy_id IS NULL
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_posts_metadata_unused_terms()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT t.*
			FROM $wpdb->terms t
			LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id
			WHERE tt.term_taxonomy_id IS NULL
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_users_orphaned_user_meta()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT um.*
			FROM $wpdb->usermeta um
			LEFT JOIN $wpdb->users u ON u.ID = um.user_id
			WHERE u.ID IS NULL
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_users_duplicated_user_meta()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT um1.*
			FROM $wpdb->usermeta um1
			WHERE um1.umeta_id NOT IN(
				SELECT *
				FROM (
					SELECT MAX(um2.umeta_id)
					FROM $wpdb->usermeta um2
					GROUP BY um2.user_id, um2.meta_key
				) x
			)
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_comments_unapproved_comments()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT *
			FROM $wpdb->comments
			WHERE comment_approved = '0'
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_comments_spammed_comments()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT *
			FROM $wpdb->comments
			WHERE comment_approved = 'spam'
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_comments_deleted_comments()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT *
			FROM $wpdb->comments
			WHERE comment_approved = 'trash'
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_comments_orphaned_comments_meta()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT cm.*
			FROM $wpdb->commentmeta cm
			LEFT JOIN $wpdb->comments c ON c.comment_ID = cm.comment_id
			WHERE c.comment_ID IS NULL
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_comments_duplicated_comments_meta()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT cm1.*
			FROM $wpdb->commentmeta cm1
			WHERE cm1.meta_id NOT IN(
				SELECT *
				FROM (
					SELECT MAX(cm2.meta_id)
					FROM $wpdb->commentmeta cm2
					GROUP BY cm2.comment_id, cm2.meta_key
				) x
			)
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	public static function get_options_transient_options()
	{
		global $wpdb;
		return $wpdb->get_results( $wpdb->prepare(
			"
			SELECT *
			FROM $wpdb->options
			WHERE option_name LIKE '_transient_%'
			LIMIT 0, %d
			",
			self::$GET_LIMIT
		), ARRAY_A );
	}

	/** ========================
	 * Delete queries
	 * ======================== */

	public static function get_bulk_delete_threshold()
	{
		return get_option( 'dbclnr_bulk_batch_size', 100 );
	}

	public static function delete_posts_revision( $age_threshold )
	{
		$week_ago = new DateTime('-' . $age_threshold);
		$limit = self::get_bulk_delete_threshold();
		global $wpdb;
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->posts
			WHERE post_modified < %s
			AND post_type = 'revision'
			LIMIT %d
			",
			$week_ago->format('Y-m-d H:i:s'), $limit
		) );
		if ($result === false) {
			throw new Error('Failed to delete the post. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_posts_auto_drafts( $age_threshold )
	{
		$week_ago = new DateTime('-' . $age_threshold);
		$limit = self::get_bulk_delete_threshold();
		global $wpdb;
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->posts
			WHERE post_modified < %s
			AND post_status = 'auto-draft'
			LIMIT %d
			",
			$week_ago->format('Y-m-d H:i:s'), $limit
		));
		if ($result === false) {
			throw new Error('Failed to delete the post. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_posts_deleted_posts( $age_threshold )
	{
		$week_ago = new DateTime('-' . $age_threshold);
		$limit = self::get_bulk_delete_threshold();
		global $wpdb;
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->posts
			WHERE post_modified < %s
			AND post_status = 'trash'
			LIMIT %d
			",
			$week_ago->format('Y-m-d H:i:s'), $limit
		));
		if ($result === false) {
			throw new Error('Failed to delete the post. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_posts_metadata_orphaned_post_meta()
	{
		global $wpdb;
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->postmeta
			WHERE meta_id IN (
				SELECT *
				FROM (
					SELECT t.meta_id
					FROM $wpdb->postmeta t
					LEFT JOIN $wpdb->posts wp ON wp.ID = t.post_id
					WHERE wp.ID IS NULL
					LIMIT %d
				) x
			)
			",
			$limit
		));
		if ($result === false) {
			throw new Error('Failed to delete the orphaned post meta. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_posts_metadata_duplicated_post_meta()
	{
		global $wpdb;
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->postmeta
			WHERE meta_id IN (
				SELECT *
				FROM (
					SELECT t1.meta_id
					FROM $wpdb->postmeta t1
					INNER JOIN $wpdb->postmeta t2
					WHERE t1.meta_id < t2.meta_id
					AND t1.meta_key = t2.meta_key
					AND t1.post_id = t2.post_id
					LIMIT %d
				) x
			)
			",
			$limit
		));
		if ($result === false) {
			throw new Error('Failed to delete the duplicated post meta. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_posts_metadata_oembed_caches_in_post_meta()
	{
		global $wpdb;
		$count = self::count_posts_metadata_oembed_caches_in_post_meta();
		if ($count === 0) {
			return 0;
		}
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->postmeta
			WHERE meta_key LIKE '_oembed_%'
			LIMIT %d
			",
			$limit
		) );
		if ($result === false) {
			throw new Error('Failed to delete the oembed caches in post meta. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_posts_metadata_orphaned_term_meta()
	{
		global $wpdb;
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->termmeta
			WHERE meta_id IN (
				SELECT *
				FROM (
					SELECT t1.meta_id
					FROM $wpdb->termmeta t1
					LEFT JOIN $wpdb->terms t2 on t2.term_id = t1.term_id
					WHERE t2.term_id IS NULL
					LIMIT %d
				) x
			)
			",
			$limit
		));
		if ($result === false) {
			throw new Error('Failed to delete the orphaned term meta. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_posts_metadata_duplicated_term_meta()
	{
		global $wpdb;
		$count = self::count_posts_metadata_duplicated_term_meta();
		if ($count === 0) {
			return 0;
		}
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->termmeta
			WHERE meta_id IN(
				SELECT *
				FROM (
					SELECT t1.meta_id
					FROM $wpdb->termmeta t1
					INNER JOIN $wpdb->termmeta t2
					WHERE  t1.meta_id < t2.meta_id
					AND  t1.meta_key = t2.meta_key
					AND t1.term_id = t2.term_id
					LIMIT %d
				) x
			)
			",
			$limit
		) );
		if ($result === false) {
			throw new Error('Failed to delete the duplicated term meta. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_posts_metadata_orphaned_term_relationship()
	{
		global $wpdb;
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->term_relationships
			WHERE object_id IN (
				SELECT *
				FROM (
					SELECT t.object_id
					FROM $wpdb->term_relationships t
					LEFT JOIN $wpdb->term_taxonomy p ON t.term_taxonomy_id = p.term_taxonomy_id
					WHERE p.term_taxonomy_id IS NULL
					LIMIT %d
				) x
			)

			",
			$limit
		) );
		if ($result === false) {
			throw new Error('Failed to delete the orphaned term relationship. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_posts_metadata_unused_terms()
	{
		global $wpdb;
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->terms
			WHERE term_id IN (
				SELECT *
				FROM (
					SELECT t1.term_id
					FROM $wpdb->terms t1
					LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t1.term_id
					WHERE tt.term_taxonomy_id IS NULL
					LIMIT %d
				) x
			)
			",
			$limit
		));
		if ($result === false) {
			throw new Error('Failed to delete the unused terms. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_users_orphaned_user_meta()
	{
		global $wpdb;
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->usermeta
			WHERE umeta_id IN (
				SELECT *
				FROM (
					SELECT t.umeta_id
					FROM $wpdb->usermeta t
					LEFT JOIN $wpdb->users u ON u.ID = t.user_id
					WHERE u.ID IS NULL
					LIMIT %d
				) x
			)
			",
			$limit
		));
		if ($result === false) {
			throw new Error('Failed to delete the orphaned user meta. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_users_duplicated_user_meta()
	{
		global $wpdb;
		$count = self::count_users_duplicated_user_meta();
		if ($count === 0) {
			return 0;
		}
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->usermeta
			WHERE umeta_id NOT IN(
				SELECT *
				FROM (
					SELECT MAX(um2.umeta_id)
					FROM $wpdb->usermeta um2
					GROUP BY um2.user_id, um2.meta_key
				) x
			)
			LIMIT %d
			",
			$limit
		) );
		if ($result === false) {
			throw new Error('Failed to delete the duplicated user meta. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_comments_unapproved_comments()
	{
		global $wpdb;
		$count = self::count_comments_unapproved_comments();
		if ($count === 0) {
			return 0;
		}
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->comments
			WHERE comment_approved = '0'
			LIMIT %d
			",
			$limit
		) );
		if ($result === false) {
			throw new Error('Failed to delete the unapproved comments. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_comments_spammed_comments()
	{
		global $wpdb;
		$count = self::count_comments_spammed_comments();
		if ($count === 0) {
			return 0;
		}
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->comments
			WHERE comment_approved = 'spam'
			LIMIT %d
			",
			$limit
		) );
		if ($result === false) {
			throw new Error('Failed to delete the spammed comments. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_comments_deleted_comments()
	{
		global $wpdb;
		$count = self::count_comments_deleted_comments();
		if ($count === 0) {
			return 0;
		}
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->comments
			WHERE comment_approved = 'trash'
			LIMIT %d
			",
			$limit
		) );
		if ($result === false) {
			throw new Error('Failed to delete the deleted comments. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_comments_orphaned_comments_meta()
	{
		global $wpdb;
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->commentmeta
			WHERE meta_id IN (
				SELECT *
				FROM (
					SELECT t.meta_id
					FROM $wpdb->commentmeta t
					LEFT JOIN $wpdb->comments c ON c.comment_ID = t.comment_id
					WHERE c.comment_ID IS NULL
					LIMIT %d
				) x
			)
			",
			$limit
		));
		if ($result === false) {
			throw new Error('Failed to delete the orphaned comments meta. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_comments_duplicated_comments_meta()
	{
		global $wpdb;
		$count = self::count_comments_duplicated_comments_meta();
		if ($count === 0) {
			return 0;
		}
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->commentmeta
			WHERE meta_id NOT IN(
				SELECT *
				FROM (
					SELECT MAX(cm2.meta_id)
					FROM $wpdb->commentmeta cm2
					GROUP BY cm2.comment_id, cm2.meta_key
				) x
			)
			LIMIT %d
			",
			$limit
		) );
		if ($result === false) {
			throw new Error('Failed to delete the duplicated comments meta. : ' . $wpdb->last_error);
		}
		return $result;
	}

	public static function delete_options_transient_options()
	{
		global $wpdb;
		$count = self::count_options_transient_options();
		if ($count === 0) {
			return 0;
		}
		$limit = self::get_bulk_delete_threshold();
		$result = $wpdb->query( $wpdb->prepare(
			"
			DELETE FROM $wpdb->options
			WHERE option_name LIKE '_transient_%'
			LIMIT %d
			",
			$limit
		) );
		if ($result === false) {
			throw new Error('Failed to delete the duplicated comments meta. : ' . $wpdb->last_error);
		}
		return $result;
	}
}
