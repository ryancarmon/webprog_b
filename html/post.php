
<section id="post<?php echo $pid; ?>" class="post bg">
  <figure>
	<img width="40" height="40" src="img/<?php echo $img; ?>" alt="<?php echo $user; ?>">
	<figcaption>
	  <h5><?php echo $user; ?></h5>
	  <?php echo $time ?>
    </figcaption>
  </figure>
  <article>
	<?php echo $text; ?>
  </article>
  <section class="postinfo">
	<?php echo $likestring; ?>
  </section>
</section>
