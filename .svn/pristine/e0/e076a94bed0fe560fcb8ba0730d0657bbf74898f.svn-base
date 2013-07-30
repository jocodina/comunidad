<?php
    $wp_options = $this->load_options();
    $is_title_active = (intval($wp_options['title']) === 1);
    $is_media_active = (intval($wp_options['media']) === 1);
?>
<div class="wrap">
    <div id="icon-plugins" class="icon32 <?php echo $this->textdomain; ?>"><br /></div>
    <h2><?php $this->_e('Strings Sanitizer'); ?></h2>
    <p><?php $this->_e('<p>By default, post titles and media filenames are automatically sanitized. If you wish to change this behavior, you can do so below.</p>'); ?></p>
    <form method="post" name="zeform">
        <input type="hidden" name="action" value="<?php echo $this->textdomain; ?>-update" />
        <?php wp_nonce_field('update'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php $this->_e('Sanitize titles'); ?></th>
                <td>
                    <fieldset>
                        <label for="title"><input name="title" type="checkbox" id="title" value="1" <?php if ($is_title_active): ?>checked="checked"<?php endif; ?> />&nbsp;<em><small><?php if ($is_title_active): ?><?php $this->_e('Click to deactivate'); ?><?php else: ?><?php _e('Click to activate', $this->textdomain); ?><?php endif; ?></small></em></label>
                    </fieldset>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php $this->_e('Sanitize media filenames'); ?></th>
                <td>
                    <fieldset>
                        <label for="media"><input name="media" type="checkbox" id="media" value="1" <?php if ($is_media_active): ?>checked="checked"<?php endif; ?> />&nbsp;<em><small><?php if ($is_media_active): ?><?php $this->_e('Click to deactivate'); ?><?php else: ?><?php _e('Click to activate', $this->textdomain); ?><?php endif; ?></small></em></label>
                    </fieldset>
                </td>
            </tr>
        </table>
        <p><button class="btn btn-info" type="submit"><i class="icon-refresh">&nbsp;</i><?php $this->_e('Save Changes'); ?></button></p>
    </form>