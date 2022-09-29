<tr>
    <th><label for="<?=$id?>"><?=$label?></label></th>
    <td>
        <?php wp_editor( htmlspecialchars_decode($value), $id,
            $settings = array('textarea_name'=>$name,'textarea_rows'=>10,'tinymce'=>false,'media_buttons'=>false) );?>

    </td>
</tr>