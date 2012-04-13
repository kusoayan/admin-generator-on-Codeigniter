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
            <td><a href="<?="<?=site_url(v(\$edit_controller) . v(\$item[\"id\"]));?>";?>" title="Edit" class="">Edit</a></td>
            <td><a href="<?="<?=site_url(v(\$del_controller) . v(\$item[\"id\"]));?>";?>" title="Del" class="" onClick="return confirm('Confirm Delete?');">Del</a></td>
        </tr>
    <?="<?php ";?>endforeach;?>
</table>
