/**
 * Created by Lex on 18.07.14.
 */

//var mcImages = {};

var currentWId;

jQuery(document).ready(function(){
    $(document).on('click', '.cb-crop', function(e){
        e.preventDefault();
        var key = $(this).data('key');
        var context = $(this).closest('.mc-widget');
        var wId = context.data('wid');
        mcOptions[wId].currentImage = key;
        $('.mc-modal-crop', context).find('img').attr('src', '');
        $('.mc-modal-crop', context).find('img').attr('src', mcOptions[wId].originalImagePath + mcOptions[wId].originalImage).one('load', function(){
            var originalSize = [this.width, this.height];
            $(this).css({
                maxWidth: jQuery(window).width() - 100,
                maxHeight: jQuery(window).height() - 150
            });
            $('.mc-modal-crop', context).themodal({
                closeOnOverlayClick: false,
                onOpen: function (overlay) {
                    var o = mcOptions[wId].imagesOptions[key];
                    var c = mcImages[wId][mcOptions[wId].currentImage].coords;

                    currentWId = wId;

                    $('.uploader-crop', overlay).Jcrop({
                        trueSize: originalSize,
                        onSelect: setCoords,
                        onChange: setCoords,
                        setSelect: [c.x, c.y, c.w, c.h],
                        minSize: [o.width, o.height],
                        aspectRatio: o.width / o.height
                    });

                }
            }).open();
        });

    });
    $('.mc-save-image').click(function(){
        var wId = $(this).closest('.mc-widget').data('wid');
        var obj = mcImages[wId][mcOptions[wId].currentImage];
        $.ajax({
            type: "POST",
            async: false,
            url: mcOptions[wId].url + '?crop=true',
            data: {
                coords: obj.coords,
                originalImage: mcOptions[wId].originalImage,
                key: mcOptions[wId].currentImage,
                currentImage: obj.file
            },
            success: function(){
                var newImage = mcOptions[wId].imagePath + obj.file + '?' + (new Date()).getTime();
                $('img.cb-key-' + mcOptions[wId].currentImage).attr('src', newImage);
                $('#modal-crop').themodal().close();
                currentWId = null;
            }
        })
    });
});

function setCoords(c){
    $.each(c, function(key, val){
        if(key != 'x2' && key != 'y2'){
            val = Math.round(val);
            mcImages[currentWId][mcOptions[currentWId].currentImage].coords[key] = val;
            $('input[name="' + mcOptions[currentWId].inputName + '[' + mcOptions[currentWId].currentImage + '][coords][' + key + ']"]').val(val);
        }
    });
}

function renderImagesTable(result, wId){

    if(!mcOptions[wId]){
        mcOptions[wId] = {};
    }
    if(mcOptions[wId].editorInitialized){
        setMCDefaults(wId);
    }

    var context = $('.mc-container-' + wId);

    $('.mc-button-title', context).text('Изменить изображение');

    var originalInput = $('<input type="hidden" name="' + mcOptions[wId].inputName + '[original][file]" id="mc-original-image">').val(result.original);
    $('#mc-preview-table', context).after(originalInput);
    mcOptions[wId].originalImage = result.original;

    $.each(result.images, function(key, image){
        var clone = $($('#mc-preview-template tbody', context).html());
        var input = $('<input type="hidden" name="' + mcOptions[wId].inputName + '[' + key + '][file]">').val(image.file);
        clone.find('img').attr('src', mcOptions[wId].imagePath + image.file);
        clone.find('a').each(function(){
            $(this).data('key', key);
        });
        clone.find('img').addClass('cb-key-' + key);
        clone.appendTo($('#mc-preview-table', context));
        clone.find('.mc-size').text(mcOptions[wId].imagesOptions[key].width + "x" + mcOptions[wId].imagesOptions[key].height);
        clone.append(input);
        mcImages[wId][key] = image;
        clone.append(createCoordsInp(image.coords, key, wId));
    });
    mcOptions[wId].editorInitialized = true;
}

function createCoordsInp(coords, key, wId){
    var inp = [];
    $.each(coords, function(ind, val){
        inp.push($('<input>').attr({
            type: 'hidden',
            name: mcOptions[wId].inputName + '[' + key + '][coords][' + ind + ']'
        }).val(val));
    });
    return inp;
}

function setMCDefaults(wId){
    var context = $('.mc-container-' + wId);
    $('#mc-original-image', context).remove();
    $('#mc-preview-table tbody', context).empty();
    mcImages[wId] = {};
}