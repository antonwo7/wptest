<section class="section-properties">
    <div class="row flex-wrap">

        <?php foreach($properties as $property) : ?>
            <?php do_action('property_item', $property); ?>
        <?php endforeach; ?>

    </div>
</section>