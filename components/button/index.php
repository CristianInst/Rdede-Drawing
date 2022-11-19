<?php
    // Outputs singular button
    // Below is PHP destructuring, ONLY DESTRUCTURES $button NOTHING ELSE
    [
        'text' => $text,
        'url' => $url,
        'style_type' => $style_type,
        'color' => $color,
        'icon' => $fa_icon,
    ] = $button;
?>
<a
    href="<?php echo $url; ?>"
    target="<?php echo (externalLink($url) ? '_blank' : '_self'); ?>"
    class="button <?php echo $style_type.' '.$color.' '.($fa_icon ? 'has-icon' : ''); ?>"
>
    <?php
        echo $text;
        echo ($fa_icon ? '<i class="'.$fa_icon.'"></i>' : '');
    ?>
</a>