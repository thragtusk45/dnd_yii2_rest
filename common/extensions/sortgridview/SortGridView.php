<?php
namespace common\extensions\sortgridview;

use yii\grid\GridView;

/**
 * Text helper
 */
class SortGridView extends GridView
{

    public function run()
    {
        $id = $this->options['id'];
        $view = $this->getView();
        SortGridViewAsset::register($view);
        $view->registerJs("jQuery('#$id tbody tr td').each(function(el){
            \$(this).css({width: \$(this).width()});
        });
        jQuery('#$id tbody').sortable({
            containment: 'document',
            helper: function(e, tr) {
                var \$originals = tr.children();
                var \$helper = tr.clone();
                \$helper.children().each(function(index) {
                    // Set helper cell sizes to match the original sizes
                    $(this).width(\$originals.eq(index).width() + 52);
                });
                \$helper.addClass('warning');
                return \$helper;
            },
            stop: function(event, ui){
                var sorted = jQuery('#$id tbody').sortable('serialize', {key: 'item[]'});
                $.ajax({
                    type: 'POST',
                    asycn: false,
                    data: sorted,
                    url: '/authors/default/sort/'
                })
            }
        });");
        parent::run();
    }

}