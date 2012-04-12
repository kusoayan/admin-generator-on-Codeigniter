<table>
    <tr>
        <th width="10%">Weight</th>
<?php foreach ($display_field as $field):?>
        <th width=""><?=$field;?></th>
<?php endforeach;?>
    </tr>
    <?="<?php ";?>foreach($items as $item):?>
        <tr class="rowA">
            <td>0</td>
<?php foreach ($display_field as $field):?>
                <td><?="<?=\$item[\"$field\"];?>";?></td>
<?php endforeach;?>
            <td><a href="<?="<?=\$edit_controller . \$item[\"id\"];?>";?>" title="Edit" class="">Edit</a></td>
            <td><a href="<?="<?=\$del_controller . \$item[\"id\"];?>";?>" title="Del" class="" onClick="return confirm('Confirm Delete?');">Del</a></td>
        </tr>
    <?="<?php ";?>endforeach;?>
</table>
