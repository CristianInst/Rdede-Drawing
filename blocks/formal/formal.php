<?php
    $content = get_field('content');
    $links = get_field('links') ?: array();

    $contentCol = count($links) > 0 ? 8 : 12;
?>
<section id='<?php echo $block['id']; ?>' class='block--formal'>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-<?php echo $contentCol; ?>">
                <?php echo $content; ?>
            </div>
            <?php if(count($links) > 0): ?>
                <div class="col-3 d-none d-md-block offset-1">
                    <ul class="links">
                    <?php foreach($links as $link): ?>
                        <li><a href="<?php echo $link['url']; ?>" rel="noopener"><?php echo $link['text']; ?></a></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>