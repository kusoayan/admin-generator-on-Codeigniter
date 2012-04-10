<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Fake class for abstract extends. 
 *
 * @ignore
 */
class MY_Model extends CI_Model{}

abstract class EXMY_Model extends MY_Model
{
    var $id = NULL;
	
    function __construct()
    {
        parent::__construct();
		$this->load->database();
        $this->load->library("field_class");
        $this->id = new IntField(array("id" => TRUE));
		log_message('debug', "EXCI_Model Class Initialized");
    }

    protected function _getTableName()
    {
        return strtolower(trim(get_class($this),"_model"));
    }

    protected function _set($data = array())
    {
        $all_err_msg = array();

        foreach ($data as $field => $value)
        {
            $each_err_msg = NULL;
            if( !$this->{$field}->set($value,$each_err_msg) )
                $all_err_msg[$field] = $each_err_msg;
        }

        if($all_err_msg == array())
            return TRUE;
        else
            return $all_err_msg;
    }

    protected function _where($where = NULL)
    {
        if ($where == NULL)
            $this->db->where("id", $this->id->get());
        else
        {
            foreach ($where as $key => $val)
            {
                $this->db->where($key,$val);
            }
        }
    }

    public function getAllFields()
    {
        return get_object_vars($this);
    }

    public function add($data = NULL)
    {
        if($this->id->get() == NULL)
        {
            if($data != NULL)
                $this->_set($data);

            $data = array();
            $fields = $this->getAllFields();
            foreach ($fields as $field => $val)
            {
                $data[$field] = $val->get();
                $val->set(NULL);
            }
            $this->db->insert($this->_getTableName(),$data);
        }
    }

    public function save($data = NULL,$where = NULL)
    {
        if($this->id->get() > 0)
        {
            if($data != NULL)
                $this->_set($data);

            $fields = $this->getAllFields();
            foreach ($fields as $field => $val)
            {
                $data[$field] = $val->get();
            }
            $this->_where($where);
            $this->db->update($this->_getTableName(),$data);
            print_r($data);
        }

    }

    public function del($where = NULL)
    {
        if (is_int($where))
        {
            $this->_where(array("id" => $where));
        }
        else
        {
            $this->_where($where);
        }
        $this->db->delete($this->_getTableName());
    }

}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */
