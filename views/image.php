<tr>
    <th><label for="<?=$id?>"><?=$label?></label></th>
    <td>
        <a href="#" id="<?=$button?>" class="button button-secondary">
            Upload
        </a>
        <input type="hidden" name="<?=$name?>" id="<?=$id?>" value="<?=$value?>" />
        <?php if($value !== ''):?>
            <img id="current_picture_<?=$name?>" src="<?=wp_get_attachment_url($value)?>" width="200" height="auto">
        <?php endif;?>
    </td>


</tr>

<script>
    jQuery(function($) {
        $('#<?=$button?>').click(function (e) {
            e.preventDefault();

            var button = $(this),
                aw_uploader = wp.media({
                    title: 'Custom image',
                    library: {
                        type: 'image'
                    },
                    button: {
                        text: 'Utiliser'
                    },
                    multiple: false
                }).on('select', function () {
                    var attachment = aw_uploader.state().get('selection').first().toJSON();
                    $('#<?=$id?>').val(attachment.id);
                    let current = document.getElementById('current_picture_<?=$name?>');
                    if(current !== null){
                        current.remove();
                    }
                    let img2 = '<img src="'+attachment.url+'" width="200" height="auto"/>';
                    document.getElementById('<?=$id?>').insertAdjacentHTML('afterend',img2);

                })
                    .open();
        });
    })
</script>