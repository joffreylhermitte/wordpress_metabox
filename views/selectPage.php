<tr>
    <th><label for="<?=$id?>"><?=$label?></label></th>
    <td>
        <select id="<?=$id?>" name="<?=$name?>">
            <option value=""><?=$label?>...</option>
            <?php foreach ($data as $post) :
                echo'<option value="'. $post->post_name.'"  '.selected($post->post_name, $value).'>
                     '.$post->post_title.'
                </option>';
            endforeach;?>
        </select>
    </td>
</tr>