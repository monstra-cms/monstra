Blog
================

### Usage

#### Get Post
	<?php echo Category::getPost(); ?>

#### Get Posts
	<?php echo Category::getPosts(); ?>

#### Get 5 Posts (could be any amount, 5 or 1 or 25):
	<?php echo Category::getPosts(5); ?>

#### Get related Posts
	<?php echo Category::getRelatedPosts(); ?>

#### Get 4 latest posts from Category
	<?php echo Category::getPostsBlock(4); ?>

#### Get Tags&Keywords
	<?php Category::getTags(); ?>

#### Get Tags&Keywords for current page
	<?php Category::getTags(Page::slug()); ?>

Get Post Title
	<?php echo Category::getPostTitle(); ?>

### Shortcode for content 

#### Divided post into 2 parts (short and full)
	{cut}

Example:

	<p>Best free themes for Monstra CMS at monstrathemes.com</p>
	{cut}
	<p>There is going to display your content as category post =)</p>
 