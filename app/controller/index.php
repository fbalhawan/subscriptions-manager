<?php
Namespace Controller;

use Model\Partner;

class Index extends \Prefab {
    public function get_index($f3) {
        echo("<p>API is Alive</p>");
        echo "GET / <br/>
        GET /merchants <br/>
        POST /merchants/login<br/>
        POST /merchants/createDummyMerchant<br/>
        POST /subscribe<br/>
        GET /subscriptions<br/>
        DELETE /unsubscribe/@partnerId/@subscriptionTypeId";
    }
}