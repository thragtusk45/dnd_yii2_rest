<?php

use common\extensions\kcfinder\lib\TextHelper;
use common\extensions\kcfinder\Uploader;

$this->registerJs('_.version = "' . Uploader::VERSION . '";
            _.support.zip = ' . ((class_exists('ZipArchive') && !$this->context->config['denyZipDownload']) ? "true" : "false") . ';
            _.support.check4Update = ' . (((!isset($this->context->config['denyUpdateCheck']) || !$this->context->config['denyUpdateCheck']) && (ini_get("allow_url_fopen") || function_exists("http_get") || function_exists("curl_init") || function_exists('socket_create'))) ? "true" : "false") . ';
            _.lang = "' . TextHelper::jsValue($this->context->lang) . '";
            _.type = "' . TextHelper::jsValue($this->context->type) . '";
            _.theme = "' . TextHelper::jsValue($this->context->config['theme']) . '";
            _.access = ' . json_encode($this->context->config['access']) . ';
            _.dir = "' . TextHelper::jsValue($this->context->session['dir']) . '";
            _.uploadURL = "' . TextHelper::jsValue($this->context->config['uploadURL']) . '";
            _.thumbsURL = _.uploadURL + "/' . TextHelper::jsValue($this->context->config['thumbsDir']). '";
            _.opener = ' . json_encode($this->context->opener) . ';
            _.cms = "' . TextHelper::jsValue($this->context->cms) . '";
            $.$.kuki.domain = "' . TextHelper::jsValue($this->context->config['cookieDomain']) . '";
            $.$.kuki.path = "' . TextHelper::jsValue($this->context->config['cookiePath']) . '";
            $.$.kuki.prefix = "' . TextHelper::jsValue($this->context->config['cookiePrefix']) . '";
            $(function() { _.resize(); _.init(); });
            $(window).resize(_.resize);', \yii\web\View::POS_END);

?>

<style type="text/css">
    div.file{width:<?= $this->context->config['thumbWidth'] ?>px;}
    div.file .thumb{width:<?= $this->context->config['thumbWidth'] ?>px;height:<?= $this->context->config['thumbHeight'] ?>px}
</style>

<div id="resizer"></div>
<div id="menu"></div>
<div id="clipboard"></div>
<div id="all">

    <div id="left">
        <div id="folders"></div>
    </div>

    <div id="right">

        <div id="toolbar">
            <div>
                <a href="kcact:upload"><span><?= $this->context->t('kcfinder', "Upload") ?></span></a>
                <a href="kcact:refresh"><span><?= $this->context->t('kcfinder', "Refresh") ?></span></a>
                <a href="kcact:settings"><span><?= $this->context->t('kcfinder', "Settings") ?></span></a>
                <a href="kcact:maximize"><span><?= $this->context->t('kcfinder', "Maximize") ?></span></a>
                <a href="kcact:about"><span><?= $this->context->t('kcfinder', "About") ?></span></a>
                <div id="loading"></div>
            </div>
        </div>

        <div id="settings">

            <div>
                <fieldset>
                    <table summary="view" id="view"><tr>
                            <th><input id="viewThumbs" type="radio" name="view" value="thumbs" /></th>
                            <td><label for="viewThumbs">&nbsp;<?= $this->context->t('kcfinder', "Thumbnails") ?></label> &nbsp;</td>
                            <th><input id="viewList" type="radio" name="view" value="list" /></th>
                            <td><label for="viewList">&nbsp;<?= $this->context->t('kcfinder', "List") ?></label></td>
                        </tr></table>
                </fieldset>
            </div>

            <div>
                <fieldset>
                    <legend><?= $this->context->t('kcfinder', "Show:") ?></legend>
                    <table summary="show" id="show"><tr>
                            <th><input id="showName" type="checkbox" name="name" /></th>
                            <td><label for="showName">&nbsp;<?= $this->context->t('kcfinder', "Name") ?></label> &nbsp;</td>
                            <th><input id="showSize" type="checkbox" name="size" /></th>
                            <td><label for="showSize">&nbsp;<?= $this->context->t('kcfinder', "Size") ?></label> &nbsp;</td>
                            <th><input id="showTime" type="checkbox" name="time" /></th>
                            <td><label for="showTime">&nbsp;<?= $this->context->t('kcfinder', "Date") ?></label></td>
                        </tr></table>
                </fieldset>
            </div>

            <div>
                <fieldset>
                    <legend><?= $this->context->t('kcfinder', "Order by:") ?></legend>
                    <table summary="order" id="order"><tr>
                            <th><input id="sortName" type="radio" name="sort" value="name" /></th>
                            <td><label for="sortName">&nbsp;<?= $this->context->t('kcfinder', "Name") ?></label> &nbsp;</td>
                            <th><input id="sortType" type="radio" name="sort" value="type" /></th>
                            <td><label for="sortType">&nbsp;<?= $this->context->t('kcfinder', "Type") ?></label> &nbsp;</td>
                            <th><input id="sortSize" type="radio" name="sort" value="size" /></th>
                            <td><label for="sortSize">&nbsp;<?= $this->context->t('kcfinder', "Size") ?></label> &nbsp;</td>
                            <th><input id="sortTime" type="radio" name="sort" value="date" /></th>
                            <td><label for="sortTime">&nbsp;<?= $this->context->t('kcfinder', "Date") ?></label> &nbsp;</td>
                            <th><input id="sortOrder" type="checkbox" name="desc" /></th>
                            <td><label for="sortOrder">&nbsp;<?= $this->context->t('kcfinder', "Descending") ?></label></td>
                        </tr></table>
                </fieldset>
            </div>

        </div>

        <div id="files">
            <div id="content"></div>
        </div>
    </div>
    <div id="status"><span id="fileinfo">&nbsp;</span></div>
</div>