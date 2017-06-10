<?php
/**
 * JSON response class.
 * 
 * @package api-framework
 * @author  Martin Bean <martin@martinbean.co.uk>
 */
class ResponseJson
{
    /**
     * Response data.
     *
     * @var string
     */
    protected $data;
    
    /**
     * Constructor.
     *
     * @param string $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        return $this;
    }
    
    /**
     * Render the response as JSON.
     * 
     * @return string
     */
    public function render()
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
        return json_encode($this->data);
    }
}