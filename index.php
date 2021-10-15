<?php 
require('CONFIG.php');
require_once('includes/functions.php');
require('includes/header.php');
 ?>
	<main class="content">
		<?php //1. Write it. get all published posts, newest first
		$result = $DB->prepare('SELECT posts.post_id, posts.image, posts.title,
									   posts.body, posts.date, users.username,
									   users.profile_pic, categories.name
								FROM posts, users, categories
								WHERE posts.is_published = 1
								AND users.user_id = posts.user_id
								AND categories.category_id = posts.category_id
								ORDER BY posts.date DESC');
		//2. Run it.
		$result->execute();
		//3. Check it. did we find any posts?
		if( $result->rowCount() >= 1 ){ 
			//loop it - once per row
			while( $row = $result->fetch() ){
		 ?>
		<div class="one-post">
			<img src="<?php echo $row['image']; ?>">

			<span class="author">
				<img src="<?php echo $row['profile_pic']; ?>" width="50" height="50" />
				<?php echo $row['username']; ?>
			</span>

			<h2><?php echo $row['title']; ?></h2>
			<p><?php echo $row['body']; ?></p>

			<span class="category"><?php echo $row['name']; ?></span>

			<span class="date"><?php echo time_ago( $row['date']); ?></span>

			<span class="comment-count"><?php count_comments( $row['post_id'] ); ?></span>
		</div>

		<?php 
		} //end while loop.
			}else{ ?>

		<div class="feedback">
			<h2>Sorry</h2>
			<p>No posts found. Try a search instead.</p>
		</div>

		<?php } //end of if posts found.?>

	</main>
<?php 
require('includes/sidebar.php');
require('includes/footer.php');
 ?>