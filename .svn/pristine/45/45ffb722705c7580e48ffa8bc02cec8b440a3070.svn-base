<?php
/*
Plugin Name: Hide Login
Plugin URI: http://www.websoftdownload.com/
Description: This plugin allows you to create custom URLs for user's login, logout and admin's login page.
Author: mohammad hossein aghanabi
Version: 2.1
Author URI: http://www.websoftdownload.com
*/
/*
This is a new version of Stealth Login plguin by skullbit
*/
/* CHANGELOG 
28-07-2012 - v2.1
	* Fix an issue with hide mode capability
29-01-2012 - v2.0
	* Fix .htaccess query coomands
	* Automatic removing and adding htaccess output to .htaccess file
	* Strong security key function
	* Added compatibility fix with WordPress installations in a directory like www.blog.com/wordpress/
	* Added ability to disable plugin from its setting page
	* Added ability to attempt to change .htaccess permissions to make writeable
	* Added wp-admin slug option (can't login with it yet though)
	* htaccess Output rules will always show even if htaccess is not writeable
	* added ability to create custom htaccess rules
	* Added Register slug option so you can still allow registrations with the hide-login. (If registration is not allowed, this option will not be available.)
	* Security Key now seperate for each slug so that those registering cannot reuse the key for use on login or logout
	* Added better rewrite rules for a hidden login system.
	* Removed wp-login.php refresh redirect in favor of using rewrite rules for prevention of direct access to the file.
*/
// include_once(ABSPATH.'wp-admin/admin-functions.php');
if( !class_exists( 'HideLoginPlugin' ) ){
	class HideLoginPlugin{
		function HideLoginPlugin(){ //Constructor			
			add_action( 'admin_menu', array($this,'AddPanel') );
			if( $_POST['action'] == 'hide_login_update' )
				add_action( 'init', array($this,'SaveSettings') );
			add_filter( 'mod_rewrite_rules', array($this, 'AddRewriteRules'), 999 );
			register_activation_hook( __FILE__, array($this, "DefaultSettings") );
			register_deactivation_hook( __FILE__, array($this, "UnsetSettings") );
			
		}
		function AddPanel(){
			add_options_page( 'hide Login', 'Hide Login', 10, __FILE__, array($this, 'HideSettings') );
		}
		function DefaultSettings () {
			 if( !get_option("hide_enable") )
			  	add_option("hide_enable","0");
				
			 if( !get_option("hide_login_slug") )
			  	add_option("hide_login_slug","login");
			
			if( !get_option("hide_admin_slug") )
			  	add_option("hide_admin_slug","admin");
				
			 if( !get_option("hide_login_redirect") )
			  	add_option("hide_login_redirect", get_option('siteurl').'/wp-admin/');
				
			 if( !get_option("hide_logout_slug") )
			  	add_option("hide_logout_slug", "logout");
				
			 if( !get_option("hide_login_custom") )
			  	add_option("hide_login_custom", "");
			 
			 if( !get_option("hide_register_slug") )
			  	add_option("hide_register_slug","register");
			
			 if( !get_option("hide_mode") )
			  	add_option("hide_mode", "0");
			
			 if( get_option("hide_key") )
			 	delete_option("hide_key");
		}
		function UnsetSettings () {
			  delete_option("hide_enable");
			  delete_option("hide_login_slug");
			  delete_option("hide_login_redirect");
			  delete_option("hide_logout_slug");
			  delete_option("hide_admin_slug");
			  delete_option("hide_login_custom");
			  delete_option("hide_register_slug");
			  delete_option("hide_mode");
			  delete_option("hide_htaccess");
			  delete_option("hide_custom_rules");
			  delete_option("hide_htaccess");
		}
		function SaveSettings(){			
			check_admin_referer('Hide-login-update-options');
			update_option("hide_enable", $_POST['hide_enable']);
			update_option("hide_login_slug", $_POST['hide_login_slug']);
			update_option("hide_login_redirect", $_POST['hide_login_redirect']);
			update_option("hide_logout_slug", $_POST['hide_logout_slug']);
			update_option("hide_admin_slug", $_POST['hide_admin_slug']);
			update_option("hide_login_custom", $_POST['hide_login_custom']);
			update_option("hide_register_slug", $_POST['hide_register_slug']);
			update_option("hide_custom_rules", $_POST['hide_custom_rules']);
			update_option("hide_mode", $_POST['hide_mode']);
			$htaccess = trailingslashit(ABSPATH).'.htaccess';
			$new_rules = $this->CreateRewriteRules();
			if( $_POST['hide_enable'] == 0 ):
					if(file_exists($htaccess) && preg_match("/(.*?)# HIDE-LOGIN(.*?)# END HIDE-LOGIN(.*?)/s",@file_get_contents($htaccess),$part)):
						$file = fopen($htaccess,'w');
						$content = $part[1].$part[3];
						fwrite($file,$content);
						fclose($file);
					endif;
				$_POST['notice'] = __('Settings saved. Plugin is disabled.','hidelogin');
			elseif( get_option('hide_enable') && isset($_POST['Submit']) ):
					if(preg_match("/(.*?)# HIDE-LOGIN(.*?)# END HIDE-LOGIN(.*?)/s",@file_get_contents($htaccess),$part)):
						$file = fopen($htaccess,'w');
						$content = $part[1].$new_rules.$part[3];
						$content = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $content);
						fwrite($file,$content);
						fclose($file);
					else:
						$file = fopen($htaccess,'a');
						fwrite($file,$new_rules);
						fclose($file);
					endif;
				$_POST['notice'] = __('Settings saved and .htaccess file updated.','hidelogin');
			else :
				$_POST['notice'] = __('Settings saved but .htaccess file is not writeable.'.$htaccess,'hidelogin');
			endif;	
		}	
		
		function hideSettings(){
			
			if( $_POST['notice'] )
				echo '<div id="message" class="updated fade"><p><strong>' . $_POST['notice'] . '</strong></p></div>';
			?>
            <div class="wrap" style="font-family: tahoma !important;">
            	<h2><?php _e('Hide Login Settings', 'hidelogin')?></h2>
                <form method="post" action="">
                	<?php if( function_exists( 'wp_nonce_field' )) wp_nonce_field( 'Hide-login-update-options'); ?>
                    <table class="form-table">
                        <tbody>
                        	<tr valign="top">
                       			 <th scope="row"><label for="enable"><?php _e('Enable Plugin', 'hidelogin');?></label></th>
                        		<td><label><input name="hide_enable" id="enable" value="1" <?php if(get_option('hide_enable') == 1) echo 'checked="checked"';?> type="radio" /> On</label> &nbsp;&nbsp;<label><input name="hide_enable" value="0" <?php if(get_option('hide_enable') == 0) echo 'checked="checked"';?> type="radio" /> Off</label></td>
                        	</tr>
                            <tr valign="top">
                       			 <th scope="row"><label for="login_slug"><?php _e('Login Slug', 'hidelogin');?></label></th>
                        		<td><input name="hide_login_slug" id="login_slug" value="<?php echo get_option('hide_login_slug');?>" type="text"><br />
                                <strong style="color:#777;font-size:12px;">Login URL:</strong> <span style="font-size:0.9em;color:#999999;"><?php echo trailingslashit( get_option('siteurl') ); ?><span style="background-color: #fffbcc;"><?php echo get_option('hide_login_slug');?></span></span></td>
                        	</tr>
                            <tr valign="top">
                            	<th scope="row"><label for="login_redirect"><?php _e('Login Redirect', 'hidelogin');?></label></th> 
                                <td><select name="hide_login_redirect" id="login_redirect">
                                		<option value="<?php echo get_option('siteurl');?>/wp-admin/" <?php if(get_option('hide_login_redirect') == get_option('siteurl').'/wp-admin/'){echo 'selected="selected"';} ?>">WordPress Admin</option>
                                		<option value="<?php echo get_option('siteurl');?>/wp-login.php?redirect_to=<?php echo get_option('siteurl');?>" <?php if(get_option('hide_login_redirect') == get_option('siteurl').'/wp-login.php?redirect_to='.get_option('siteurl')){echo 'selected="selected"';} ?>">WordPress Address</option>
										<option value="<?php echo get_option('siteurl');?>/wp-login.php?redirect_to=<?php echo get_option('home');?>" <?php if(get_option('hide_login_redirect') == get_option('siteurl').'/wp-login.php?redirect_to='.get_option('home')){echo 'selected="selected"';} ?>">Blog Address </option>
										<option value="Custom" <?php if(get_option('hide_login_redirect') == "Custom"){echo 'selected="selected"';} ?>">Custom URL (Enter Below)</option>
                                	</select><br />
								<input type="text" name="login_custom" size="40" value="<?php echo get_option('hide_login_custom');?>" /><br />
								<strong style="color:#777;font-size:12px;">Redirect URL:</strong> <span style="font-size:0.9em;color:#999999;"><?php if( get_option('hide_login_redirect') != 'Custom' ) { echo get_option('hide_login_redirect'); } else { echo get_option('hide_login_custom'); } ?></span></td>
                            </tr>
                            <tr valign="top">
                            	<th scope="row"><label for="logout_slug"><?php _e('Logout Slug', 'hidelogin');?></label></th>
                                <td><input type="text" name="hide_logout_slug" id="logout_slug" value="<?php echo get_option('hide_logout_slug');?>" /><br />
                                <strong style="color:#777;font-size:12px;">Logout URL:</strong> <span style="font-size:0.9em;color:#999999;"><?php echo trailingslashit( get_option('siteurl') ); ?><span style="background-color: #fffbcc;"><?php echo get_option('hide_logout_slug');?></span></span></td>
                            </tr>
                         <?php if( get_option('users_can_register') ){ ?>
                            <tr valign="top">
                            	<th scope="row"><label for="register_slug"><?php _e('Register Slug', 'hidelogin');?></label></th>
                                <td><input type="text" name="hide_register_slug" id="register_slug" value="<?php echo get_option('hide_register_slug');?>" /><br />
                                <strong style="color:#777;font-size:12px;">Register URL:</strong> <span style="font-size:0.9em;color:#999999;"><?php echo trailingslashit( get_option('siteurl') ); ?><span style="background-color: #fffbcc;"><?php echo get_option('hide_register_slug');?></span></span></td>
                            </tr>
                          <?php } ?>
                          <tr valign="top">
                       			 <th scope="row"><label for="admin_slug"><?php _e('Admin Slug', 'hidelogin');?></label></th>
                        		<td><input name="hide_admin_slug" id="admin_slug" value="<?php echo get_option('hide_admin_slug');?>" type="text"><br />
                                <strong style="color:#777;font-size:12px;">Admin URL:</strong> <span style="font-size:0.9em;color:#999999;"><?php echo trailingslashit( get_option('siteurl') ); ?><span style="background-color: #fffbcc;"><?php echo get_option('hide_admin_slug');?></span></span></td>
                        	</tr>
                          <tr valign="top">
                            	<th scope="row"><label for="custom_rules"><?php _e('Custom Rules', 'hidelogin');?></label></th>
                                <td><textarea name="hide_custom_rules" id="custom_rules" rows="5" cols="50"><?php echo get_option('hide_custom_rules');?></textarea><br /><span style="font-size:0.9em;color:#999999;">Add at your own risk, will added to the rules.</span></td>
                            </tr>
                            <tr valign="top">
                            	<th scope="row"><?php _e('hide Mode', 'hidelogin'); ?></th>
                                <td><label><input type="radio" name="hide_mode" value="1" <?php if(get_option('hide_mode') ) echo 'checked="checked" ';?> /> Enable</label><br />
                                	<label><input type="radio" name="hide_mode" value="0" <?php if(!get_option('hide_mode') ) echo 'checked="checked" ';?>/> Disable</label><br />
                                    <small><?php _e('Prevent users from being able to access wp-login.php directly','hidelogin');?></small></td>
                            </tr>
                            <tr valign="top">
                            <th scope="row"><?php _e('.htaccess Output', 'hidelogin');?></th>
                            <td style="color: navy;"><pre><?php echo ((get_option('hide_enable'))?get_option('hide_htaccess'):"<span style=\"color: red !important;\">No Output.  [Plugin is disable]</span>");?></pre></td>
                            </tr>
                    	</tbody>
                 	</table>
                    <p class="submit"><input name="Submit" value="<?php _e('Save Changes','hidelogin');?>" type="submit" />
                    <input name="action" value="hide_login_update" type="hidden" />
                </form>
              
            </div>
           <?php
		}
		
		function CreateRewriteRules(){
			$logout_uri = str_replace(trailingslashit(get_option('siteurl')), '', wp_logout_url());
			$siteurl = explode('/',trailingslashit(get_option('siteurl')));
			unset($siteurl[0]); unset($siteurl[1]); unset($siteurl[2]);
			$dir = implode('/',$siteurl);
			
			if(get_option('hide_login_slug')){
			
				if(get_option('hide_login_redirect') != "Custom"){
					$login_url = get_option('hide_login_redirect');
				}else{
					$login_url = get_option('hide_login_custom');
				}
				$login_slug = get_option('hide_login_slug');
				$logout_slug = get_option('hide_logout_slug');
				$admin_slug = get_option('hide_admin_slug');
				$login_key = $this->Key();
				$logout_key = $this->Key();
				$register_key = $this->Key();
				$admin_key = $this->Key();
				if( get_option('users_can_register') ){
					$register_slug = get_option( 'hide_register_slug' );
					$reg_rule_hide = "RewriteRule ^" . $register_slug . " ".$dir."wp-login.php?hide_reg_key=" . $register_key . "&action=register [R,L]\n" ;//Redirect Register slug to registration page with hide_key
					$reg_rule = "RewriteRule ^" . $register_slug . " ".$dir."wp-login.php?action=register [L]\n" ;//Redirect Register slug to registration page
				}
				if( get_option( 'hide_mode' ) ){
					$insert = "\n# HIDE-LOGIN\n" .
							  "RewriteEngine On\n".
							  "RewriteBase /\n".
							  "RewriteRule ^" . $logout_slug . " ".$dir.$logout_uri."&hide_out_key=" . $logout_key . " [L]\n" . //Redirect Logout slug to logout with hide_key
							  "RewriteRule ^" . $login_slug . " ".$dir."wp-login.php?hide_in_key=" . $login_key . "&redirect_to=" . $login_url . " [R,L]\n" . 	//Redirect Login slug to show wp-login.php with hide_key
							  "RewriteRule ^" . $admin_slug . " ".$dir."wp-admin/?hide_admin_key=" . $admin_key . " [R,L]\n" . 	//Redirect Admin slug to show Dashboard with hide_key
							  $reg_rule_hide .
							  "RewriteCond %{HTTP_REFERER} !^" . get_option('siteurl') . "/wp-admin\n" . //if did not come from WP Admin
							  "RewriteCond %{HTTP_REFERER} !^" . get_option('siteurl') . "/wp-login\.php\n" . //if did not come from wp-login.php
							  "RewriteCond %{HTTP_REFERER} !^" . get_option('siteurl') . "/" . $login_slug . "\n" . //if did not come from Login slug
							  "RewriteCond %{HTTP_REFERER} !^" . get_option('siteurl') . "/" . $admin_slug . "\n" . //if did not come from Admin slug
							  "RewriteCond %{QUERY_STRING} !^hide_in_key=" . $login_key . "\n" . //if no hide_key query
							  "RewriteCond %{QUERY_STRING} !^hide_out_key=" . $logout_key . "\n" . //if no hide_key query
							  "RewriteCond %{QUERY_STRING} !^hide_reg_key=" . $register_key . "\n" . //if no hide_key query
							  "RewriteCond %{QUERY_STRING} !^hide_admin_key=" . $admin_key . " \n" . //if no hide_key query
							  "RewriteRule ^wp-login\.php " . get_option('siteurl') . " [L]\n" . //Send to home page
							  "RewriteCond %{QUERY_STRING} ^loggedout=true \n" . // if logout confirm query is true
							  "RewriteRule ^wp-login\.php " . get_option('siteurl') . " [L]\n" . //Send to home page
							  ((get_option('hide_custom_rules'))?get_option('hide_custom_rules')."\n":"").
							  "RewriteCond %{REQUEST_FILENAME} !-f\n".
							  "RewriteCond %{REQUEST_FILENAME} !-d\n".
							  "RewriteRule . /index.php [L]\n".
							  "# END HIDE-LOGIN\n";
				}else{
					$insert = "\n# HIDE-LOGIN\n" .
							  "RewriteEngine On\n".
							  "RewriteBase /\n".
							  "RewriteRule ^" . $logout_slug . " ".$dir.$logout_uri." [L]\n" . //Redirect Logout slug to logout
							  "RewriteRule ^" . $admin_slug . " ".$dir."wp-admin/ [R,L]\n" . 	//Redirect Admin slug to show Dashboard with hide_key
							  "RewriteRule ^" . $login_slug . " ".$dir."wp-login.php?&redirect_to=" . $login_url . " [R,L]\n" . 	//Redirect Login slug to show wp-login.php
							  $reg_rule .
							  ((get_option('hide_custom_rules'))?get_option('hide_custom_rules')."\n":"").
							  "RewriteCond %{REQUEST_FILENAME} !-f\n".
							  "RewriteCond %{REQUEST_FILENAME} !-d\n".
							  "RewriteRule . /index.php [L]\n".
							  "# END HIDE-LOGIN\n" ;
				}
			}
			$sample = str_replace(array('<','>'),array('&lt;','&gt;'), $insert);
			update_option('hide_htaccess', $sample);
			
			return $insert;
		}
		
		function AddRewriteRules($rewrite){
			global $wp_version;
			
			if( get_option('hide_enable') == 1 ):
				$insert = $this->CreateRewriteRules();
				$lines = explode('RewriteCond %{REQUEST_FILENAME} !-f', $rewrite);
				$fn = "RewriteCond %{REQUEST_FILENAME} !-f";
				$rewrite = $lines[0] . $insert . $fn . $lines[1];
			endif;
		
			return $rewrite;
		}	
		
		function Key() {
			$chars = array('0'=>"abcdefghijklmnopqrstuvwxyz",'1'=>"0123456789",'2'=>"ABCDEFGHIJKLMNOPQRSTUVWXYZ");
			for($i=0;$i<10;$i++): srand((double)microtime()*1000000); @$key.= $chars[rand(0,3)][rand(0, strlen($chars[rand(0,3)]))]; endfor;
			return $key;	
		}
		
	}
} // END Class HideLoginPlugin
if( class_exists( 'HideLoginPlugin' ) ){
	$hidelogin = new HideLoginPlugin();
}?>