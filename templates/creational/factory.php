<?php

/**
 * Summary of Worker
 */
class Worker
{
    /**
     * Summary of name
     * @var string
     */
    private string $name;


    /**
     * Summary of __construct
     */
    public function __construct()
    {

    }

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}
	
	/**
	 * @param string $name 
	 * @return self
	 */
	public function setName(string $name): self {
		$this->name = $name;
		return $this;
	}
}

/**
 * Summary of WorkerFactory
 */
class WorkerFactory {
    /**
     * Summary of make
     * @return Worker
     */
    public static function make(): Worker
    {
        return new Worker();
    }
}

$worker = WorkerFactory::make();
$worker->setName('Boris');
var_dump($worker->getName());