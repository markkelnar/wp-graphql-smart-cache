<?php
/**
 * Plugin Name:     WP GraphQL Persisted Queries
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Persisted Queries and Caching for WP Graphql for WordPress
 * Author:          WPGraphQL
 * Author URI:      http://www.wpgraphql.com
 * Domain Path:     /languages
 * Version:         0.1.0-alpha
 */

namespace WPGraphQL\PersistedQueries;

use WPGraphQL\PersistedQueries\Document\Description;
use WPGraphQL\PersistedQueries\Document\Grant;
use WPGraphQL\PersistedQueries\Document\MaxAge;
use WPGraphQL\PersistedQueries\GraphiQL\GraphiQL;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

/**
 * Set the graphql-php server persistent query loader during server config setup.
 * When a queryId is found on the request, the call back is invoked to look up the query string.
 */
add_action(
    'graphql_server_config',
    function (\GraphQL\Server\ServerConfig $config) {
        $config->setPersistentQueryLoader(
            [ __NAMESPACE__ . '\Document\Loader', 'by_query_id' ]
        );
    },
    10,
    1
);

/**
 * Initialize the functionality for interacting with persisted queries using the GraphiQL IDE.
 */
add_action('admin_init', function () {
    $graphiql = new GraphiQL();
    $graphiql->init();
});

add_action(
    'init',
    function () {
        $document = new Document();
        $document->init();

        $description = new Description();
        $description->init();

        $grant = new Grant();
        $grant->init();

        $max_age = new MaxAge();
        $max_age->init();

        $errors = new AdminErrors();
        $errors->init();
    }
);

// Add a tab section to the graphql admin settings page
add_action(
    'graphql_register_settings',
    function () {
        register_graphql_settings_section(
            'graphql_persisted_queries_section',
            [
                'title' => __('Persisted Queries', 'wp-graphql-persisted-queries'),
            ]
        );
    }
);
