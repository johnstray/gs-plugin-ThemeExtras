<?php
/**
 * GetSimple CMS Theme Extras
 * Allows themes to provide extra functionality and configuration options to enable more advanced theming and theme
 * control of themes designed and developed for GetSimple CMS.
 * 
 * @author  John Stray <getsimple@johnstray.com>
 * @url     https://johnstray.com/gs-plugin/ThemeExtras
 * @version 1.0.0
 */

# Prevent improper loading of this file. Must be loaded via GetSimple's plugin interface.
if ( defined('IN_GS') === false ) { die( 'You cannot load this file directly!' ); }

# Define the plugin identifier and base path
define( 'THEMEXTRAS', basename(__FILE__, ".php") );
define( 'THEMEXTRASPATH', GSPLUGINPATH . DIRECTORY_SEPARATOR . THEMEXTRAS . DIRECTORY_SEPARATOR );

# Setup and merge language files
i18n_merge( THEMEXTRAS ) || i18n_merge( THEMEXTRAS, "en_US" );

# Require the common file and initialize the plugin
require_once( THEMEXTRASPATH . 'common.php' );
ThemeExtras_init();

# Register this plugin with the system
register_plugin(
    THEMEXTRAS,
    i18n_r(THEMEXTRAS . '/PLUGIN_NAME'),
    THEMEXTRASVERS,
    "John Stray",
    i18n_r(THEMEXTRAS . '/AUTHOR_URL'),
    i18n_r(THEMEXTRAS . '/PLUGIN_DESCRIPTION'),
    'theme',
    'ThemeXtras_main'
);
