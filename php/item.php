<?php
class Item implements JsonSerializable{
    private $name;
    private $rarity;
    private $category;
    private $image;
    private $requires_unlock;
    private $has_two_stats;

    private $stat=array();
    private $base=array();
    private $unit=array();
    private $stack_type=array();
    private $stack_rate=array();
    
    public function getName(){
        return $this->name;
    }
    public function setName($n){
        $this->name = $n;
    }
    public function getRarity(){
        return $this->rarity;
    }
    public function setRarity($n){
        $this->rarity = $n;
    }
    public function getCategory(){
        return $this->category;
    }
    public function setCategory($n){
        $this->category = $n;
    }
    public function getImage(){
        return $this->image;
    }
    public function setImage($n){
        $this->image = $n;
    }
    public function getRUnlock(){
        return $this->requires_unlock;
    }
    public function setRUnlock($n){
        $this->requires_unlock = $n;
    }
    public function get2Stats(){
        return $this->has_two_stats;
    }
    public function set2Stats($n){
        $this->has_two_stats = $n;
    }
    
    public function getStat($x){
        return $this->stat[$x];
    }
    public function setStat($x,$n){
        $this->stat[$x] = $n;
    }
    public function getBase($x){
        return $this->base[$x];
    }
    public function setBase($x,$n){
        $this->base[$x] = $n;
    }
    public function getUnit($x){
        return $this->unit[$x];
    }
    public function setUnit($x,$n){
        $this->unit[$x] = $n;
    }
    public function getStackType($x){
        return $this->stack_type[$x];
    }
    public function setStackType($x,$n){
        $this->stack_type[$x] = $n;
    }
    public function getStackRate($x){
        return $this->stack_rate[$x];
    }
    public function setStackRate($x,$n){
        $this->stack_rate[$x] = $n;
    }
    
    public function jsonSerialize(){
        $arr = array();
        $arr[0] = [
            'stat'=> $this->getStat(0),
            'base'=> $this->getBase(0),
            'unit'=> $this->getUnit(0),
            'stack_type'=> $this->getStackType(0),
            'stack_rate'=> $this->getStackRate(0)
        ];
        if($this->get2Stats()){
            $arr[1] = [
                'stat'=> $this->getStat(1),
                'base'=> $this->getBase(1),
                'unit'=> $this->getUnit(1),
                'stack_type'=> $this->getStackType(1),
                'stack_rate'=> $this->getStackRate(1)
            ]; 
        }
        
        return [
            "name"=>$this->getName(),
            "rarity"=>$this->getRarity(),
            "category"=>$this->getCategory(),
            "image"=>$this->getImage(),
            "requires_unlock"=>$this->getRUnlock(),
            "has_two_stats"=>$this->get2Stats(),
            "stats"=> $arr

        ];
    }
        
    }
    
    
    
    
    /*
     {
        "name":"Bustling Fungus",
        "rarity":"Common",
        "category":"Healing",
        "image":"images/common/Bustling_Fungus.png",
        "requires_unlock":"False",
        "has_two_stats":"true",
        "stats":[
            {
                "stat":"Health per second",
                "base":"4.5",
                "unit":"%",
                "stack_type":"Linear",
                "stack_rate":"2.25"
            },
            {
                "stat":"Radius",
                "base":"3",
                "unit":"m",
                "stack_type":"Linear",
                "stack_rate":"3"
            }

        ]
    } */

?>