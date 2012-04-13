<?php
/**
 * Field_class
 *
 * Empty class, because I want CI autoload it.
 *
 * @author Wei
 **/
class Field_class{}

/**
 * OriginField
 *
 * If you want to add custom field, extends this.
 *
 * @author Wei
 **/
class OriginField
{
    protected $_field_setting = array();
    protected $_maxlength;
    protected $_minlength;
    protected $_value;
    protected $_foreign_key = array();

    function __construct($config = array())
    {
        empty($config) OR $this->_initialize($config);
    }

    protected function _initialize($config)
    {
        foreach ($config as $key => $value)
        {
            if ($value != '')
            {
                switch ($key)
                {
                    case 'maxlength':
                        $this->_maxlength = $value;
                        $this->_field_setting["constraint"] = $value;
                        break;
                 
                    case 'minlength':
                        $this->_minlength = $value;
                        break;   

                    case 'ForeignKey':
                        $this->_foreign_key = explode("-",$value);
                        break;

                    default:
                        break;
                }
            }
        }

    }

    public function getFieldSetting()
    {
        return $this->_field_setting;
    }

    public function getForeignKey()
    {
        if ($this->_foreign_key == array())
        {
            return NULL;
        }
        else
        {
            return $this->_foreign_key;
        }
    }

    public function get()
    {
        return $this->_value;
    }

    public function set($data = NULL, &$err_msg = NULL)
    {
        if($this->_validation($data, $err_msg) == TRUE)
        {
            $this->_value = $data;
            return TRUE;
        }
        else
            return FALSE;
    }


    protected function _validation($data = NULL, &$err_msg)
    {
        $ci =& get_instance();
        $ci->load->library("form_validation");
        $fv =& $ci->form_validation;

        if($this->_maxlength != NULL && $this->_maxlength > $this->_minlength)
        {
            if( !$fv->max_length($data,$this->_maxlength) )
                $err_msg["max_length"] = "invalid";
        }
        if($this->_minlength > NULL)
        {
            if( !$fv->min_length($data,$this->_minlength) )
                $err_msg["min_length"] = "invalid";
        }

        if ($err_msg == NULL)
            return TRUE;
        else
            return FALSE;
    }
}

/**
 * CharField
 *
 * @author Wei
 **/
class CharField extends OriginField
{
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->_field_setting["type"] = "VARCHAR";
    }
}

/**
 * IntField
 *
 * @author Wei
 **/
class IntField extends OriginField
{
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->_field_setting["type"] = "INT";

        if(array_key_exists("id",$config))
        {
            if($config["id"] == TRUE)
            {
                $this->_field_setting["constraint"] = 11;
                $this->_field_setting["unsigned"] = TRUE;
                $this->_field_setting["auto_increment"] = TRUE;
            }
        }

        if(array_key_exists("ForeignKey",$config))
        {
            $this->_field_setting["constraint"] = 11;
            $this->_field_setting["unsigned"] = TRUE;
        }
    }
}

/**
 * TextField
 *
 * @author Wei
 **/
class TextField extends OriginField
{
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->_field_setting["type"] = "TEXT";
    }
}

/* End of file field_class.php */
/* Location: ./application/libraries/field_class.php */
