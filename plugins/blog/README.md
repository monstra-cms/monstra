Blog
================

### Usage

#### Get Post
	<?php echo Blog::getPost(); ?>

#### Get Posts
	<?php echo Blog::getPosts(); ?>

#### Get 5 Posts (could be any amount, 5 or 1 or 25):
	<?php echo Blog::getPosts(5); ?>

#### Get related Posts
	<?php echo Blog::getRelatedPosts(); ?>

#### Get 4 latest posts from Blog
	<?php echo Blog::getPostsBlock(4); ?>

#### Get Tags&Keywords
	<?php Blog::getTags(); ?>

#### Get Tags&Keywords for current page
	<?php Blog::getTags(Page::slug()); ?>

Get Post Title
	<?php echo Blog::getPostTitle(); ?>

### Shortcode for content 

#### Divided post into 2 parts (short and full)
	{cut}

Example:

	<p>Best free themes for Monstra CMS at monstrathemes.com</p>
	{cut}
	<p>There is going to display your content as blog post =)</p>
 