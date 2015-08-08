/**
 * Created by Lex on 18.07.14.
 */

jQuery(document).ready(function(){

    $('#gal-previews tbody').sortable({
        containment: 'parent',
        stop: function(){
            $('#gal-previews tbody tr').each(function(ind){
                $(this).find('input').each(function(){
                    var name = $(this).attr('name');
                    var newName = name.replace(/\[(\d+)\]/, "[" + (ind + 1) + "]");
                    $(this).attr('name', newName)
                });
            });
        }
    });
    $(document).on('click', '.gal-remove-image', function(e){
        e.preventDefault();
        var _el = $(this);
        var data = {image: _el.data('image')};
        var id = _el.data('id');
        if(id){
            data.id = id;
        }
        $.ajax({
            type: "DELETE",
            async: false,
            data: data,
            dataType: "JSON",
            url: galOptions.deleteUrl,
            success: function(response){
                if(response.success){
                    _el.closest('.gal-preview').remove();
                }
                else{
                    alert(response.error);
                }
            }
        });
    });
    $(document).on('click', '.gal-crop', function(e){
        e.preventDefault();
        var key = $(this).data('key');
        var obj = galImages[key];
        galOptions.currentImage = key;
        $('.gal-modal-crop').find('img').attr('src', '');
        $('.gal-modal-crop').find('img').attr('src', galOptions.imagePath + obj.original).one('load', function(){
            var originalSize = [this.width, this.height];
            $(this).css({
                maxWidth: jQuery(window).width() - 100,
                maxHeight: jQuery(window).height() - 150
            });
            jQuery('.gal-modal-crop').themodal({
                closeOnOverlayClick: false,
                onOpen: function (overlay) {
                    var c = obj.coords;

                    jQuery('.uploader-crop', overlay).Jcrop({
                        trueSize: originalSize,
                        onSelect: setGalCoords,
                        onChange: setGalCoords,
                        setSelect: [c.x, c.y, c.w, c.h],
                        minSize: [galOptions.width, galOptions.height],
                        aspectRatio: galOptions.width / galOptions.height
                    });
                }
            }).open();
        });

    });

    $('.gal-save-image').click(function(){
        var obj = galImages[galOptions.currentImage];
        $.ajax({
            type: "POST",
            async: false,
            url: galOptions.url + '?crop=true',
            dataType: "JSON",
            data: {
                coords: obj.coords,
                originalImage: obj.original,
                key: galOptions.currentImage,
                currentImage: obj.image,
                isNewRecord: galOptions.isNewRecord
            },
            success: function(response){
                var newImage = galOptions.imagePath + response.image + '?' + (new Date()).getTime();
                obj.image = response.image;
                $('input[name="' + galOptions.inputName + '[' + galOptions.currentImage + '][image]"]').val(response.image);
                $('img.gal-image-' + galOptions.currentImage).attr('src', newImage);
                $('.gal-modal-crop').themodal().close();
            }
        })
    });

});

function setGalCoords(c){
    $.each(c, function(key, val){
        if(key != 'x2' && key != 'y2'){
            val = Math.round(val);
            galImages[galOptions.currentImage].coords[key] = val;
            $('input[name="' + galOptions.inputName + '[' + galOptions.currentImage + '][coords][' + key + ']"]').val(val);
        }
    });
}

function renderPreview(result){

    var clone = $($('#gal-preview-template tbody').html());
    var ind = ++galOptions.totalImages;
    var input = $('<input type="hidden" name="' + galOptions.inputName + '[' + ind + '][image]">').val(result.image);
    var input2 = $('<input type="hidden" name="' + galOptions.inputName + '[' + ind + '][original]">').val(result.original);

    clone.find('img').addClass('gal-image-' + ind).attr('src', galOptions.imagePath + result.image);

    clone.find('.gal-alt').attr('name', galOptions.inputName + '[' + ind + '][alt]');
    clone.find('.gal-title').attr('name', galOptions.inputName + '[' + ind + '][title]');
    clone.find('.gal-caption').attr('name', galOptions.inputName + '[' + ind + '][caption]');

    $.each(result.coords, function(key, val){
        var input = $('<input type="hidden" name="' + galOptions.inputName + '[' + ind + '][coords][' + key + ']">').val(val);
        clone.append(input);
    });

    clone.appendTo('#gal-previews');

    clone.find('a').each(function(){
        $(this).data('image', result.image);
        $(this).data('key', ind);
    });

    clone.append(input, input2);

    galImages[ind] = result;

}

