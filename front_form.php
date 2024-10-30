<?php
$bc_settings = get_option(best_cookie_settings);
$bc_positions_arr = array(
    1 => 'top:0;right:0;width:300px;height:100%;align-content: baseline;transform:translate(100%,0);',
    2 => 'top:0;left:0;width:300px;height:100%;align-content: baseline;transform:translate(-100%,0);',
    3 => 'top:0;left:0;width:100%;height:auto;transform:translate(0,-100%);',
    4 => 'bottom:0;left:0;width:100%;height:auto;transform:translate(0,100%);'
);
?>
<div class="best-cookies <?= $bc_settings['position'] > 2 ? $bc_settings['button_size'] : 'size-cookies'; ?>" style="<?= $bc_positions_arr[$bc_settings['position']]; ?>">
    <span class="best-cookies__close"></span>
    <div class="best-cookies__bg" style="background-color:<?= $bc_settings['color']; ?>"></div>
    <div class="best-cookies__left">
        <?php if ( $bc_settings['title'] ) : ?>
            <h5><?= $bc_settings['title']; ?></h5>
        <?php endif; ?>
        <p><?= $bc_settings['text']; ?></p>
    </div>
    <a class="best-cookies__button <?= $bc_settings['button_size']; ?>" href="javascript:void(0);" style="color:<?= $bc_settings['color']; ?>">
        <?= $bc_settings['button_text']; ?>
    </a>
</div>