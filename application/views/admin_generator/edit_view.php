<form action="<?="<?=site_url(v(\$edit_controller) . v(\$item[\"id\"]));?>";?>" method="post" accept-charset="utf-8">
    <table>
<?php foreach ($display_field as $field):?>
        <tr>
            <th width="20%"><?=$field;?></th>
            <td width="80%"><input type="text" name="<?=$field;?>" value="<?="<?=v(\$item[\"$field\"]);?>";?>"/></th>
        </tr>
<?php endforeach;?>
    </table>
    <p><input type="submit" name="submit" value="Submit"></p>
</form>
