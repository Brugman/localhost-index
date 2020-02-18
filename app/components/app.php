<div class="container">

<?php if ( !empty( $projects = get_projects() ) ): ?>

    <div class="search-bar">

        <input type="text" id="q" autocomplete="off" placeholder="Search">

    </div>

    <ul class="projects">

<?php foreach ( $projects as $project ): ?>

        <li class="project">

            <div class="icon frontend">
                <a href="<?=$project['frontend_url'];?>">
                    <?php display_icon( 'browser-light' ); ?>
                </a>
            </div>

<?php if ( !empty( $project['backend_url'] ) ): ?>
            <div class="icon backend">
                <a href="<?=$project['backend_url'];?>">
                    <?php display_project_type_icon( $project['type'] ); ?>
                </a>
            </div>
<?php else: ?>
            <div class="icon backend nolink">
                <?php display_project_type_icon( $project['type'] ); ?>
            </div>
<?php endif; ?>

<?php if ( !empty( $project['git'] ) ): ?>
            <div class="icon git">
                <a href="<?=$project['git'];?>">
                    <?php display_icon( 'git-alt-brands' ); ?>
                </a>
            </div>
<?php else: ?>
            <div class="icon git nolink">
                <?php display_icon( 'git-alt-brands' ); ?>
            </div>
<?php endif; ?>

            <div class="name"><?=$project['dir'];?></div>

        </li>

<?php endforeach; // $projects ?>

    </ul>

<?php else: // $projects is empty ?>

    <p>No projects found.</p>

<?php endif; // $projects ?>

</div><!-- container -->

