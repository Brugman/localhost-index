<div class="container">

    <div class="search-bar">

        <input type="text" id="q" autocomplete="off" placeholder="Search">

    </div>

<?php if ( !empty( $projects = get_projects() ) ): ?>

    <ul class="projects">

<?php foreach ( $projects as $project ): ?>

        <li class="project">

            <div class="icon frontend">
                <a href="<?=$project['frontend_url'];?>">
                    <?php display_icon( 'browser-light' ); ?>
                </a>
            </div>

<?php if ( $project['backend_url'] ): ?>
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

<?php if ( is_string( $project['git'] ) ): ?>
            <div class="icon git">
                <a href="<?=$project['git'];?>">
                    <?php display_git_icon( $project['git'] ); ?>
                </a>
            </div>
<?php elseif ( $project['git'] === true ): ?>
            <div class="icon git nolink">
                <?php display_icon( 'git-alt-brands' ); ?>
            </div>
<?php else: ?>
            <div class="icon git nolink">
                <?php display_icon( 'hat-cowboy-light' ); ?>
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

