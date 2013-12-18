<?php
/*
Plugin Name: Gravatar Header
Plugin URI: https://github.com/necrolyte2/wp_gravatar_header
Description: Changes the get header_image function to return your gravatar image
Version: 1.0
Author: Tyghe Vallard
Author URI: http://www.tygertown.us

    Copyright 2009  Tyghe Vallard  (email : vallardt@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action( 'admin_menu', 'gravatar_id_menu' );

function gravatar_id_menu( )
{
	add_options_page( 'Gravatar Header Image Options', 'Gravatar Header Image', 'administrator', 'gheader', 'gheader_options' );
}

function gheader_options( )
{
	$opt_name = 'email';
	
	//Read in existing email option from database
	$opt_val = get_option( $opt_name );
	$hidden_field_name = 'gheader_submit_hidden';
	$data_field_name = 'gheader_email';

	//See if the user has posted(submitted) information
	if( $_POST[$hidden_field_name] == 'Y' )
	{
		// Get the existing value from the database
		$opt_val = $_POST[$data_field_name];

		//Save the posted value to database
		update_option( $opt_name, $opt_val );

		print '<div class="updated"><p><strong>Option saved.</strong></p></div>';

	}

	// Now display the options editing screen
	echo '<div class="wrap">';

	// header
	echo "<h2>" . __( 'Gravatar Header Image Options', 'mt_trans_domain' ) . "</h2>";

	// options form
    
	print '<form name="form1" method="post" action="">
	<input type="hidden" name="'. $hidden_field_name .'" value="Y">

	<p>
	Enter in the email address linked to the Gravatar image you wish to use
	</p>

	<p><label for="'. $data_field_name .'">Gravatar Email:</label>
	<input type="text" id="'. $data_field_name .'" name="'. $data_field_name .'" value="'. $opt_val .'" size="20">
	</p><hr />

	<p class="submit">
	<input type="submit" name="Submit" value="Submit" />
	</p>

	</form>
	</div>';

}

// Changes the image that header_image returns and turns it into a gravatar image
function change_to_gravatar( $image )
{
	#$email = "vallardt@gmail.com";
	$email = get_option( 'email' );
	$tm = mktime();
	return "'http://www.gravatar.com/avatar.php?gravatar_id=". md5( strtolower($email) ) ."&size=110?antiCache=$tm'";
}

// Change the header image into a gravatar link
add_filter( 'theme_mod_header_image', 'change_to_gravatar' );
?>
