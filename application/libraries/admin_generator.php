<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin generator library
 *
 * @author Wei <xobkkmp3@gmail.com>
 */
class Admin_generator {

    /**
     * ci
     * 
     * @var Codeigniter
     */
    private $_ci;

    private $_model_list = array();

    private $_field_list = array();

    function __construct()
    {
        $this->_ci =& get_instance();
        $this->_ci->load->dbforge();

        // Load model list by config
        $this->_ci->config->load("admin_generator",TRUE);
        $this->_model_list= $this->_ci->config->config["admin_generator"]["model_list"];

        foreach ($this->_model_list as $model)
        {
            // load the model
            $this->_ci->load->model($model . "_model");
            // put the field vars into $_field_list
            //$this->_field_list[$model] = get_class_vars($model . "_model");
            $this->_field_list[$model] = $this->_ci->{$model . "_model"}->getAllFields();
        }
    }

    function create_table_and_field()
    {
        foreach ($this->_field_list as $model => $fields)
        {
            foreach ($fields as $field => $empty)
            {
                $temp[$field] = $this->_ci->{$model . "_model"}->$field->getFieldSetting();
            }
            $this->_ci->dbforge->add_field($temp);

            // An optional second parameter set to TRUE will make it a primary key.
            $this->_ci->dbforge->add_key("id",TRUE);

            // second parameter set to TRUE adds an "IF NOT EXISTS" clause into the definition
            $this->_ci->dbforge->create_table($table_name = $model , TRUE);
            
        }
        
    }
}

/* End of file admin_generator.php */
/* Location: ./application/libraries/admin_generator.php */
