<?php
namespace client\Model;

class CountryModel extends DbModel {
    protected $table  = 'locations_countries';

    /*
     * Custom method for listing if you do not want to use ORM methods
     */
    public function getCustom( $code ) {
        $data = $this->query('SELECT * FROM locations_countries WHERE code = ?;', [ $code ]);
        return $data;
    }
}