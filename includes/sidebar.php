<aside class="sidebar">
	
	<?php //get up to 5 users, newest first
	$result = $DB->prepare('SELECT profile_pic, username
							FROM users
							ORDER BY user_id DESC
							LIMIT 5');
	//run it.
	$result->execute();
	//check it.
	if( $result->rowCount() >= 1 ){
	 ?>
	<section class="users">
		<h3>Newest Users</h3>
		<ul>
			<?php while( $row = $result->fetch() ){ ?>
			<li class="user">
				<img src="<?php echo $row['profile_pic']; ?>" width="50" height="50" />
				<?php echo $row['username']; ?>
			</li>
			<?php } ?>
		</ul>
	</section>
	<?php } ?>


	<?php 
	//get up to 20 categories in alphabetical order by name
	$result = $DB->prepare('SELECT categories.name, COUNT(*) AS total
							FROM posts, categories
							WHERE categories.category_id = posts. category_id
							GROUP BY posts.category_id

							ORDER BY categories.name ASC
							LIMIT 20');
	//run it.
	$result->execute();
	//check it.
	if( $result->rowCount() >= 1 ){
	 ?>
	<section class="categories">
		<h3>Categories</h3>
		<ul>
			<?php while( $row = $result->fetch() ){ ?>
			<li><?php echo $row['name']; ?> - <?php echo $row['total']; ?> posts</li>
			<?php } ?>
		</ul>
	</section>
	<?php } ?>

	<?php 
	//get up to 20 tags in alphabetical order by name
	$result = $DB->prepare('SELECT name
							FROM tags
							ORDER BY tag_id ASC
							LIMIT 20');
	//run it.
	$result->execute();
	//check it.
	if( $result->rowCount() >=1 ){
	 ?>
	<section class="tags">
		<h3>Tags</h3>
		<ul>
			<?php while( $row = $result->fetch() ){ ?>
			<li><?php echo $row['name']; ?> - X posts</li>
			<?php } ?>
		</ul>
	</section>
	<?php } ?>

</aside>