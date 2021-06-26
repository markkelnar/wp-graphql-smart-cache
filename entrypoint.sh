#!/bin/bash

# Run app setup script.
. app-setup.sh

PLUGINS_DIR=${PLUGINS_DIR-.}
echo "Plugins dir ($PLUGINS_DIR)"

if [ ! -f "${PLUGINS_DIR}/wp-graphql/wp-graphql.php" ]; then
    # WPGRAPHQL_VERSION in format like v1.2.3 or latest
    echo "Install wp-graphql version (${WPGRAPHQL_VERSION})"
    if [[ -z ${WPGRAPHQL_VERSION} || "${WPGRAPHQL_VERSION}" == "latest" ]]; then
        echo "Installing latest WPGraphQL from WordPress.org"
        wp plugin install wp-graphql --activate --allow-root
    else
    	echo "Installing WPGraphQL from Github"
        wp plugin install https://github.com/wp-graphql/wp-graphql/releases/download/${WPGRAPHQL_VERSION-v1.3.3}/wp-graphql.zip --allow-root
    fi
fi

. app-post-setup.sh

exec "$@"
