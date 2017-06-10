<?php
abstract class ControlBase {
    
    protected $view;
	public $get;
	public $input;
	
    function __construct()
    {
        $this->view = new View();
    }
	
}
?>