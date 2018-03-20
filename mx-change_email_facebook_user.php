<?php
/**
* @package changeEmailForFacebookUser
*/

/*
Plugin Name: Change email for facebook user
Plugin URI: https://github.com/Maxim-us/Change-email-for-facebook-user
Description: Plugin for BuddyPress. If a user enters a website using the facebook API, the user can change the password and email address.
Author: Marko Maksym
Version: 1.0
Author URI: https://github.com/Maxim-us
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class changeEmailForFacebookUser
{

	public function activate()
	{
		// rewrite rules
		flush_rewrite_rules();
	}

	public function deactivate()
	{
		// rewrite rules
		flush_rewrite_rules();
	}

	public function uninstall()
	{
		// rewrite rules
		flush_rewrite_rules();
	}

	// Hook. Activated point in user profile
	public function hookBeforeMainFormProfileUser()
	{

		add_action( 'bp_before_member_settings_template', array( $this, 'mx_change_email_for_facebook' ), 10  );

	}

	/****************************
	* Performance of the function
	****************************/
	public function mx_change_email_for_facebook(){

		if( get_user_meta( get_current_user_id() )['facebook_avatar_thumb'] !== NULL ){

			// Get meta user
			$user_email = get_userdata( get_current_user_id() )->user_email;
			
			if( $this->is_execute_function( $user_email ) ){

				// Display a new form
				$this->displayForm();

				// $_POST
				$this->postFunction();

			}

		}

	}

	/*****************
	* Elements
	*****************/
	// $_POST
	public function postFunction()
	{

		if( !empty( $_POST ) ){

			// Update user password
			wp_set_password( $_POST['user_password'], $_POST['user_id'] );

			// Update user's email address
			$args = array(

			    'ID'         => $_POST['user_id'],
			    'user_email' => esc_attr( $_POST['user_email'] )

			);

			wp_update_user( $args );

			// Refresh page
			echo "<script>";

			echo "alert( 'Ваш новый пароль: " . $_POST['user_password'] . " Ваш E-mail: " . $_POST['user_email'] . "' );";

			echo "window.location.href = '/';";
			
			echo "</script>";

		}

	}

	// Display a form
	public function displayForm()
	{ ?>

		<h2>Создайте пароль и добавьте свой электронный адрес.</h2>

		<div id="message" class="info">
			<p>Электронный адрес должен быть настоящим, на него будут отправляться уведомления с сайта. <br /> Указав свой E-mail, Вы также сможете восстановить утраченный пароль.</p>
		</div>

		<div id="message" class="error">
			<p class="mx-info">Обратите внимание, что письма, могут приходить в спам.</p>
		</div>

		<link rel="stylesheet" href="<?php echo plugins_url( '/css/style.css?v=2.0', __FILE__ ); ?>">

        <form method="post" class="standard-form" id="mx_change_email_for_facebook">

        	<input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>">
			
			<label for="mx_password">Введите пароль</label>
			<input type="password" placeholder="Пароль" name="user_password" id="mx_password" required>


			<label for="mx_confirm_password">Введите пароль еще раз</label>
    		<input type="password" placeholder="Подтвердите пароль" id="mx_confirm_password" required>

    		<label for="mx_email">Введите електронную почту</label>
    		<input type="email" placeholder="E-mail" name="user_email" id="mx_email" required>

    		<div class="submit">
				<input type="submit" id="mx_submit_new_pass" value="Сохранить изменения">
    		</div>

        </form>

        <script src="<?php echo plugins_url( '/js/script.js?v=1.0', __FILE__ ); ?>"></script>

    <? }

    // Find the extract @unknown.com
    public function is_execute_function( $user_email )
    {

    	$is_change_email = false;

    	if( preg_match( '/@(unknown.com)/', $user_email, $arr ) ){

    		$is_change_email = true;

    	}

    	return $is_change_email;

    }

}

// Initialize
if ( class_exists( 'changeEmailForFacebookUser' ) ) {

	$newClass = new changeEmailForFacebookUser();

	$newClass->hookBeforeMainFormProfileUser();

}

// Activation
register_activation_hook( __FILE__, array( 'changeEmailForFacebookUser', 'activate' ) );

// Deactivation
register_deactivation_hook( __FILE__, array( 'changeEmailForFacebookUser', 'deactivate' ) );

// Uninstall
register_uninstall_hook( __FILE__, array( 'changeEmailForFacebookUser', 'uninstall' ) );