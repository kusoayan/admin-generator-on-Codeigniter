<?="<?php ";?>if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class <?=ucfirst($model_name);?> extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library("template");
        $this->template->set_layout("template/admin_layout.php");
        $this->load->model("<?=$model_name;?>_model","self_model");
    }
	public function index()
	{
        $this->list_item();
	}

    public function list_item()
    {
        $this->template->set("items",$this->self_model->get_list());
        $this->template->set("edit_controller","admin/edit_item/");
        $this->template->set("del_controller","");
        $this->template->render("admin/<?=$model_name;?>/<?=$model_name;?>_list");
        //$this->load->view("admin/<?=$model_name;?>/<?=$model_name;?>_list",$data);
    }

    public function edit_item($id = NULL)
    {
        if ($id > 0)
        {
            // edit mode
            $item = $this->self_model->get($id);
            $this->template->set("item",$item);
        }

        $this->template->render("admin/<?=$model_name;?>/<?=$model_name;?>_edit");
        
    }

}

/* End of file <?=$model_name;?>.php */
/* Location: ./application/controllers/admin/<?=$model_name;?>.php */
