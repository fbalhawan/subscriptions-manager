<?php

namespace Model;

/**
 * Partner
 */
class Partner extends \DB\SQL\Mapper
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
    
    /**
     * createRecord
     *
     * @return void
     */
    public function createRecord()
    {
        $db_mapper = new parent(\Base::instance()->get('DB'),'Partners');
        $db_mapper->id = $this->id;
        $db_mapper->name = $this->name;
        $db_mapper->description= $this->description;
        
        $partner = $db_mapper->save();
        $this->id = $partner->id;
    }
    
    /**
     * getRecord
     *
     * @return Partner[]
     */
    public function getRecord(){
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description
        ];   
    }
}
