<?php
    // Outputs singular button
    // Below is PHP destructuring, ONLY DESTRUCTURES $cta NOTHING ELSE
    // [
    //     'text' => $text,
    //     'url' => $url,
    //     'icon' => $icon,
    // ] = $cta;



?>
<a
    href="<?php echo $url; ?>"
    target="<?php echo (externalLink($url) ? '_blank' : '_self'); ?>"
    class="component--cta <?php echo ($icon ? 'has-icon' : ''); ?>"
>
    <span>
        <?php
            echo $text;
            echo ($icon ? '<i class="fa-solid '.$icon.'"></i>' : '');
        ?>
    </span>
</a>