<table class="wp-mapping-list">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Post Name</th>
            <th>Assigned Post Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if( count( self::$list ) > 0 ) :
                foreach( self::$list as $index => $list ) :
        ?>
                <tr>
                    <td><?= ($index+1) ?></td>
                    <td><a href='<?=get_permalink( $list->wl_post_id )?>' target='_blank'><?=get_the_title($list->wl_post_id)?> (<?=$list->wl_post_id?>)</a></td>
                    <td>
                        <ol>
                            <?php foreach(explode(',', $list->wl_assigned_post_id) as $assigned_post_id) : ?>    
                            <li><a href='<?=get_permalink( $assigned_post_id )?>' target='_blank'><?=get_the_title($assigned_post_id)?> (<?=$assigned_post_id?>)</a></li>
                            <?php endforeach; ?>
                        </ol>
                    </td>
                    <td class="center">
                        <a href='<?=get_edit_post_link($list->wl_post_id)?>' target='_blank'>Edit Post</a> | 
                        <a target='_blank' data-click="refresh" data-id="<?=$list->wl_post_id?>">Refresh List</a> | 
                        <a target='_blank' data-click="delete" data-id="<?=$list->wl_post_id?>">Delete Mapping</a>
                    </td>
                </tr>
        <?php
                endforeach;
            endif;
        ?>
    </tbody>
</table>