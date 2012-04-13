<?="<?php ";?>if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class <?=ucfirst($model_name);?> extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->template->set_layout("admin/template/admin_layout.php");
        $this->load->model("<?=$model_name;?>_model","self_model");
    }
	public function index()
	{
        $this->list_item();
	}

    public function list_item()
    {
        $this->template->set("items",$this->self_model->get_list());
        $this->template->set("edit_controller","admin/<?=$model_name;?>/edit_item/");
        $this->template->set("del_controller","admin/<?=$model_name;?>/del_item/");
        $this->template->render("admin/<?=$model_name;?>/<?=$model_name;?>_list");
    }

    public function edit_item($id = NULL)
    {
        if ($this->input->post("submit") != FALSE)
        {
<?php foreach ($display_field as $field):?>
            $data["<?=$field;?>"] = $this->input->post("<?=$field;?>");
<?php endforeach;?>
            if ($id > 0)
            {
                $this->self_model->save($data,$id);
            }
            else
            {
                $this->self_model->add($data);
                redirect("admin/<?=$model_name;?>/list_item");
            }
        }

        if ($id > 0)
        {
            // edit mode
            $item = $this->self_model->get($id);
            $this->template->set("item",$item);
        }

        $this->template->set("edit_controller","admin/<?=$model_name;?>/edit_item/");
        $this->template->render("admin/<?=$model_name;?>/<?=$model_name;?>_edit");
        
    }

    public function del_item($id = NULL)
    {
        if ($id > 0)
        {
            $this->self_model->del($id);
        }
        redirect("admin/<?=$model_name;?>/list_item");
    }

}

/* End of file <?=$model_name;?>.php */
/* Location: ./application/controllers/admin/<?=$model_name;?>.php */
