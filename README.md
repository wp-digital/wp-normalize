# Normalize

### Description

Disables probably unnecessary WordPress features, and a little changes behaviour.

### Install

- Preferable way is to use [Composer](https://getcomposer.org/):

    ````
    composer require innocode-digital/wp-normalize
    ````

    By default, it will be installed as [Must Use Plugin](https://codex.wordpress.org/Must_Use_Plugins).
    It's possible to change with `extra.installer-paths` in `composer.json`.

- Alternate way is to clone this repo to `wp-content/mu-plugins/` or `wp-content/plugins/`:

    ````
    cd wp-content/plugins/
    git clone git@github.com:innocode-digital/wp-normalize.git
    cd wp-normalize/
    composer install
    ````

If plugin installed as regular plugin then activate **Normalize** from Plugins page 
or [WP-CLI](https://make.wordpress.org/cli/handbook/): `wp plugin activate wp-normalize`.
