<?php
/**
 * Content
 *
 * @package Wp_Graphql_Smart_Cache
 */

namespace WPGraphQL\SmartCache\Document;

use WPGraphQL\SmartCache\Admin\Settings;
use WPGraphQL\SmartCache\Document;

class Group {

	const TAXONOMY_NAME = 'graphql_document_group';

	public function init() {
		register_taxonomy(
			self::TAXONOMY_NAME,
			Document::TYPE_NAME,
			[
				'description'         => __( 'Tag the saved query document with other queries as a "group".', 'wp-graphql-smart-cache' ),
				'labels'              => [
					'name'          => __( 'Groups', 'wp-graphql-smart-cache' ),
					'singular_name' => __( 'Group', 'wp-graphql-smart-cache' ),
				],
				'hierarchical'        => false,
				'public'              => false,
				'publicly_queryable'  => false,
				'show_admin_column'   => true,
				'show_in_menu'        => Settings::show_in_admin(),
				'show_ui'             => Settings::show_in_admin(),
				'show_in_quick_edit'  => false,
				'show_in_graphql'     => true,
				'graphql_single_name' => 'graphql_document_group',
				'graphql_plural_name' => 'graphql_document_groups',
			]
		);
	}

	/**
	 * Look up the first group for a post
	 *
	 * @param int  The post id
	 */
	public static function get( $post_id ) {
		$item = get_the_terms( $post_id, self::TAXONOMY_NAME );
		return ! is_wp_error( $item ) && isset( $item[0]->name ) ? $item[0]->name : '';
	}
}
