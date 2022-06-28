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

$i18n = array(
    
    'PLUGIN_NAME'               => "Theme Extras",
    'PLUGIN_DESCRIPTION'        => "Allows themes to provide extra functionality and configuration options to enable " .
                                   "more advanced theming and control of themes.",
    'AUTHOR_URL'                => "https://johnstray.com/gs-plugin/ThemeExtras/",
    
    'UI_SETTINGS_PAGE_TITLE'    => "Theme Configuration",
    'UI_SETTINGS_PAGE_INTRO'    => "This theme can be configured using the below configuration settings. Some of these " .
                                   "may influence how the theme shows things. Each setting below has its own default " .
                                   "value, and you also have the option to reset all.",
    'SETTINGS_UPDATED'          => "Theme configuration successfully updated!",
    'SETTINGS_UPDATE_FAILED'    => "Theme configuration could not be updated.",
    'SETTINGS_UPDATE_CANCELED'  => "Theme configuration update was cancelled. Your changes have not been saved.",
    'SETTINGS_RESET_OK'         => "Theme configuration successfully reset to default settings!",
    'SETTINGS_RESET_FAILED'     => "Theme configuration could not be reset to default settings.",
    
    'AUTHOR'                    => "Author:",
    'AUTHORS_WEBSITE'           => "Link to author&apos;s website",
    'DEFAULT'                   => "Default:",
    'CANCEL_CHANGES'            => "Cancel changes",
    'RESET_TO_DEFAULT'          => "Reset to Default",
    
    'CONFIG_CREATE_FAILED'      => "Could not create a new themes config data file. Check that the /data/other path " .
                                   "is writeable.",
    'CONFIG_UPDATE_FAILED'      => "Could not update the config data file. Check that the /data/other/themes-config.xml " .
                                   "file is writeable.",
    'CONFIG_FILE_UNREADABLE'    => "Could not read from the themes config data file. Please make sure that the file " .
                                   "<code>%s</code> has read permissions set.",
    'CONFIG_FILE_NOT_WRITABLE'  => "The themes config data file is not writable, changes to settings cannot be saved. " .
                                   "Please make sure that the file %s has write permissions set.",
    'CONFIG_REGEX_FAILED'       => "The value given for '%s' is not valid. Check and try again. It's value has not been " .
                                   "saved to the theme configuration.",
    
);
