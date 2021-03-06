<?php 
if( isset($_POST['did_register']) ){
	//sanitize all fields
	$username = filter_var( $_POST['username'], FILTER_SANITIZE_STRING );
	$email 	  = filter_var( $_POST['email'], 	FILTER_SANITIZE_EMAIL );
	$password = filter_var( $_POST['password'], FILTER_SANITIZE_STRING );

	//boolean checkbox sanitization
	if( isset( $_POST['policy'] ) ){
		$policy = 1;
	}else{
		$policy = 0;
	}

	//validate
	$valid = true;

		//bad length on username
		if( strlen( $username ) < USERNAME_MIN OR strlen( $username ) > USERNAME_MAX ){
			$valid = false;
			$errors['username'] = 'Please chose a username that is ' . 
								   USERNAME_MIN . 
								   '-' . 
								   USERNAME_MAX . 
								   'characters long';

		}else{
			//username already registered
			$result = $DB->prepare('SELECT * 
									FROM users 
									WHERE username = ?
									LIMIT 1');

			$result->execute( array( $username ) );
			//if one row found, the name is already taken
			if( $result->rowCount() >= 1 ){
				$valid = false;
				$errors['username'] = 'Sorry this username is already taken.';
			}
		}

		
		//invalid email
		if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
			$valid = false;
			$errors['email'] = 'Please provide a valid email address.';
		}else{
			//email already registered
			$result = $DB->prepare('SELECT email
									FROM users
									WHERE email = ?');
			$result->execute( array( $email ) );
			//if one row found, the email is in use.
			if( $result->rowCount() >= 1 ){
				$vaild = false;
				$errors['email'] = 'That email is already registered, try logging in.';
			}
		}//end email checks
	
		//password too short
		if( strlen( $password ) > PASSWORD_MIN ){
			$valid = false;
			$errors['password'] = 'Create a strong password that is at least ' . 
								   PASSWORD_MIN . ' characters long.';
		}
		//unchecked policy
		if( ! $policy ){
			$valid = false;
			$errors['policy'] = 'You must agree to our site\'s policies.';
		}

		//if valid, add new user to the DB
		if( $valid ){
			//generate an avatar
			$letter = $username[0];
			$avatar = make_letter_avatar($letter, 60);
			$result = $DB->prepare('INSERT INTO users
									(username, email, password, profile_pic, is_admin)
									VALUES
									(:username, :email, :password, :image, 0)');
			//make a salted, hashed password
			$hashed_pass = password_hash( $password, PASSWORD_DEFAULT );
			$data = array(
					'username' => $username,
					'email' => $email,
					'password' => $hashed_pass,
					'image'	=> $avatar,
					);
			$result->execute( $data );
			//check if one row was added
			if( $result->rowCount() >= 1 ){
				//success
				$feedback = 'Welcome! You can now Log In.';
				$feedback_class = 'success';
			}else{
				//db error
				$feedback = 'Sorry there was a problem creating your account. Try again later.';
				$feedback_class = 'error';
			}
		}else{
			$feedback = 'Your account could not be created. Fix the following:';
			$feedback_class = 'error';
		}


}// end register parser

// no close php