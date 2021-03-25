<?php

namespace Stringer;

class Things
{

    use Figures;

	/**
     * @var reference to multiton array of instances
     */
    private static $instances = [];

	public $string;
	public $initial;

	/**
     * Creates a new instance using the supplied string as key.
     *
     * @param $key the key which the instance should be stored/retrieved
     *
     * @return self
     */
    final public static function go($key)
    {
        if(!array_key_exists($key, self::$instances)) {
            
            self::$instances[$key] = new self;
            self::$instances[$key]->setString($key);
        }
        
        return self::$instances[$key];
    }

    public function setString($string)
    {
    	$this->string = $string;
    	$this->initial = $string;
    }

    public function initial()
    {
    	return $this->initial;
    }

    public function print()
    {
    	echo $this->string;
    }

    public function dump()
    {
    	var_dump($this->string);
    }

    public function clone(int $times, bool $lineBreak = false)
    {
    	if($lineBreak === true) {
    		$this->string = $this->string . "\n<br>";
    		$this->string = str_repeat($this->string, $times);
    	} else {
    		$this->string = str_repeat($this->string, $times);
    	}

    	return $this;
    }

    public function lower()
    {
    	$this->string = mb_strtolower($this->string);

    	return $this;
    }

    public function upper()
    {
    	$this->string = mb_strtoupper($this->string);
    	
    	return $this;
    }

    public function count($attributes = null)
    {

    	return strlen($this->string);
    }

    public function spacecut()
    {
    	$this->string = preg_replace('/\s+/','',$this->string);

    	return $this;
    }

    public function breakscut()
    {
    	$this->string = preg_replace( "/\r|\n|<br>/", "", $this->string );

    	return $this;
    }

    public function nopunc()
    {
        $this->string = preg_replace("/[^\w\s]/", "", $this->string);
    }

    public function figures()
    {
        $this->string = preg_replace("/(?![%.,])[^\w\s]/", "", $this->string);
    	$this->string = explode(" ", $this->string);
    	foreach ($this->string as $key => $value) {
    		if(!preg_match("/^\d+$/", $value) && !preg_match("/[0-9]+%/", $value) && !array_key_exists($value, $this->numerals)) {
    			unset($this->string[$key]);
    		}
    	}

    	return $this;
    }

    /**
     * Prevents cloning the multiton instances.
     *
     * @return void
     */
    private function __clone() {}

    /**
     * Prevents unserializing the multiton instances.
     *
     * @return void
     */
    public function __wakeup() {}

}