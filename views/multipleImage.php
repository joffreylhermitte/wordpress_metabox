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
                        type: 'image'
                    },
                    button: {
                        text: 'Utiliser'
                    },
                    multiple: true
                }).on('select', function () {
                    let selection = aw_uploader.state().get('selection');
                    let data = '';
                    selection.map(function (att){
                        att = att.toJSON()
                        data += att.url+','
                    })
                    $('#<?=$id?>').val(data);

                })
                    .open();
        });
    })
</script>