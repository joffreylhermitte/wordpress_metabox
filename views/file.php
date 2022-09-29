<tr>
    <th><label for="<?=$id?>"><?=$label?></label></th>
    <td>
        <a href="#" id="<?=$button?>" class="button button-secondary">
            Upload
        </a>
        <input type="text" name="<?=$name?>" id="<?=$id?>" value="<?=$value?>" />
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
                        type: 'application/pdf'
                    },
                    button: {
                        text: 'Utiliser'
                    },
                    multiple: false
                }).on('select', function () {
                    var attachment = aw_uploader.state().get('selection').first().toJSON();
                    $('#<?=$id?>').val(attachment.url);

                })
                    .open();
        });
    })
</script>