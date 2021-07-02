<?php if($property_data) : ?>
    <table class="table table-striped table-bordered table-hover property-table">
        <tbody>
        <?php foreach ($property_data as $slug => $field) : ?>
            <tr>
                <td>
                    <b><?php echo esc_attr($field['label']); ?></b>
                </td>
                <td><?php echo esc_attr($field['value']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
