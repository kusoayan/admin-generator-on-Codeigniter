<table>
<?php foreach ($display_field as $field):?>
    <tr>
        <th width="20%"><?=$field;?></th>
        <td width="80%"><input type="text" name="artist_name" value="<?="<?=\$item[\"$field\"];?>";?>"/></th>
    </tr>
<?php endforeach;?>
</table>
