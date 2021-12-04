<?php

namespace Model;

class SubscriptionType extends \DB\SQL\Mapper
{
    private
        $id,
        $name,
        $description;

    public function __construct($id=null,$name="",$description="")
    {
        parent::__construct( \Base::instance()->get('DB'), 'Partners' );
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function createRecord()
    {
        $subscription = new parent(\Base::instance()->get('DB'),'Subscription_Types');
        $subscription->id = $this->id;
        $subscription->name = $this->name;
        $subscription->description= $this->description;
        
        $s = $subscription->save();
        $this->id = $s->id;
        
    }

    public function getRecord(){
        
            return [
                "id" => $this->id,
                "name" => $this->name,
                "description" => $this->description
            ];
        
    }
    
}
