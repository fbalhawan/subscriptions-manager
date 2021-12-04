<?php

namespace Controller;

use Model\Subscription;
use \Firebase\JWT\JWT;
use Output\Response;

class SubscriptionController extends \Prefab
{
    private $token, $decodedToken, $authorized = false;

    /**
     * beforeRoute
     * Authorize users before accessing subscriptions controller
     * 
     * @param  mixed $f3
     * @param  mixed $params
     * @return void
     */
    function beforeRoute($f3, $params)
    {
        $response = new Response();
        $httpHeader = $f3->get("HEADERS");
        $this->token = $httpHeader["Authorization"];
        $this->token = str_replace("Bearer ", "", $this->token);
        try {
            $this->decodedToken = JWT::decode($this->token, $f3->get('JWT.secret'), ['HS256']);
            if ($this->decodedToken->exp < time()) {
                $response->setResponse(Response::$UNAUTHORIZED["code"], Response::$UNAUTHORIZED["title"], ["message" => "Invalid token"]);
                echo $response->getJsonResponse();
                return;
            }
        } catch (\Exception $e) {
            $response->setResponse(Response::$UNAUTHORIZED["code"], Response::$UNAUTHORIZED["title"], ["message" => "Invalid token"]);
            echo $response->getJsonResponse();
            return;
        }
        $this->authorized = true;
    }

    /**
     * subscribe
     *
     * @param  mixed $f3
     * @param  mixed $params
     * @return void
     */
    public function subscribe($f3, $params)
    {
        if ($this->authorized) {
            $body = $f3->get("POST");
            $partnerId = $body["partnerId"];
            $subscriptionTypeId = $body["subscriptionTypeId"];
            $response = new Response();
            try {
                $subscription = new Subscription($this->decodedToken->id, $partnerId, $subscriptionTypeId, "PENDING");
                try {
                    $subscription->createRecord();
                } catch (\Exception $e) {
                    //Duplicate field error
                    if ($e->getCode() == 23000) {
                        $existingSubscription = Subscription::getRecords($this->decodedToken->id, $partnerId, $subscriptionTypeId, true);
                        if ($existingSubscription[0]["subscription_status"] == Subscription::$UNSUBSCRIBED) {
                            //Resubscribe
                            $subscription = new Subscription($existingSubscription[0]["merchant"], $existingSubscription[0]["partner"], $existingSubscription[0]["subscription_type"], "PENDING");
                            $subscription->resubscribe();
                            $response->setResponse(Response::$SUCCESS["code"], Response::$SUCCESS["title"], [
                                "message" => "New subscription created, current status is " . $subscription->getJson("subscription_status")
                            ]);
                            echo $response->getJsonResponse();
                            return;
                        } else {
                            $response->setResponse(Response::$SUCCESS["code"], Response::$SUCCESS["title"], [
                                "message" => "Subscription already exists with status " . $existingSubscription[0]["subscription_status"]
                            ]);
                            echo $response->getJsonResponse();
                            return;
                        }
                    }
                }
                $response->setResponse(Response::$SUCCESS["code"], Response::$SUCCESS["title"], [
                    "message" => "New subscription created, current status is " . $subscription->getJson("subscription_status")
                ]);
                echo $response->getJsonResponse();
                return;
            } catch (\Exception $e) {
                $response->setResponse(Response::$ERROR["code"], Response::$ERROR["title"], ["message" => $e->getMessage()]);
                echo $response->getJsonResponse();
                return;
            }
        }
    }

    public function unsubscribe($f3, $params)
    {
        if ($this->authorized) {
            // $body = $f3->get("DEL");
            $partnerId = $params["partnerId"];
            $subscriptionTypeId = $params["subscriptionTypeId"];
            $response = new Response();

            try {
                $subscriptionsArray = Subscription::getRecords($this->decodedToken->id, $partnerId, $subscriptionTypeId);
                if (count($subscriptionsArray) > 0) {
                    $subscription = new Subscription($subscriptionsArray[0]["merchant"], $subscriptionsArray[0]["partner"], $subscriptionsArray[0]["subscription_type"], $subscriptionsArray[0]["subscription_status"]);
                    $subscription->deleteRecord();
                    $response->setResponse(Response::$SUCCESS["code"], Response::$SUCCESS["title"], [
                        "message" => "Successfully unsubscribed"
                    ]);
                    echo $response->getJsonResponse();
                    return;
                } else {
                    $response->setResponse(Response::$ERROR["code"], Response::$ERROR["title"], [
                        "message" => "No record found"
                    ]);
                    echo $response->getJsonResponse();
                    return;
                }
            } catch (\Exception $e) {

                $response->setResponse(Response::$ERROR["code"], Response::$ERROR["title"], [
                    "message" => "No record found"
                ]);
                echo $response->getJsonResponse();
                return;
            }
        }
    }

    /**
     * getSubscriptions
     *
     * @param  mixed $f3
     * @return void
     */
    public function getSubscriptions($f3)
    {
        if ($this->authorized) {
            $subscriptions = Subscription::getRecords($this->decodedToken->id);
            $response = new Response(Response::$SUCCESS["code"], Response::$SUCCESS["title"], ["subscriptions" => $subscriptions]);
            echo $response->getJsonResponse();
            return;
        }
    }
}
