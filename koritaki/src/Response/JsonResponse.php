<?php
namespace koritaki\Response;

class JsonResponse extends AbstractResponse {
    public function output() {
        header('Content-Type: application/json');
        echo json_encode( $this->data, JSON_PRETTY_PRINT );
    }
}