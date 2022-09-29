<tr>
    <th><label for="<?=$id?>"><?=$label?></label></th>
    <td>
        <select id="<?=$id?>" name="<?=$name?>">
            <option value=""><?=$label?>...</option>
            <?php foreach ($options as $slug => $text) :?>
                <option value="<?=$slug?>" <?php selected($text, $value)?>>
                     <?=$text?>
                </option>
            <?php endforeach;?>
        </select>
    </td>
</tr>