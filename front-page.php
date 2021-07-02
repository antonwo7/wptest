<?php get_header(); ?>
    <div id="primary" class="content-area col-sm-12 col-md-9">

            <main>
                <?php do_action('properties_list', (!empty($_GET['agency_id']) ? $_GET['agency_id'] : '')); ?>
            </main>
    </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>