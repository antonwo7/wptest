<ul class="list-group">
    <?php foreach($agencies as $agency) : ?>
        <li class="list-group-item"><a href="<?php echo esc_url(Agency::get_agency_url($agency->ID)); ?>"><?php echo esc_attr(get_the_title($agency->ID)); ?></a></li>
    <?php endforeach; ?>
</ul>