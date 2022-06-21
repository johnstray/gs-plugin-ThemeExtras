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

 ?>

<div class="gs_themextras_ui_themeinfo">
    <div class="leftsec">
        <div class="gs_themextras_ui_screenshot">
            <?php if ( /*file_exists(GSTHEMESPATH . $TEMPLATE . '/images/screenshot.png')*/ false ) { ?>
                <img src="../<?php echo str_replace(GSROOTPATH,'',GSTHEMESPATH).$TEMPLATE; ?>/images/screenshot.png" alt="<?php i18n('THEME_SCREENSHOT'); ?>" />
            <?php } else { ?>
                <p class="notify_info"><?php i18n('NO_THEME_SCREENSHOT'); ?></p>
            <?php } ?>
        </div>
    </div>
    <div class="rightsec">
        <div class="gs_themextras_ui_details">
            <h4>
                <?php echo (isset($current_theme['name']) ? $current_theme['name']: 'Unknown Theme'); ?>
                <small>v<?php echo (isset($current_theme['version']) ? $current_theme['version'] : '0.0.0'); ?></small>
            </h4>
            <p>
                <strong><?php i18n(THEMEXTRAS . '/AUTHOR'); ?></strong>
                <a href="<?php echo (isset($current_theme['author-url']) ? $current_theme['author-url'] : '#'); ?>" title="<?php i18n(THEMEXTRAS . '/AUTHORS_WEBSITE'); ?>">
                    <?php echo (isset($current_theme['author']) ? $current_theme['author'] : 'Unknown Author'); ?>
                </a>
            </p>
            <p><?php echo (isset($current_theme['description']) ? $current_theme['description'] : ''); ?></p>
        </div>
    </div>
    <div class="clear"></div>
</div>

<?php if ( empty($current_hasConfig) !== true ) { # Only proceed if the current theme is supported by this plugin ?>

<form class="largeform gs_themextras_ui_form" id="edit" action="theme.php?settings=submitted" method="post">

    <h3><?php i18n(THEMEXTRAS . '/UI_SETTINGS_PAGE_TITLE'); ?></h3>
    
    <?php $config_count = 0; foreach ( $current_hasConfig as $config_id => $config_details ) { ?>
        <div class="<?php echo (++$config_count%2 ? "leftsec" : "rightsec"); ?>">
            <label for="<?php echo $config_id; ?>"><?php echo $config_details['label']; ?></label>
            <span class="hint"><?php echo $config_details['hint']; ?></span>
            
            <?php switch ($config_details['type']) {
                case 'dropdown': ?>
                    <select class="text" name="<?php echo $config_id; ?>">
                        <?php foreach( $config_details['options'] as $option_key => $option_value ) {
                            if ($option_key == @$current_config[$config_id]) { $selected = true; }
                            elseif ($option_key == @$config_details['default']) { $selected = true; }
                            else { $selected = false; } ?>
                            <option value="<?php echo $option_key; ?>" <?php echo ($selected ? 'selected': '') ?>>
                                <?php echo $option_value; ?>
                            </option>
                        <?php } ?>
                    </select>
                <?php break; case 'radio': ?>
                    <div class="radio-group">
                        <?php foreach( $config_details['options'] as $option_key => $option_value ) {
                            if ($option_key == @$current_config[$config_id]) { $selected = true; }
                            elseif ($option_key == @$config_details['default']) { $selected = true; }
                            else { $selected = false; } ?>
                            <span class="radio">
                                <input type="radio" name="<?php echo $config_id; ?>" value="<?php echo $option_key; ?>" <?php echo ($selected ? 'checked': '') ?> />
                                <?php echo $option_value; ?>
                            </span>
                        <?php } ?>
                    </div>
                <?php break; case 'checkbox': ?>
                    <div class="checkbox-group">
                        <?php foreach( $config_details['options'] as $option_key => $option_value ) {
                            if ($option_key == @$current_config[$config_id]) { $selected = true; }
                            elseif ($option_key == @$config_details['default']) { $selected = true; }
                            else { $selected = false; } ?>
                            <span class="checkbox">
                                <input type="checkbox" name="<?php echo $config_id; ?>[]" value="<?php echo $option_key; ?>" <?php echo ($selected ? 'checked': '') ?> />
                                <?php echo $option_value; ?>
                            </span>
                        <?php } ?>
                    </div>
                <?php break; case 'number': ?>
                    <input class="text" type="number" name="<?php echo $config_id; ?>" autocorrect="off"
                        <?php if (isset($config_details['pattern'])) { ?>pattern="<?php echo $config_details['pattern']; ?>" <?php } ?>
                        placeholder="<?php echo i18n_r(THEMEXTRAS . '/DEFAULT') . ' '.@($config_details['default'] ?: ''); ?>"
                        value="" />
                <?php break; case 'tel': ?>
                    <input class="text" type="tel" name="<?php echo $config_id; ?>" autocorrect="off"
                        <?php if (isset($config_details['pattern'])) { ?>pattern="<?php echo $config_details['pattern']; ?>" <?php } ?>
                        placeholder="<?php echo i18n_r(THEMEXTRAS . '/DEFAULT') . ' '.@($config_details['default'] ?: ''); ?>"
                        value="" />
                <?php break; case 'url': ?>
                    <input class="text" type="url" name="<?php echo $config_id; ?>" spellcheck="false" autocorrect="off"
                        <?php if (isset($config_details['pattern'])) { ?>pattern="<?php echo $config_details['pattern']; ?>" <?php } ?>
                        placeholder="<?php echo i18n_r(THEMEXTRAS . '/DEFAULT') . ' '.@($config_details['default'] ?: ''); ?>"
                        value="" />
                <?php break; case 'color': ?>
                    <input class="text" type="color" name="<?php echo $config_id; ?>" pattern="#\d{6}"
                        placeholder="<?php echo i18n_r(THEMEXTRAS . '/DEFAULT') . ' '.@($config_details['default'] ?: ''); ?>"
                        value="" />
                <?php break; case 'date': ?>
                    <input class="text" type="date" name="<?php echo $config_id; ?>" pattern="\d{4}-\d{2}-\d{2}"
                        placeholder="<?php echo i18n_r(THEMEXTRAS . '/DEFAULT') . ' '.@($config_details['default'] ?: ''); ?>"
                        value="" />
                <?php break; default: ?>
                    <input class="text" type="text" name="<?php echo $config_id; ?>"
                        placeholder="<?php echo i18n_r(THEMEXTRAS . '/DEFAULT') . ' '.@($config_details['default'] ?: ''); ?>"
                        value="" />
            <?php } ?>
            
        </div>
    <?php } ?>
    
    <div class="clear"></div>
    
    <hr class="gs_themextras_ui_hline" />

    <div id="submit_line" style="text-align:center;">

		<span><input id="page_submit" class="submit" type="submit" name="submitted" value="<?php i18n('BTN_SAVESETTINGS'); ?>" /></span>

		<div id="dropdown">
			<h6 class="dropdownaction"><?php i18n('ADDITIONAL_ACTIONS'); ?></h6>
			<ul class="dropdownmenu">
				<li><a href="theme.php?settings=cancel" ><?php i18n(SBLOG . '/CANCEL_CHANGES'); ?></a></li>
				<li class="alertme"><a href="theme.php?settings=reset-default" ><?php i18n(SBLOG . '/RESET_TO_DEFAULT'); ?></a></li>
			</ul>
		</div>

	</div>
    
</form>

<?php } ?>

<div id="testing" style="margin-top:40px;padding:20px;border:1px dotted #777;"><pre><code><?php
GLOBAL $LANG;
var_dump($current_hasConfig);
var_dump($current_config);

?></code></pre></div>