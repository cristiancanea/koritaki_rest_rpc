<?php
namespace koritaki\Response;

class HtmlResponse extends AbstractResponse {
    public function output() {
        //TODO: require improvement!

        $layoutFile = APP_PATH.DIRECTORY_SEPARATOR.'View'.DIRECTORY_SEPARATOR.'layout.tpl';
        require $layoutFile;
    }
}