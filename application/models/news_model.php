<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class News_model extends EXMY_Model {

    var $creator;

    function __construct()
    {
        parent::__construct();
        $this->creator = new CharField(array("maxlength" => 20));
    }

}


/* End of file news_model.php */
/* Location: /application/models/news_model.php */
