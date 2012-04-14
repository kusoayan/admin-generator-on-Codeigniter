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
        $this->_ci->load->helper("file");

        // Load model list by config
        $this->_ci->config->load("admin_generator",TRUE);
        $this->_model_list= $this->_ci->config->config["admin_generator"]["model_list"];

        foreach ($this->_model_list as $model)
        {
            // load the model
            $this->_ci->load->model($model . "_model");
            // put the field vars into $_field_list
            $this->_field_list[$model] = $this->_ci->{$model . "_model"}->getAllFields();
        }
    }

    function create_table_and_field()
    {
        foreach ($this->_field_list as $model => $fields)
        {
            $temp = array();
            $foreign_key_array = array();

            foreach ($fields as $field => $empty)
            {
                $temp[$field] = $this->_ci->{$model . "_model"}->$field->getFieldSetting();
                if ($this->_ci->{$model . "_model"}->$field->getForeignKey() != NULL)
                {
                    $foreign_key_array[] = array(
                        $field,
                        $this->_ci->{$model . "_model"}->$field->getForeignKey()
                    );
                    $this->_ci->dbforge->add_key($field);
                }
            }

            $this->_ci->dbforge->add_field($temp);

            // An optional second parameter set to TRUE will make it a primary key.
            $this->_ci->dbforge->add_key("id",TRUE);

            // second parameter set to TRUE adds an "IF NOT EXISTS" clause into the definition
            $this->_ci->dbforge->create_table($table_name = $model , TRUE);

            // Give Foreign Key
            if ($foreign_key_array != array())
            {
                $this->_ci->load->database();
                if ($this->_ci->db->table_exists($table_name))
                {
                    foreach ($foreign_key_array as $val)
                    {
                        $sql = "ALTER TABLE  `{$table_name}` 
                            ADD FOREIGN KEY ( `{$val[0]}` )
                            REFERENCES  `{$val[1][0]}` (`{$val[1][1]}`)
                            ON DELETE CASCADE ON UPDATE CASCADE ;";
                        $this->_ci->db->query($sql);
                    }
                }
            }
        }
        
    }

    public function create_controller($model = NULL)
    {
        if (in_array($model,$this->_model_list))
        {
            $fields = $this->_field_list[$model];
            $display_field = array();
            foreach ($fields as $obj_name => $obj)
            {
                if ($obj_name == "id")
                {
                    continue;
                }
                $display_field[] = $obj_name;
            }

            $data["model_name"] = $model;
            $data["display_field"] = $display_field;
            $content = $this->_ci->load->view("admin_generator/controller",$data,TRUE);
            if (@!stat("application/controllers/admin/"))
            {
                mkdir("application/controllers/admin/", 0755, true);
            }

            if( !write_file("./application/controllers/admin/{$model}.php",$content))
            {
                echo "unable write content to ./application/controllers/admin/{$model}.php";
            }
        }
    }

    public function create_template()
    {
        $data["model_list"] = $this->_model_list;
        $content = $this->_ci->load->view("admin_generator/admin_layout",$data,TRUE);
        if (@!stat("application/views/admin/template/"))
        {
            mkdir("application/views/admin/template/", 0777, true);
        }
        if (!write_file("./application/views/admin/template/admin_layout.php",$content))
        {
            echo "unable write content to ./application/views/admin/template/admin_template.php";
        }
    }

    public function create_view($model = NULL)
    {
        if (in_array($model,$this->_model_list))
        {
            $fields = $this->_field_list[$model];
            $display_field = array();
            foreach ($fields as $obj_name => $obj)
            {
                if ($obj_name == "id")
                {
                    continue;
                }
                $display_field[] = $obj_name;
            }

            $this->_create_list_view($model,$display_field);
            $this->_create_edit_view($model,$display_field);

        }
    }

    private function _create_list_view($model = NULL, $display_field = array())
    {
        $data["display_field"] = $display_field;
        $content = $this->_ci->load->view("admin_generator/list_view",$data,TRUE);
        if (@!stat("application/views/admin/{$model}/"))
        {
            mkdir("application/views/admin/{$model}/", 0777, true);
        }
        if (!write_file("./application/views/admin/{$model}/{$model}_list.php",$content))
        {
            echo "unable write content to ./application/views/admin/{$mode}/{$model}_list.php";
        }
    }

    private function _create_edit_view($model = NULL, $display_field = array())
    {
        $data["display_field"] = $display_field;
        $content = $this->_ci->load->view("admin_generator/edit_view",$data,TRUE);
        if (@!stat("application/views/admin/{$model}/"))
        {
            mkdir("application/views/admin/{$model}/", 0777, true);
        }
        if (!write_file("./application/views/admin/{$model}/{$model}_edit.php",$content))
        {
            echo "unable write content to ./application/views/admin/{$mode}/{$model}_edit.php";
        }
    }
}

/* End of file admin_generator.php */
/* Location: ./application/libraries/admin_generator.php */
