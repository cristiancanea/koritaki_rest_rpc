<?php
namespace client\Controller;

class PagesController extends AppController {
    public function index() {
        return [
            'message' => 'index page'
        ];
    }

    public function pagenotfound() {
        return [
            'message' => '404 Page not found!'
        ];
    }
}