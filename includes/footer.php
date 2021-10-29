	<footer class="footer"></footer>
</div><!-- end of the site container -->
<?php include( 'includes/debug-output.php' ); ?>

<?php if( $logged_in_user ){ ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
	//where a heart button is clicked, trigger the ajax handler
	$('.likes').on( 'click', '.heart-button', function(){
		//which user clicked which post?
		var postId = $(this).data('postid');
		var userId = <?php echo $logged_in_user['user_id']; ?> ;

		console.log( postId, userId );

		var $likesContainer = $(this).parents('.likes');
		$.ajax({
			method	: 'GET',
			url		: 'ajax-handlers/like-unlike.php',
			data	: {
						'userId' : userId,
						'postId' : postId
					  },
			success	: function( response ){
							//update the like interface
							$likesContainer.html(response);
						},
			error	: function(){
							console.log('Ajax Error');
						}
		});
	} );
</script>
<?php } ?>
</body>
</html>