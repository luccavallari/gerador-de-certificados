<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function getStudents( $st = NULL )
	{
		if( $st != NULL && @$st != "" )
		{
			$this->db->from('students');
			$this->db->where('email', $st);
			$this->db->where('email !=', NULL);
			$this->db->or_where('doc', $st);
			$st2 = str_replace(".", '', $st);
			$st2 = str_replace("-", '', $st2);
			if( $st2 != "" )
			$this->db->or_where('doc', $st2);

			$r = $this->db->get();
			return $r->result();
		}
	}
}

/* End of file Custom_model.php */
/* Location: ./application/models/Custom_model.php */