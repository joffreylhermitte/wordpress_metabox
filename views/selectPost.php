<tr>
    <th><label for="<?=$id?>"><?=$label?></label></th>
    <td>
        <select id="<?=$id?>" name="<?=$name?>">
            <option value=""><?=$label?>...</option>
            <?php foreach ($data as $post) :
                echo'<option value="'. $post->post_title.'"  '.selected($post->post_title, $value).'>
                     '.$post->post_title.'
                </option>';
            endforeach;?>
        </select>
    </td>
</tr>