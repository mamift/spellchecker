<?php 

class Results {

    protected $data;
    protected $success;
    protected $message;
    
    public $count;
    protected $customData = array();
    protected $dataFilter = array();
    protected $dataFilterCallback;
    protected $filteredData;

    /**
     * The constructor: accepts an object (for the data component), success flag and command message
     * Default constructor arguments: sets $data to an empty array, $success to false and $message to COMMAND_NO_MESSAGE_SET
     * @param [mixed] $data  [the resultant data object]
     * @param [bool|boolean] $success [command success flag]
     * @param [string] $message [command message]
     */
    public function __construct($data = array(), $success = false, $message = '(no message has been set)') 
    {
        $this->data = $data;
        $this->success = $success;
        $this->message = $message;

        $this->updateCount();
    }

    /**
     * Update the count of the data array
     * 
     * @return [int] [the count]
     */
    private function updateCount() 
    {
        $c = count($this->data);
        if ($c > 0) {
            $this->count = $c;
        }
    }

    /**
     * Sets and gets the resultant data
     * 
     * @return [mixed] [usually an array]
     */
    public function data($data = NULL)
    {
        if (empty($data) || $data === NULL) {
            if (empty($this->filteredData)) { // no filtered data set, return all
                return $this->data;
            } else {
                return $this->filteredData;
            }
        } else { 
            $this->data = $data;
            // when setting, update count property
            $this->updateCount();
        }
    }

    /**
     * Gets the $this->filteredData property
     * @return [array] [filterd version of $this->data]
     */
    public function filteredData()
    {
        return $this->filteredData;
    }

    /**
     * Sets and gets the message
     * @return [string] [the message]
     */
    public function message($message = NULL) 
    {
        if (empty($message))
            return $this->message;
        else
            $this->message = $message;
    }

    /**
     * Sets and gets the success flag
     * @return [bool] [success flag]
     */
    public function success($success = NULL) 
    {
        if ($success == NULL && !is_bool($success))
            return (bool) $this->success;
        else
            $this->success = (bool) $success;
    }

    /**
     * __set magic method for setting customData values
     * @param [string] $name  [the name of the custom data]
     * @param [any] $value [the value of the custom data]
     */
    public function __set($name, $value) 
    {
        $this->customData[$name] = $value;
    }

    /**
     * __get magic method for geting customData values
     * @param  [string] $name [the name of the custom data]
     * @return [any]       [the custom data]
     */
    public function __get($name)
    {
        return $this->customData[$name];
    }

    /**
     * Default __toString method
     * @return string [the string representation of this class]
     */
    public function __toString()
    {
        return r200_json($this->all());
    }

    /**
     * Invokes array_keys() on $this->data and saves the result in $this->filteredData;
     *      *
     * @param [array] $filter [the data filter]
     * 
     */
    public function filterDataByKey(array $filter) 
    {
        $this->dataFilter = $filter;

        $this->filteredData = array_keys($this->data, $this->dataFilter);
    }

    /**
     * Invokes array_filter on $this->data and saves the result in $this->filteredData
     * 
     * @param [Closure] $callback [the callback to filter the array on]
     */
    public function filterDataByCallback(Closure $callback)
    {
        $this->dataFilterCallback = $callback;

        $this->filteredData = array_filter($this->data, $callback);
    }
    
    /**
     * Returns a flattened-array of the result object data. Will only include data and message elements if they exist and aren't empty
     * @return [array] [the array of result object data]
     */
    public function all() 
    {
        $response = array();
        if (!empty($this->data())) $response['data'] = $this->data();
        $response['success'] = $this->success();
        if (!empty($this->message())) $response['message'] = $this->message();
        // also retrieve custom data
        foreach ($this->customData as $key => $value) {
            $response[$key] = $value;
        }

        return $response;
    }
}