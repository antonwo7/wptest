<div class="col-md-6">
    <div class="card property-item">
        <img class="card-img-top" src="<?php echo esc_attr(get_the_post_thumbnail_url($property->ID, [500, 300])); ?>" alt="">
        <div class="card-body">
            <h3 class="card-title"><?php echo esc_attr(get_the_title($property->ID)); ?></h3>
            <p class="card-text"><?php echo esc_attr(get_the_excerpt($property->ID)); ?></p>
        </div>
        <div class="card-footer">
            <?php do_action('property_data', $property); ?>
            <a href="<?php echo esc_url(get_the_permalink($property->ID)); ?>" class="btn btn-primary"><?php echo esc_attr__('More', 'unite-child'); ?></a>
        </div>
    </div>
</div>