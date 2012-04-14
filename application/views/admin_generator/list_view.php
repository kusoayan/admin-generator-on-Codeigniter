<table>
    <tr>
<?php foreach ($display_field as $field):?>
        <th width="30%"><?=$field;?></th>
<?php endforeach;?>
        <th width="10%">Edit</th>
        <th width="10%">Delete</th>
    </tr>
    <?="<?php ";?>if (v($items)):
            foreach($items as $item):?>
        <tr class="rowA">
<?php foreach ($display_field as $field):?>
                <td><?="<?=\$item[\"$field\"];?>";?></td>
<?php endforeach;?>
            <td><a href="<?="<?=site_url(v(\$edit_controller) . v(\$item[\"id\"]));?>";?>" title="Edit" class="">Edit</a></td>
            <td><a href="<?="<?=site_url(v(\$del_controller) . v(\$item[\"id\"]));?>";?>" title="Del" class="" onClick="return confirm('Confirm Delete?');">Del</a></td>
        </tr>
        <?="<?php ";?>endforeach;?>
    <?="<?php ";?>endif;?>
</table>
