<tr id="list_<?=$number?>">
    <th><?=$label?></th>
    <td>
        <a href="#" id="add_<?=$number?>" class="button button-secondary">
            Ajouter
        </a>

    </td>

</tr>
<?php

if(count($value) > 0):
    foreach ($value as $key=>$item):
        ?>
        <tr>
            <th>
                <label for="<?=$label?>_<?=$key?>"><?=$label?> <?=$key+1?></label>
            </th>
            <td>
                <input type="text" name="<?=$name?>_<?=$key+1?>" id="<?=$name?>_<?=$key+1?>" value="<?=$item?>">
            </td>
        </tr>
    <?php endforeach;?>
<?php endif; ?>

<script>
    jQuery(function($) {
        let count = <?php echo $value === "" ? 0 : count($value)?>

            $("#add_<?=$number?>").click(function (){
                count += 1;
                let newLine = '<tr><th><label for="<?=$name?>_'+count+'"><?=$label?> '+count+'</label></th><td><input type="text" name="<?=$name?>_'+count+'" id="<?=$name?>_'+count+'"></td></tr>';
                $("#list_<?=$number?>").after(newLine);
            })
    })
</script>