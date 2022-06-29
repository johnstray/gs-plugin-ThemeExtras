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
if ( defined('IN_GS') === false ) { die( 'You cannot load this file directly!' ); } ?>

<?php if ( empty($customFields) !== true ) { # Only proceed if the current theme is supported by this plugin ?>

<div class="gs_themextras_ui_form">
    <h4><?php echo sprintf("%s Theme Custom Fields", $TEMPLATE); ?></h4>

    <?php $config_count = 0; foreach ( $customFields as $field_id => $field_details ) { ?>

        <div class="<?php echo (++$config_count%2 ? "leftsec" : "rightsec"); ?>">
            <label for="<?php echo $field_id; ?>"><?php echo $field_details['label']; ?></label>
            <span class="hint"><?php echo $field_details['hint']; ?></span>

            <?php switch ($field_details['type']) {
                case 'dropdown': ?>
                    <select class="text" name="<?php echo $field_id; ?>">
                        <?php foreach( $field_details['options'] as $option_key => $option_value ) {
                            if ($option_key == (string) @$data_edit->{$TEMPLATE.'-'.$field_id}) { $selected = true; }
                            elseif (isset($data_edit->{$TEMPLATE.'-'.$field_id}) === false && $option_key == @$field_details['default']) { $selected = true; }
                            else { $selected = false; } ?>
                            <option value="<?php echo $option_key; ?>" <?php echo ($selected ? 'selected': '') ?>>
                                <?php echo $option_value; ?>
                            </option>
                        <?php } ?>
                    </select>
                <?php break; case 'radio': ?>
                    <div class="radio-group">
                        <?php foreach( $field_details['options'] as $option_key => $option_value ) {
                            if ($option_key == (string) @$data_edit->{$TEMPLATE.'-'.$field_id}) { $selected = true; }
                            elseif (isset($data_edit->{$TEMPLATE.'-'.$field_id}) === false && $option_key == @$field_details['default']) { $selected = true; }
                            else { $selected = false; } ?>
                            <span class="radio">
                                <input type="radio" name="<?php echo $TEMPLATE.'-'.$field_id; ?>" value="<?php echo $option_key; ?>" <?php echo ($selected ? 'checked': '') ?> />
                                <?php echo $option_value; ?>
                            </span>
                        <?php } ?>
                    </div>
                <?php break; case 'checkbox': ?>
                    <div class="checkbox-group">
                        <?php $checkbox_options = explode(',', (string) @$data_edit->{$TEMPLATE.'-'.$field_id});
                        $default_options = explode(',', @$field_details['default']);
                        foreach( @$field_details['options'] as $option_key => $option_value ) {
                            $selected = false;
                            if ( count($checkbox_options) > 0 && && empty($checkbox_options[0]) === false ) {
                                if (in_array($option_key, $checkbox_options)) { $selected = true; }
                            } else {
                                if (in_array($option_key, $default_options)) { $selected = true; }
                            } ?>
                            <span class="checkbox">
                                <input type="checkbox" name="<?php echo $TEMPLATE.'-'.$field_id; ?>[]" value="<?php echo $option_key; ?>" <?php echo ($selected ? 'checked': '') ?> />
                                <?php echo $option_value; ?>
                            </span>
                        <?php } ?>
                    </div>
                <?php break; case 'number': ?>
                    <input class="text" type="number" name="<?php echo $TEMPLATE.'-'.$field_id; ?>" autocorrect="off"
                        <?php if (isset($field_details['pattern'])) { ?>pattern="<?php echo $field_details['pattern']; ?>" <?php } ?>
                        placeholder="<?php echo i18n_r(THEMEXTRAS . '/DEFAULT') . ' '.@($field_details['default'] ?: ''); ?>"
                        value="<?php echo (string) @$data_edit->{$TEMPLATE.'-'.$field_id} ?: ''; ?>" />
                <?php break; case 'tel': ?>
                    <input class="text" type="tel" name="<?php echo $TEMPLATE.'-'.$field_id; ?>" autocorrect="off"
                        <?php if (isset($field_details['pattern'])) { ?>pattern="<?php echo $field_details['pattern']; ?>" <?php } ?>
                        placeholder="<?php echo i18n_r(THEMEXTRAS . '/DEFAULT') . ' '.@($field_details['default'] ?: ''); ?>"
                        value="<?php echo (string) @$data_edit->{$TEMPLATE.'-'.$field_id} ?: ''; ?>" />
                <?php break; case 'url': ?>
                    <input class="text" type="url" name="<?php echo $TEMPLATE.'-'.$field_id; ?>" spellcheck="false" autocorrect="off"
                        <?php if (isset($field_details['pattern'])) { ?>pattern="<?php echo $field_details['pattern']; ?>" <?php } ?>
                        placeholder="<?php echo i18n_r(THEMEXTRAS . '/DEFAULT') . ' '.@($field_details['default'] ?: ''); ?>"
                        value="<?php echo (string) @$data_edit->{$TEMPLATE.'-'.$field_id} ?: ''; ?>" />
                <?php break; case 'color': ?>
                    <input class="text" type="color" name="<?php echo $TEMPLATE.'-'.$field_id; ?>" pattern="#\d{6}"
                        placeholder="<?php echo i18n_r(THEMEXTRAS . '/DEFAULT') . ' '.@($field_details['default'] ?: ''); ?>"
                        value="<?php echo (string) @$data_edit->{$TEMPLATE.'-'.$field_id} ?: '' ?>" />
                <?php break; case 'date': ?>
                    <input class="text" type="date" name="<?php echo $TEMPLATE.'-'.$field_id; ?>" pattern="\d{4}-\d{2}-\d{2}"
                        placeholder="<?php echo i18n_r(THEMEXTRAS . '/DEFAULT') . ' '.@($field_details['default'] ?: ''); ?>"
                        value="<?php echo (string) @$data_edit->{$TEMPLATE.'-'.$field_id} ?: ''; ?>" />
                <?php break; default: ?>
                    <input class="text" type="text" name="<?php echo $TEMPLATE.'-'.$field_id; ?>"
                        placeholder="<?php echo i18n_r(THEMEXTRAS . '/DEFAULT') . ' '.@($field_details['default'] ?: ''); ?>"
                        value="<?php echo (string) @$data_edit->{$TEMPLATE.'-'.$field_id} ?: ''; ?>" />
            <?php } ?>

        </div>

    <?php } ?>
    <div class="clear"></div>
</div>

<?php } ?>