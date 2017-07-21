# Install:
www/test_nph
php 5.5.12 or later
location: {www}/test_nph

# It contains:
    koritaki rest framework 
        - DB adapter
        - Routing
        - MWC
    location_service
        JSON RPC service
        using https://packagist.org/packages/fguillot/json-rpc
    client
        implements koritaki + location_service
    

# Run:

Client:
http://localhost/test_nph/client/public/locations/index


# DB improvement:

CREATE TABLE `locations_countries` (
   `id` tinyint(3) unsigned NOT NULL,
   `name` varchar(8) NOT NULL,
   `code` varchar(2) NOT NULL,
   `prefix` varchar(5) NOT NULL,
   KEY `index_code` (`code`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8



