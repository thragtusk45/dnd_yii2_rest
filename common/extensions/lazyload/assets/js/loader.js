/**
 * Created by Lex on 15.07.14.
 */

window.llOptions = {};

$(document).ready(function(){
    $(document).on('click', '.ll-load-more', function(e){
        e.preventDefault();
        var _el = $(this);
        var id = $(this).data('id');
        var options;
        if((options = window.llOptions[id]) && !_el.hasClass('cb-disabled')){

            _el.addClass('cb-disabled');

            _el.prev().addClass('active');

            delete_null_properties(window.llOptions[id], true);
            var requestParams = {loader: {currentPage: options.currentPage}};
            if(options.urlData){
                requestParams.data = options.urlData;
            }
            if(options.orderBy){
                requestParams.loader.orderBy = options.orderBy;
            }
            if(options.skip){
                requestParams.loader.skip = options.skip;
            }
            if(options.viewOptions){
                requestParams.viewOptions = options.viewOptions;
            }

            requestParams.page = options.page;

            $.get(_el.attr('href'), requestParams, function(response){

                var $container = $(options.container);
                _el.removeClass('cb-disabled');

                _el.prev().removeClass('active');

                options.total -= options.perPage;

                _el.data('current-page', ++options.currentPage);

                $(response).each(function(){
                    if(this.nodeType != 3){
                        var _el = $(this);
                        if($container.data('masonry')){
                            $container.append(_el).imagesLoaded(function() {
                                $container.masonry('appended', _el);
                                _el.fadeIn(200);
                            });
                        }
                        else{
                            $container.append(_el);
                            _el.fadeIn(200);
                        }
                        _el.find('.rating_bl').each(function(){
                            $(this).find('select').barrating({showSelectedRating:false, readonly:true});
                        });
                        $(this).find('.icon_svg').svgInject();
                    }
                });

                if(options.total <= 0){
                    _el.parent().next('hr').remove();
                    _el.parent().remove();
                }

            });
        }
    });
});

function delete_null_properties(obj, recursive) {
    for (var i in obj) {
        if (obj[i] === null) {
            delete obj[i];
        } else if (recursive && typeof obj[i] === 'object') {
            delete_null_properties(obj[i], recursive);
        }
    }
}