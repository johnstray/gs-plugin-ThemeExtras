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

/**
 * Initialize the plugin
 * Sets up default variables, registers actions, filters, styles and scripts with the system, loads in the class files
 * and brings in the frontend function mapping.
 *
 * @since 1.0.0
 * @return void
 */
function ThemeExtras_init(): void
{
    # We need some of the global variables
    GLOBAL $SITEURL, $TEMPLATE;
    
    #Define some required constants
    define( 'THEMEXTRASVERS', '1.0.0' );
    define( 'THEMEXTRASDATA', GSDATAOTHERPATH . 'themes-config.xml' );
    define( 'THEMEXTRASCONF', THEMEXTRASDATA . 'themes-config.xml' );
    
    # Hooks and Filters
    add_action( 'theme-extras', 'ThemeExtras_main' );
    
    # Register / Queue Stylesheets
    register_style( THEMEXTRAS . '_css', $SITEURL . '/plugins/' . THEMEXTRAS . '/admin_styles.css', THEMEXTRASVERS, 'screen' );
    queue_style( THEMEXTRAS . '_css', GSBACK );
    
    # Load in the ThemeExtras Class
    require_once( THEMEXTRASPATH . 'ThemeExtras.class.php' );
}

/**
 * Main - Backend Admin Director
 * Manages and directs what we are doing on the admin backend pages
 * 
 * @since 1.0.0
 * @return void
 */
function ThemeExtras_main(): void
{
    # Instantiate the class so that we can make use of it here
    GLOBAL $TEMPLATE, $SITEURL;
    $ThemeExtras = new ThemeExtras();
    
    if ( isset($_POST['settings']) && $_POST['settings'] == 'submitted' )
    {
        // Configuration submitted, save the config to file
    }
    
    if ( isset($_POST['settings']) && $_POST['settings'] == 'reset-default' )
    {
        // Reset theme to it's default settings
    }
    
    if ( isset($_POST['settings']) && $_POST['settings'] == 'submitted' )
    {
        // Cancel changes, notify user.
    }
    
    $current_theme = $ThemeExtras->getThemeInfo($TEMPLATE);
    $current_hasConfig = $ThemeExtras->hasConfig($TEMPLATE);
    $current_config = $ThemeExtras->getConfig($TEMPLATE);
    require_once( THEMEXTRASPATH . 'backend.inc.php' );
    
    # Insert copyright footer to the bottom of the page
    echo "</div><div class=\"gs_themextras_ui_copyright-text\">ThemeExtras Plugin &copy; 2022 John Stray - Licensed under <a href=\"https://www.gnu.org/licenses/gpl-3.0.en.html\">GNU GPLv3</a>";
    echo "<div>If you like this plugin or have found it useful, please consider a <a href=\"https://paypal.me/JohnStray\">donation</a></div>";
}

/**
 * Display message
 * Function to display a message on the admin backend pages
 *
 * @since 1.0
 * @param string $message The message body to display
 * @param string $type The type of message to display, one of ['info', 'success', 'warn', 'error']
 * @return void
 */
function ThemeExtras_displayMessage( string $message, string $type = 'info', bool $close = true ): void
{
    if ( is_frontend() == false )
    {
        $removeit = (bool) $close ? ".removeit()" : "";
        $type = ucfirst( $type );
        if ( $close == false )
        {
            $message = $message . ' <a href="#" onclick="clearNotify();" style="float:right;">X</a>';
        }
        echo "<script>notify".$type."('".$message."')".$removeit.";</script>";
    }
}

/**
 * Debug Logging
 * Output debugging information to GetSimple's debug log when debugging enabled
 *
 * @since 1.0
 * @param string $message The text of the message to add to the log
 * @param string $type The type of message this is, could be 'ERROR', 'WARN', etc.
 * @return string The formatted message added to the debug log
 */
function ThemeExtras_debugLog( string $method, string $message, string $type = 'INFO' ): string
{
    if ( defined('GSDEBUG') && getDef('GSDEBUG', true) === true )
    {
        $debugMessage = "ThemeExtras Plugin (" . $method . ") [" . $type . "]: " . $message;
        debugLog( $debugMessage );
    }
    return $debugMessage || '';
}