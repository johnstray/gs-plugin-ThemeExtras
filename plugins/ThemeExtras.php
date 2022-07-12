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
    THEMEXTRAS,                                     // Plugin Identifier
    i18n_r(THEMEXTRAS . '/PLUGIN_NAME'),            // Plugin Name
    THEMEXTRASVERS,                                 // Plugin Version
    "John Stray",                                   // Author's Name
    i18n_r(THEMEXTRAS . '/AUTHOR_URL'),             // Author URL
    i18n_r(THEMEXTRAS . '/PLUGIN_DESCRIPTION'),     // Plugin Description
    'theme',                                        // Where the backend pages sit
    'ThemeXtras_main'                               // Main backend controller function
);

# -----
# Front-end Functions
# -----

/**
 * Get page custom field
 * Gets the value of the given custom field for the given page
 *
 * @since 1.0.0
 * @param string $field The custom field to get the value for
 * @param string $page (Optional) The page to get the custom field value from, default is the current page
 * @param bool $echo (Optional) If true will echo the value to the page, default is true
 * @return string The value of the custom field
 */
function get_page_custom_field( string $field, string $page = '', bool $echo = true ): string
{
    GLOBAL $TEMPLATE;

    # If page is not given (empty), set it to the current page's slug
    if ( empty($page) ) { $page = get_page_slug(false); }

    # Get the XML data for the given page
    $page_xml = getXML( GSDATAPAGESPATH . $page . '.xml' );

    if ( isset($page_xml->{$TEMPLATE . '-' . $field}) )
    {
        return (string) $page_xml->{$TEMPLATE . '-' . $field};
    }

    return '';
}

/**
 * Get theme config
 * Gets the current configuration settings of the given theme. Uses current theme as the default
 *
 * @since 1.0.0
 * @param string $theme (Optional) The theme to get the configuration for, default is the current theme
 * @return array An array containing the currently configured settings of the given theme
 */
function get_theme_config( string $theme = '' ): array
{
    # If theme is not given (empty), set it to the current theme
    if ( empty($theme) ) { GLOBAL $TEMPLATE; $theme = (string) $TEMPLATE; }

    # Instansiate the core class so that we can use it here
    if ( class_exists('ThemeExtras') )
    {
        $ThemeExtras = new ThemeExtras();
    }
    else
    {
        ThemeExtras_displayMessage( i18n_r(THEMEXTRAS . '/CLASS_NOT_FOUND'), 'warn', false );
        ThemeExtras_debugLog( __FUNCTION__, "ThemeExtras core class file not loaded! Something has gone wrong.", 'FATAL' );
        return array();
    }

    # Get the config from the class and return it
    return $ThemeExtras->getConfig( $theme );
}
