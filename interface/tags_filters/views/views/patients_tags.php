<?php foreach ( $this->tags as $tag ) { ?>
<span style="color: <?php echo $tag->tag_color; ?>"><?php echo $tag->tag_name; ?></span>
<?php } ?>