<td><?= $index ?></td>
<td><a href='<?=get_permalink( $post_id )?>' target='_blank'><?=get_the_title($post_id)?> (<?=$post_id?>)</a></td>
<td>
    <ol>
        <?php foreach(explode(',', $updated_list) as $assigned_post_id) : ?>    
        <li><a href='<?=get_permalink( $assigned_post_id )?>' target='_blank'><?=get_the_title($assigned_post_id)?> (<?=$assigned_post_id?>)</a></li>
        <?php endforeach; ?>
    </ol>
</td>
<td class="center">
    <a href='<?=get_edit_post_link($post_id)?>' target='_blank'>Edit Post</a>&nbsp;
    <a target='_blank' data-click="refresh" data-id="<?=$post_id?>">Refresh List</a>
</td>