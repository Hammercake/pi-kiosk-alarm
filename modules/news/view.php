<?php
$first = true;
foreach ($news_feed->articles as $article) {
	?>
<div class="article <?php echo ($first) ? 'active' : ''; ?>">
	<img src="<?php echo $article->urlToImage; ?>" class="image">
	<p class="title"><?php echo $article->title; ?></p>
	<p class="description"><?php echo $article->description; ?></p>
</div>

	<?php
	$first = false;
}
?>
<script>

function changeArticle()
{
	var next = $('.article.active', '#module_<?php echo $this->module_index; ?>').next('.article');
	
	if (next.length == 0) {
		next = $('.article').first();
	}
	
	$('.article.active', '#module_<?php echo $this->module_index; ?>').removeClass('active')
	next.addClass('active');
	
	setTimeout(changeArticle, 1000 * 60);
}
changeArticle();
</script>