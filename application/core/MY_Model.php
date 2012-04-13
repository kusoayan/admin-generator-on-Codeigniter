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
        return strtolower(substr(get_class($this),0,-6));
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
        if ($where != NULL)
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

    public function add($data = NULL, $table = NULL)
    {
        if($this->id->get() == NULL)
        {
            if ($table == NULL)
            {
                $model_obj = $this;   
            }
            else
            {
                $this->load->model($table . "_model");
                $model_obj = $this->{$table . "_model"};
            }

            if ($data != NULL)
                $model_obj->_set($data);

            $data = array();
            $fields = $model_obj->getAllFields();
            foreach ($fields as $field => $val)
            {
                $data[$field] = $val->get();
                $val->set(NULL);
            }
            $this->db->insert($model_obj->_getTableName(),$data);
        }
    }

    public function save($data = NULL, $where = NULL, $table = NULL)
    {
        if ($table == NULL)
        {
            $model_obj = $this;   
        }
        else
        {
            $this->load->model($table . "_model");
            $model_obj = $this->{$table . "_model"};
        }

        if (!is_array($where))
        {
            $model_obj->id->set((int) ($where));
        }
        else
        {
            $model_obj->_where($where);
        }

        if($data != NULL)
            $model_obj->_set($data);

        $fields = $model_obj->getAllFields();
        foreach ($fields as $field => $val)
        {
            $data[$field] = $val->get();
        }

        $this->db->update($model_obj->_getTableName(),$data);

    }

    public function del($where = NULL, $table = NULL)
    {
        if ($table == NULL)
        {
            $model_obj = $this;   
        }
        else
        {
            $this->load->model($table . "_model");
            $model_obj = $this->{$table . "_model"};
        }

        if (!is_array($where))
        {
            $model_obj->_where(array("id" => (int) ($where)));
        }
        else
        {
            $model_obj->_where($where);
        }

        $this->db->delete($model_obj->_getTableName());
    }

    public function get_list($where = NULL, $offset = 0, $limit = 1000, $table = NULL)
    {
        if ($table == NULL)
        {
            $model_obj = $this;   
        }
        else
        {
            $this->load->model($table . "_model");
            $model_obj = $this->{$table . "_model"};
        }

        if (!is_array($where) && $where != NULL)
        {
            $model_obj->_where(array("id" => (int) ($where)));
        }
        else
        {
            $this->_where($where);
        }

        $query = $this->db->get($model_obj->_getTableName(),$limit,$offset);

        if ($query->num_rows > 0)
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }

    }

    public function get($where = NULL, $table = NULL)
    {
        $result = $this->get_list($where,0,1,$table);
        return $result[0];
    }

}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */
