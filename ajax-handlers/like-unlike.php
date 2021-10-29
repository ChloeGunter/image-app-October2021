<?php 

/**
 * AJAX handler file for adding or removing likes
 * This file stays behind_the_scenes on the server
 * It updates the DB with the new like info and then passes back an updated interface
 */
//load assets
require('../CONFIG.php');
require_once('../includes/functions.php');

//incoming data from AJAX call. sanitize and validate.
$post_id = filter_var( $_REQUEST['postId'], FILTER_SANITIZE_NUMBER_INT );
$user_id = filter_var( $_REQUEST['userId'], FILTER_SANITIZE_NUMBER_INT );

//does that user alreadylike tat post?
$result = $DB->prepare('SELECT * FROM likes
						WHERE user_id = :user_id
						AND post_id = :post_id
						LIMIT 1');
$result->execute( array(
					'post_id' => $post_id,
					'user_id' => $user_id
				) );
if( $result->rowCount() >= 1 ){
	//they like it allready. DELETE the row.
	$query = 'DELETE FROM likes
			  WHERE user_id = :user_id
			  AND post_id = :post_id';
}else{
	//they don't like it yet. INSERT the row.
	$query = 'INSERT INTO likes
			  (user_id, post_id)
			  VALUES
			  (:user_id,:post_id)';
}
//run whichevery query
$result = $DB->prepare($query);
$result->execute( array(
					'user_id' => $user_id,
					'post_id' => $post_id
					) );
//if it worked, update the like interface
if( $result->rowCount() >= 1 ){
	like_interface( $post_id, $user_id );
}else{
	// TODO: remove this after testing
	echo 'like-unlike.php failed';
}




//no close php