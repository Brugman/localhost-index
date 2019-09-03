<div class="container">

<?php

if ( !empty( $items ) ):

?>

<input type="text" id="q" autocomplete="off" placeholder="Search">

<ul class="projects">
<?php

foreach ( $items as $item ):

?>
<li class="project">

    <div class="link frontend">
        <a href="<?=$item['frontend_url'];?>" target="_blank">
            <?php include 'assets/images/test/browser-light.svg'; ?>
        </a>
    </div>

<?php if ( !empty( $item['backend_url'] ) ): ?>
    <div class="link backend">
        <a href="<?=$item['backend_url'];?>" target="_blank">
            <?=type_icon( $item['type'] );?>
        </a>
    </div>
<?php else: ?>
    <div class="link backend nolink">
        <?=type_icon( $item['type'] );?>
    </div>
<?php endif; ?>

    <div class="name"><?=$item['dir'];?></div>

</li>
<?php

endforeach; // $items

?>
</ul>
<?php

else: // $items is empty

?>
<p>No projects found.</p>
<?php

endif; // $items

?>
</div><!-- container -->

