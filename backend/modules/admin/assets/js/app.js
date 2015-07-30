/**
 * Created by shulgin on 16.06.14.
 */
$(document).ready(function(){
    $('#cb-video-status').change(function(){
        if($(this).val() == 2){
            $('#cb-video-publish-time').slideDown(200);
        }
        else{
            $('#cb-video-publish-time').slideUp(200);
        }
    });
    $('#cb-items-per-page').change(function(){
        $(this).closest('form').submit();
    });
    $('.cb-track-changes').trackChanges();
    $('#cb-banner-type').change(function(){
        if($(this).is(':checked')){
            $('#cb-banner-type-0').css({display: "none"});
            $('#cb-banner-type-1').css({display: "block"})
        }
        else{
            $('#cb-banner-type-0').css({display: "block"});
            $('#cb-banner-type-1').css({display: "none"});
        }
    });
});

window.onbeforeunload = function(){
    if($('.cb-track-changes').length != 0 && $('.cb-track-changes').isChanged()){
        return 'Вы уверены что хотите уйти со страницы?';
    }
};

$.fn.extend({
    trackChanges: function() {
        $(":input",this).change(function(e) {
            if($(this).data('plugin-name') != 'timepicker'){
                $(this.form).data("changed", true);
            }
        });
        $(this).submit(function(){
            $(this).data('changed', false);
        });
    },
    isChanged: function() {
        return this.data("changed");
    },
    submitWithFilters: function(){
        var _el = $(this);
        $('thead').find('input, select').each(function(){
            _el.append($('<input type="hidden" />').attr('name', $(this).attr('name')).val($(this).val()))
        });
        _el.submit();
    }
});

String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    return hours+':'+minutes+':'+seconds;
};

function scrollToError(attribute, messages){
    var position;
    $.each(messages, function(key, val){
        var newPosition = $('.field-' + key).offset().top;
        if(position == null || newPosition < position){
            position = newPosition;
        }
    });
    window.errorScroll = true;
    $(window).scrollTop(position - 70);
}