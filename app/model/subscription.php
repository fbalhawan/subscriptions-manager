<?php

namespace Model;

class Subscription extends \DB\SQL\Mapper
{
    public static $SUBSCRIBED = "SUBSCRIBED",
                  $PENDING = "PENDING",
                  $UNSUBSCRIBED = "UNSUBSCRIBED";

    private
        $merchant,
        $partner,
        $subscription_type,
        $subscription_status;

    public function __construct($merchant, $partner, $subscription_type, $subscription_status)
    {
        parent::__construct(\Base::instance()->get('DB'), 'Subscriptions');
        $this->merchant = $merchant;
        $this->partner = $partner;
        $this->subscription_type = $subscription_type;
        $this->subscription_status = $subscription_status;
    }

    public function createRecord()
    {
        $subscription = new parent(\Base::instance()->get('DB'), 'Subscriptions');
        $subscription->merchant = $this->merchant;
        $subscription->partner = $this->partner;
        $subscription->subscription_type = $this->subscription_type;
        $subscription->subscription_status = $this->subscription_status;

        $s = $subscription->save();
    }

        
    /**
     * getRecords, a query builder to get list of subscriptions
     *
     * @param  int $merchantId
     * @param  int $partnerId
     * @param  int $subscriptionTypeId
     * @param bool $getAll
     * @param  string[] $columns
     * @return subscription[]
     */
    public static function getRecords($merchantId=null, $partnerId=null, $subscriptionTypeId=null, $getAll=false, $columns = [])
    {
        $db = \Base::instance()->get('DB');
        $query = "SELECT * FROM Subscriptions";
        if (sizeof($columns) > 0) {
            $str_columns = join(", ", $columns);
            $query = str_replace("*", $str_columns, $query);
        }
        if(!$getAll){
            $query = $query . ' WHERE subscription_status <> "UNSUBSCRIBED" AND ';
        }
        
        if (isset($merchantId) || isset($partnerId) || isset($subscriptionTypeId)) {
            if($getAll){
                $query = $query . ' WHERE ';
            }

            $conditions = [];

            if (isset($merchantId)) {
                array_push($conditions, 'merchant = ' . $merchantId);
            }
            if (isset($partnerId)) {
                array_push($conditions, 'partner = ' . $partnerId);
            }
            if (isset($subscriptionTypeId)) {
                array_push($conditions, 'subscription_type = ' . $subscriptionTypeId);
            }

            $str_conditions = join(" AND ", $conditions);
            $query = $query . $str_conditions;
        }
        $subscription = $db->exec($query);
        return $subscription;
    }


    /**
     * getRecord
     *
     * @param string{"merchant", "partner", "subscription_type", "subscription_status"} $key
     * 
     * @return (array|int|string)
     */
    public function getJson($key = null)
    {

        if (!$key) {
            return [
                "merchant" => $this->merchant,
                "partner" => $this->partner,
                "subscription_type" => $this->subscription_type,
                "subscription_status" => $this->subscription_status
            ];
        } else {
            return $this->$key;
        }
    }
    
    /**
     * deleteRecord
     *
     * @return void
     */
    public function deleteRecord(){
        $db = \Base::instance()->get('DB');
        $query = "UPDATE Subscriptions SET subscription_status='UNSUBSCRIBED' WHERE ";
        $conditions = [
            'merchant = ' . $this->merchant,
            'partner = ' . $this->partner,
            'subscription_type = ' . $this->subscription_type
        ];
        $str_conditions = join(" AND ", $conditions);
        $query = $query . $str_conditions;
        $subscription = $db->exec($query);
    }

        /**
     * deleteRecord
     *
     * @return void
     */
    public function resubscribe(){
        $db = \Base::instance()->get('DB');
        $query = "UPDATE Subscriptions SET subscription_status='PENDING' WHERE ";
        $conditions = [
            'merchant = ' . $this->merchant,
            'partner = ' . $this->partner,
            'subscription_type = ' . $this->subscription_type
        ];
        $str_conditions = join(" AND ", $conditions);
        $query = $query . $str_conditions;
        $subscription = $db->exec($query);
    }
}

