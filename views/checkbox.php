
<tr>
    <th><label for="<?=$id?>"><?=$label?></label></th>
    <td>
        <?php if($value === $valueCheckbox) $checked = "checked";?>
        <input <?=$checked?> type="checkbox" name="<?=$name?>" id="<?=$id?>" value="<?= esc_attr($valueCheckbox)?>">
    </td>

</tr>
