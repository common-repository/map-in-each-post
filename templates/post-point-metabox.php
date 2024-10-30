<?php
if ( ! defined( 'ABSPATH' ) ) exit;

wp_nonce_field('save_mapineachpost_points', 'mapInEachPost_nonce_field');
$points = !empty($points) ? $points : array();
$enable_points = get_post_meta($post->ID, '_enable_mapineachpost_points', true);

?>
<p>
    <label for="_enable_mapineachpost_points"><?php echo esc_html__('Enable points for this post:', 'map-in-each-post'); ?></label>
    <input type="checkbox" id="_enable_mapineachpost_points" name="_enable_mapineachpost_points" value="1" <?php checked($enable_points, '1'); ?> />
</p>
<div id="points-container" style="<?php echo esc_attr($enable_points ? '' : 'display:none;'); ?>">
    <?php foreach ($points as $index => $point) : ?>
        <table class="point-table">
            <thead>
                <tr>
                    <th colspan="2"><?php echo esc_html__('Point', 'map-in-each-post') . ' ' . esc_html( $index + 1 ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fields as $field_key => $field_type) : ?>
                    <tr>
                        <td>
                            <label for="points[<?php echo esc_attr( $index ); ?>][<?php echo esc_attr( $field_key ); ?>]">
                            <?php echo esc_html( ucfirst( $field_type['label'] ) ); ?>:
                            </label>
                        </td>
                        <td>
                            <?php if ($field_type['type'] == 'textarea') : ?>
                                <textarea name="points[<?php echo esc_attr( $index ); ?>][<?php echo esc_attr( $field_key ); ?>]">
                                    <?php echo esc_html(html_entity_decode($point[$field_key], ENT_QUOTES, 'UTF-8')); ?>
                                </textarea>
                            <?php else : ?>
                                <input type="<?php echo esc_attr($field_type['type']); ?>" 
                                    name="points[<?php echo esc_attr( $index ); ?>][<?php echo esc_attr( $field_key ); ?>]" 
                                    value="<?php echo esc_attr(html_entity_decode($point[$field_key], ENT_QUOTES, 'UTF-8')); ?>" />
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2">
                        <button type="button" class="remove-point"><?php echo esc_html__('Remove point', 'map-in-each-post'); ?></button>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
    <?php endforeach; ?>
</div>
<button type="button" id="add-point" style="<?php echo esc_attr($enable_points ? '' : 'display:none;'); ?>">
    <?php echo esc_html__('Add point', 'map-in-each-post'); ?>
</button>
