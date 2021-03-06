<?php

if (defined('BASEPATH') === false) {
    exit('No direct script access allowed');
}

/*
|--------------------------------------------------------------------------
| Website details
|
| These details are used in emails sent by authentication library.
|--------------------------------------------------------------------------
*/
$config['website_name'] = 'Kids Project';
$config['webmaster_email'] = 'webmaster@your-site.com';


/*
|--------------------------------------------------------------------------
| Registration settings
|
| 'allow_registration' = Registration is enabled or not
| 'captcha_registration' = Registration uses CAPTCHA
| 'email_activation' = Requires user to activate their account using email after registration.
| 'email_activation_expire' = Time before users who don't activate their account getting deleted from database.
|                             Default is 48 hours (60*60*24*2).
| 'email_account_details' = Email with account details is sent after registration (only when 'email_activation' is FALSE).
| 'use_username' = Username is required or not.
|
| 'username_min_length' = Min length of user's username.
| 'username_max_length' = Max length of user's username.
| 'password_min_length' = Min length of user's password.
| 'password_max_length' = Max length of user's password.
|--------------------------------------------------------------------------
*/
$config['allow_registration'] = true;
$config['captcha_registration'] = false;
$config['email_activation'] = false;
$config['email_activation_expire'] = 60*60*24*2;
$config['email_account_details'] = true;
$config['use_username'] = true;

$config['username_min_length'] = 4;
$config['username_max_length'] = 20;
$config['password_min_length'] = 6;
$config['password_max_length'] = 20;

/*
|--------------------------------------------------------------------------
| Login settings
|
| 'login_by_username' = Username can be used to login.
| 'login_by_email' = Email can be used to login.
| You have to set at least one of 2 settings above to TRUE.
| 'login_by_username' makes sense only when 'use_username' is TRUE.
|
|
| 'login_count_attempts' = Count failed login attempts.
| 'login_max_attempts' = Number of failed login attempts before CAPTCHA will be shown.
| 'login_attempt_expire' = Time to live for every attempt to login. Default is 24 hours (60*60*24).
|--------------------------------------------------------------------------
*/

$config['login_by_username'] = true;
$config['login_by_email'] = true;
$config['login_count_attempts'] = true;
$config['login_max_attempts'] = 5;
$config['login_attempt_expire'] = 60*60*24;

/*
|--------------------------------------------------------------------------
| Auto login settings
|
| 'autologin_cookie_name' = Auto login cookie name.
| 'autologin_cookie_life' = Auto login cookie life before expired. Default is 2 months (60*60*24*31*2).
|--------------------------------------------------------------------------
*/
$config['autologin_cookie_name'] = 'autologin';
$config['autologin_cookie_life'] = 60*60*24*31*2;

/*
|--------------------------------------------------------------------------
| Forgot password settings
|
| 'forgot_password_expire' = Time before forgot password key become invalid. Default is 60 minutes (60*60).
|--------------------------------------------------------------------------
*/
$config['forgot_password_expire'] = 3600;

/*
|--------------------------------------------------------------------------
| Captcha
|
| You can set captcha that created by Auth library in here.
| 'captcha_path' = Directory where the catpcha will be created.
| 'captcha_fonts_path' = Font in this directory will be used when creating captcha.
| 'captcha_font_size' = Font size when writing text to captcha. Leave blank for random font size.
| 'captcha_grid' = Show grid in created captcha.
| 'captcha_expire' = Life time of created captcha before expired, default is 3 minutes (180 seconds).
| 'captcha_case_sensitive' = Captcha case sensitive or not.
|--------------------------------------------------------------------------
*/
$config['captcha_path'] = 'captcha/';
$config['captcha_fonts_path'] = 'captcha/fonts/5.ttf';
$config['captcha_width'] = 200;
$config['captcha_height'] = 50;
$config['captcha_font_size'] = 16;
$config['captcha_grid'] = false;
$config['captcha_expire'] = 180;
$config['captcha_case_sensitive'] = false;

/*
|--------------------------------------------------------------------------
| reCAPTCHA
|
| 'use_recaptcha' = Use reCAPTCHA instead of common captcha
| You can get reCAPTCHA keys by registering at http://recaptcha.net
|--------------------------------------------------------------------------
*/
$config['use_recaptcha'] = false;
$config['recaptcha_public_key'] = '';
$config['recaptcha_private_key'] = '';

/*
|--------------------------------------------------------------------------
| Database settings
|
| 'db_table_prefix' = Table prefix that will be prepended to every table name used by the library
| (except 'ci_sessions' table).
|--------------------------------------------------------------------------
*/
$config['db_table_prefix'] = 'xp_';



/*
|--------------------------------------------------------------------------
| File upload settings
|
|--------------------------------------------------------------------------
*/
$config['local_file_base_path'] = 'c:/web_workspace/';
$config['upload_file_path'] = 'uploads/';
$config['upload_file_thumb_path'] = 'uploads/thumb/';
$config['upload_avatar_src_path'] = 'uploads/avatar/src/';
$config['upload_avatar_path'] = 'uploads/avatar/';

$config['upload_project_img_src_path'] = 'uploads/project/src/';
$config['upload_project_img_path'] = 'uploads/project/';



/* End of file xp_config.php */
/* Location: ./application/config/xp_config.php */
