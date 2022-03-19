<td><?php echo $index; ?></td>
<td><a href='<?php echo get_permalink( $post_id );?>' target='_blank'><?php echo get_the_title($post_id);?> (<?php echo $post_id; ?>)</a></td>
<td>
    <ol>
        <?php foreach(explode(',', $updated_list) as $assigned_post_id) : ?>    
        <li><a href='<?php echo get_permalink( $assigned_post_id ); ?>' target='_blank'><?php echo get_the_title($assigned_post_id)?> (<?php echo $assigned_post_id; ?>)</a></li>
        <?php endforeach; ?>
    </ol>
</td>
<td class="center">
    <a href='<?php echo get_edit_post_link($post_id); ?>' target='_blank'>Edit Post</a> | 
    <a target='_blank' data-click="refresh" data-id="<?php echo $post_id; ?>">Refresh List</a> | 
    <a target='_blank' data-click="delete" data-id="<?php echo $post_id; ?>">Delete Mapping</a>
</td>