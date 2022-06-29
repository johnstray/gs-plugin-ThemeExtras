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

class ThemeExtras
{
    var $data_file = GSDATAOTHERPATH . 'themes-config.xml';
    var $current_lang = 'en_US';
    var $current_config = array();
    
    public function __construct()
    {
        GLOBAL $LANG;
        if ( empty($LANG) === false )
        {
            $this->current_lang = (string) $LANG;
        }
        
        if ( defined('THEMEXTRASDATA') )
        {
            $this->data_file = THEMEXTRASDATA;
        }
        
        # Check if the config data file exists, create a new one if not
        if ( file_exists($this->data_file) === false )
        {
            ThemeExtras_debugLog( "Config data file not found. Creating a new one.", 'INFO' );
            $config_xml = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><theme-configs/>');
            if ( XMLsave($config_xml, $this->data_file) === false )
            {
                ThemeExtras_debugLog( "Could not create new config data file. XMLsave (false)", 'ERROR' );
                ThemeExtras_displayMessage( i18n_r(THEMEXTRAS . '/CREATE_CONFIG_FAILED'), 'error', false );
                # Bail out early so we don't try to read this file that couldn't be created,
                # preventing php errors and will cause an empty config array.
                return;
            }
        }
        
        # Check if we can read from the config data file
        if ( is_readable($this->data_file) === false )
        {
            ThemeExtras_debugLog( "Config data file is not readable. is_readable (false)", 'ERROR' );
            ThemeExtras_displayMessage( sprintf(i18n_r(THEMEXTRAS . '/CONFIG_FILE_UNREADABLE'), $this->data_file), 'error', false );
            # Bail out early so we don't try to read this file that is not readable,
            # preventing php errors and will cause an empty config array.
            return;
        }
        
        # Check if we can read from the config data file
        # We wont bail out this time because we can still read in the config. We just wont be able to write to it.
        if ( is_writable($this->data_file) === false )
        {
            ThemeExtras_debugLog( "Config data file is not writable. is_writable (false)", 'WARN' );
            ThemeExtras_displayMessage( sprintf(i18n_r(THEMEXTRAS . '/CONFIG_FILE_NOT_WRITABLE'), $this->data_file), 'warn', false );
        }
        
        $config_xml = getXML( $this->data_file );
        $config_array = json_decode( str_replace('{}', '""', json_encode($config_xml)), true );
        if ( empty($config_array) === false )
        {
            $this->current_config = $config_array['theme'];
        }
        if ( $this->isAssociative($this->current_config) )
        {
            $this->current_config = array( 0 => $this->current_config );
        }
    }
    
    # -----
    # Configuration Settings
    # -----
    
    public function getThemeInfo( string $theme ): array
    {
        $theme_config_file = GSTHEMESPATH . $theme . DIRECTORY_SEPARATOR . 'theme.xml';
        $theme_config_array = array();
        if ( file_exists($theme_config_file) )
        {
            $theme_config_xml = getXML( $theme_config_file );
            $theme_config_array = json_decode(str_replace('{}', '""', json_encode($theme_config_xml)), true);
        }
        
        # We don't need these in this output
        unset($theme_config_array['config']);
        unset($theme_config_array['customfields']);
        
        # Process language options
        foreach ($theme_config_array as $config_key => $config_value)
        {
            if ( is_array($config_value) )
            {
                if ( array_key_exists($this->current_lang, $config_value) )
                {
                    $theme_config_array[$config_key] = $config_value[$this->current_lang];
                }
                else
                {
                    $theme_config_array[$config_key] = $config_value['en_US'];
                }
            }
        }
        
        return $theme_config_array;
    }
    
    /**
     * Has config
     * Checks to see if the current theme has any configuration options and returns an array of the possible options.
     * 
     * @since 1.0.0
     * @param string $theme The name of the theme to check against
     * @return array An array of possible configuration options, empty if not available for current theme
     */
    public function hasConfig( string $theme ): array
    {
        $theme_config_file = GSTHEMESPATH . $theme . DIRECTORY_SEPARATOR . 'theme.xml';
        if ( file_exists($theme_config_file) === false )
        {
            # Theme not supported, bail out and return empty array
            return array();
        }
        
        $theme_config_xml = getXML( $theme_config_file );
        $theme_config_array = json_decode(str_replace('{}', '""', json_encode($theme_config_xml)), true);
        
        # Rebuild array processing language options
        $processed_config_array = array();
        foreach ( $theme_config_array['config'] as $config_id => $config_details )
        {
            foreach ( $config_details as $detail_key => $detail_value )
            {
                var_dump($detail_value);
                if ( is_array($detail_value) && $detail_key !== 'options' )
                {
                    if ( array_key_exists($this->current_lang, $detail_value) )
                    {
                        $processed_config_array[$config_id][$detail_key] = $detail_value[$this->current_lang];
                    }
                    else
                    {
                        $processed_config_array[$config_id][$detail_key] = $detail_value['en_US'];
                    }
                }
                elseif ( $detail_key === 'options' )
                {
                    foreach ( $detail_value as $option_key => $option_value )
                    {
                        if ( is_array($option_value) )
                        {
                            if ( array_key_exists($this->current_lang, $option_value) )
                            {
                                $processed_config_array[$config_id][$detail_key][$option_key] = $option_value[$this->current_lang];
                            }
                            else
                            {
                                $processed_config_array[$config_id][$detail_key][$option_key] = $option_value['en_US'];
                            }
                        }
                        else
                        {
                            $processed_config_array[$config_id][$detail_key][$option_key] = $option_value;
                        }
                    }
                }
                else
                {
                    $processed_config_array[$config_id][$detail_key] = $detail_value;
                }
            }
        }
        
        return $processed_config_array;
    }
    
    /**
     * Get config
     * Returns an array of configuration settings and their current values for the given theme
     * 
     * @since 1.0.0
     * @param string $theme The name of the theme to check against
     * @return array An array of configuration settings, empty if not available for current theme
     */
    public function getConfig( string $theme ): array
    {
        $theme_config = array();
        foreach ( $this->current_config as $theme_data )
        {
            if ( $theme_data['name'] === $theme )
            {
                $theme_config = $theme_data['config'];
            }
        }
        return $theme_config;
    }
    
    /**
     * Save config
     * Saves the submitted configuration settings to the `theme-config.xml` file.
     * 
     * @since 1.0.0
     * @param string $theme The name of the theme config relates to
     * @param array $config An array of config options to save
     * @return bool True if successful, False otherwise
     */
    public function saveConfig( string $theme, array $config ): bool
    {
        # Prepare to build the XML array ready for saving to file
        $config_xml = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><theme-configs/>');

        # Get config options for the given theme
        $config_options = $this->hasConfig( $theme );

        # Loop over the config array until we find the given theme
        # Update the current config if found, then/otherwise prep the XML data
        foreach ( $this->current_config as $theme_id => $theme_data )
        {
            # Update the current config
            if ( $theme_data['name'] === $theme )
            {
                # Loop over the provided config
                foreach ( $config as $key => $value )
                {
                    # Make sure this is a valid config option
                    if ( array_key_exists($key, $config_options) )
                    {
                        # If dropdown, radio, checkbox, make sure given value is an option
                        if ( $config_options[$key]['type'] == 'dropdown' || $config_options[$key]['type'] == 'checkbox' || $config_options[$key]['type'] == 'radio' )
                        {
                            if ( array_key_exists($value, $config_options[$key]['options']) )
                            {
                                $this->current_config[$theme_id]['config'][$key] = $value;
                            }
                            else
                            {
                                # Given value is not an allowable option
                                ThemeExtras_debugLog( __METHOD__, sprintf("Given setting value for %s is not valid. array_key_exists (false)", $key), 'WARN' );
                                ThemeExtras_displayMessage( sprintf(i18n_r(THEMEXTRAS . '/CONFIG_REGEX_FAILED'), $key), 'warn', false );
                            }
                        }
                        else # Validate the value using given regex
                        {
                            if ( array_key_exists('regex', $config_options[$key]) )
                            {
                                // Check the regex, then add to array if ok
                                if ( preg_match($config_options[$key]['regex'], $value) === 1 )
                                {
                                    # Regex check passed, add value to array
                                    $this->current_config[$theme_id]['config'][$key] = $value;
                                }
                                else
                                {
                                    # Regex check failed, drop the value and notify
                                    ThemeExtras_debugLog( __METHOD__, sprintf("Given setting value for %s is not valid. preg_match (0)", $key), 'WARN' );
                                    ThemeExtras_displayMessage( sprintf(i18n_r(THEMEXTRAS . '/CONFIG_REGEX_FAILED'), $key), 'warn', false );
                                }
                            }
                            else
                            {
                                # DANGEROUS! No regex defined, add to array as is
                                // @TODO: Consider replacing this with a basic regex check
                                $this->current_config[$theme_id]['config'][$key] = $value;
                            }
                        }
                    }
                    else
                    {
                        // Not a valid config option, ignore but notify
                        ThemeExtras_debugLog( __METHOD__, sprintf("Given config key %s is not a valid config option. It will be ignored. array_key_exists (false)", $key), 'WARN' );
                    }
                }
            }

            # Add data to the XML array
            $theme_xml = $config_xml->addChild('theme');
            $theme_xml->addChild('name', $theme_data['name']);
            $theme_config = $theme_xml->addChild('config');
            foreach ( $theme_data['config'] as $config_key => $config_value )
            {
                $theme_config->addChild( $config_key, $config_value );
            }
        }

        # Save the XML array to file
        if ( XMLsave($config_xml, $this->data_file) === false )
        {
            ThemeExtras_debugLog( "Could not update the config data file. XMLsave (false)", 'ERROR' );
            ThemeExtras_displayMessage( i18n_r(THEMEXTRAS . '/CONFIG_UPDATE_FAILED'), 'error', false );
            return false;
        }

        return true;
    }
    
    /**
     * Reset config
     * Resets the config for the given theme to it's default settings by clearing out any current config settings
     *
     * @since 1.0.0
     * @param string $theme The name of the theme to reset the config for
     * @return bool True if successful, False otherwise
     */
    public function resetConfig( string $theme ): bool
    {
        # Find the theme we are resetting
        foreach ( $this->current_config as $theme_id => $theme_data )
        {
            if ( $theme_data['name'] === $theme )
            {
                # Clear out current config - Set to empty array
                $this->current_config[$theme_id]['config'] = array();
            }
        }

        # Call saveConfig with empty array should result in the current config being written to file
        return $this->saveConfig( $theme, array() );
    }

    # -----
    # Custom Fields
    # -----
    
    /**
     * Has custom fields
     * Check to see if the current theme has any custom fields options and returns an array of possible options
     * 
     * @since 1.0.0
     * @param string $theme The name of the theme to check against
     * @return array An array of possible custom fields options, empty if not available for the current theme
     */
    public function hasCustomFields( string $theme ): array
    {
        $theme_config_file = GSTHEMESPATH . $theme . DIRECTORY_SEPARATOR . 'theme.xml';
        if ( file_exists($theme_config_file) === false )
        {
            # Theme not supported, bail out and return empty array
            return array();
        }

        $theme_config_xml = getXML( $theme_config_file );
        $theme_config_array = json_decode(str_replace('{}', '""', json_encode($theme_config_xml)), true);

        # Rebuild array processing language options
        $processed_fields_array = array();
        foreach ( $theme_config_array['customfields'] as $field_id => $field_details )
        {
            foreach ( $field_details as $detail_key => $detail_value )
            {
                if ( is_array($detail_value) && $detail_key !== 'options' )
                {
                    if ( array_key_exists($this->current_lang, $detail_value) )
                    {
                        $processed_fields_array[$field_id][$detail_key] = $detail_value[$this->current_lang];
                    }
                    else
                    {
                        $processed_fields_array[$field_id][$detail_key] = $detail_value['en_US'];
                    }
                }
                elseif ( $detail_key === 'options' )
                {
                    foreach ( $detail_value as $option_key => $option_value )
                    {
                        if ( is_array($option_value) )
                        {
                            if ( array_key_exists($this->current_lang, $option_value) )
                            {
                                $processed_fields_array[$field_id][$detail_key][$option_key] = $option_value[$this->current_lang];
                            }
                            else
                            {
                                $processed_fields_array[$field_id][$detail_key][$option_key] = $option_value['en_US'];
                            }
                        }
                        else
                        {
                            $processed_fields_array[$field_id][$detail_key][$option_key] = $option_value;
                        }
                    }
                }
                else
                {
                    $processed_fields_array[$field_id][$detail_key] = $detail_value;
                }
            }
        }

        return $processed_fields_array;
    }
    
    /**
     * Save custom fields
     * Saves the submitted custom fields values to the page's XML file. Called via the 'changedata-save' action hook
     * 
     * @since 1.0.0
     * @param string $theme The name of the theme custom fields relate to
     * @param SimpleXMLExtended $xml The page's XML object to add the fields to
     * @param array $post_data An array of values to save, usually from $_POST
     * @return SimpleXMLExtended The updated page XML object to pass back for saving
     */
    public function saveCustomFields( string $theme, SimpleXMLExtended $xml, array $post_data = [] ): SimpleXMLExtended
    {
        foreach ( $this->hasCustomFields($theme) as $field_key => $field_data )
        {
            if ( isset($post_data[$theme . '-' . $field_key]) )
            {
                // @TODO: Validate the values before adding them to the XML data
                $xml->addChild( $theme . '-' . $field_key, $post_data[$theme . '-' . $field_key] );
            }
        }

        return $xml;
    }
    
    /**
     * Is associative array
     * Checks if the given array is an associative array by looking for array keys with a string type. If array has
     * string type keys, returns true (is associative), returns false otherwise (not associative).
     * 
     * @since 1.0.0
     * @param array $array The array to check
     * @return bool True if associative (has 1+ string keys), false otherwise
     */
    private function isAssociative( array $array ): bool
    {
        foreach ( $array as $key => $value)
        {
            if ( is_string($key) ) return true;
        }
        return false;
    }
}
