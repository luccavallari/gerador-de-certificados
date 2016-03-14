<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		//load language
		$this->lang->load('admin_lang', config_item('language'));
		$d = array();
		//if session was not started
		//redirect to /login
		//
		if( $this->session->id == "" && $this->uri->segment(2) != "login")
			redirect('admin/login','refresh');
		$this->data[] = "";
	}
	public function login(){
		if( $this->session->id != "" )
			redirect('admin','refresh');
		$d = array();
		//do login
		if ( $this->input->post('username') != "" ){
			//verify user exists
			$userdata = $this->crud->get('admin', array( 'user' => $this->input->post('username'), 'password' => sha1( $this->input->post('password') ) ));
			if( count($userdata) > 0 ){
				$this->session->set_userdata('id',$userdata[0]->id);
				redirect('admin', 'refresh');
			}else{
				$d['error'] = $this->lang->line('login_no_exists');
			}
		}
		$this->load->view('login', $d);
	}
	public function index()
	{
		$this->template->load('default', 'admin/index');
	}
	public function logout()
	{	
		$this->session->sess_destroy();
		redirect('admin/login', 'refresh');
	}
	public function courses($id = NULL, $action = NULL){
		if( $id != NULL )
		{
			$id = intval($id);
			//load data to edit
			$this->data['course_edit'] = $this->crud->get('courses', array('id' => $id));
			if( count( $this->data['course_edit'] ) <= 0)
			{
				redirect('admin/courses','location');
			}
		}
		if( $this->input->post('description') != "" )
		{
			//edit
			if( $id != NULL )
			{
				$d = $this->input->post();
				$id = intval($id);
				if( $this->crud->update('courses', $d, array('id' => $id)) > 0 )
				{
					$this->session->set_flashdata('success', $this->lang->line('edit_success_message'));
				}
				else
				{
					$this->session->set_flashdata('danger', $this->lang->line('error'));
				}
			}
			else
			{
				//add new
				$d = $this->input->post();
				if( $this->crud->insert('courses', $d) > 0 )
				{
					$this->session->set_flashdata('success', $this->lang->line('add_success_message'));
				}
				else
				{
					$this->session->set_flashdata('danger', $this->lang->line('add_danger_message'));
				}
			}
			redirect('admin/courses','location'); //location - to clear post data.
		}
		// delete action
		elseif( $action === "remove" ) 
		{
			$id = intval($id);
			if ($id > 0)
			{
				$this->crud->delete('courses', array('id' => $id));
				//table students_course manual cascade delete
				$this->crud->delete('students_course', array('id_course' => $id));
				$this->session->set_flashdata('success', $this->lang->line('delete_success_message'));
			}
			else
			{
				$this->session->set_flashdata('success', $this->lang->line('error_message'));
			}
			redirect('admin/courses','location');
		}
		//get courses
		$this->data['courses'] = $this->crud->get('courses', array(), 0, array('description' => 'ASC'));
		$this->template->load('default', 'admin/courses', $this->data);
	}
	/**
	 * Faz upload das imagens e mostra upload.
	 * @author MARQUARDT, William <williammqt@gmail.com> (2015-12-08)
	 */
	public function courses_images( $course_id = NULL ){
		
		if(	$course_id == NULL ):
			$this->session->set_flashdata('danger', $this->lang->line('error_message'));
			redirect('admin/courses', 'refresh');
		endif;
		//acao de adicionar imagens
		if( $course_id === "add" ):
			//define configuraçoes e abre lib de upload
			$config['upload_path']          = FCPATH.'media';
	        $config['allowed_types']        = 'gif|jpg|png';
	        $config['max_size']             = 10000;
	        $config['max_width']            = 5000;
	        $config['max_height']           = 5000;
	        $config['encrypt_name']			= true;
	        $this->load->library('upload', $config);

			$d = $this->input->post();

			//verifica se existe mais do que o limite de imagens para o tipo.
			$limit = 5;
			$count_images = $this->crud->count('courses_images', array('id_course' => $d['id_course'], 'type' => $d['type']));
			if( $limit <= $count_images ){
				$this->session->set_flashdata('danger', $this->lang->line('limit_exceded'));
				redirect('admin/courses_images/'.$d['id_course'], 'refresh');
			}
			if ( ! $this->upload->do_upload('name'))
            {
            	$this->session->set_flashdata('danger',$this->upload->display_errors());
            	redirect(base_url('admin/courses_images/'.$d['id_course']),'refresh');
            }
            else
            {
            	//fez o upload
            	//obtem dados para gravar no bd.
            	$cad['name'] =  $this->upload->data('file_name');
            	$cad['id_course'] = $d['id_course'];
            	$cad['type'] = $d['type'];
            	//arruma imagem
            	$config['image_library'] = 'gd2';
				$config['source_image'] = $this->upload->data('full_path');
				$config['create_thumb'] = false;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 350;
				$config['height'] = 350;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
            	$this->crud->insert('courses_images', $cad);
            	$this->session->set_flashdata('success', $this->lang->line('add_success_message'));
				redirect('admin/courses_images/'.$d['id_course'], 'refresh');
            }
		else:
			$this->data['course'] = $this->crud->get('courses', array('id' => $course_id));
			if( count($this->data['course']) == 0 ):
				$this->session->set_flashdata('danger', $this->lang->line('nothing_found'));
				redirect('admin/courses', 'refresh');
			endif;
			//prefiro passar como arrays separadas.
			$this->data['images_singnature'] = $this->crud->get('courses_images', array('id_course' => $course_id, 'type' => 'singnature'));
			$this->data['images_logo'] = $this->crud->get('courses_images', array('id_course' => $course_id, 'type' => 'logo'));
			$this->template->load('default', 'admin/courses_images', $this->data);
		endif;
	}
	public function courses_images_remove($id_course = NULL, $id_image = NULL){
		if($id_course != NULL && $id_image != NULL):
			//select image;
			$im = $this->crud->get('courses_images', array('id_course' => $id_course, 'id' => $id_image));
			if( count($im) > 0 ):
				@unlink(FCPATH.'media/'.$im[0]->name);
				$this->crud->delete('courses_images', array('id_course' => $id_course, 'id' => $id_image));
				$this->session->set_flashdata('success', 'delete_success_message');
				redirect('admin/courses_images/'.$id_course, 'refresh');
			else:
				$this->session->set_flashdata('danger', $this->lang->line('nothing_found'));
				redirect('admin/courses_images/'.$id_course, 'refresh');
			endif;
			
		else:
			$this->session->set_flashdata('danger', $this->lang->line('error_message'));
			redirect('admin/courses', 'refresh');
		endif;
	}
	public function students($id = NULL, $action = NULL){
		if( $id != NULL )
		{
			$id = intval($id);
			//load data to edit
			$this->data['student_edit'] = $this->crud->get('students', array('id' => $id));
			if( count( $this->data['student_edit'] ) <= 0)
			{
				redirect('admin/students','location');
			}
		}
		if( $this->input->post('name') != "" )
		{
			//edit
			if( $id != NULL )
			{
				$d = $this->input->post();
				$id = intval($id);
				if( $this->crud->update('students', $d, array('id' => $id)) > 0 )
				{
					$this->session->set_flashdata('success', $this->lang->line('edit_success_message'));
				}
				else
				{
					$this->session->set_flashdata('danger', $this->lang->line('error'));
				}
			}
			else
			{
				//add new
				$d = $this->input->post();
				if( $this->crud->insert('students', $d) > 0 )
				{
					$this->session->set_flashdata('success', $this->lang->line('add_success_message'));
				}
				else
				{
					$this->session->set_flashdata('danger', $this->lang->line('add_danger_message'));
				}
			}
			redirect('admin/students','location'); //location - to clear post data.
		}
		// delete action
		elseif( $action === "remove" ) 
		{
			$id = intval($id);
			if ($id > 0)
			{
				$this->crud->delete('students', array('id' => $id));
				//table students_course manual cascade delete
				$this->crud->delete('students_course', array('id_student' => $id));
				$this->session->set_flashdata('success', $this->lang->line('delete_success_message'));
			}
			else
			{
				$this->session->set_flashdata('success', $this->lang->line('error_message'));
			}
			redirect('admin/students','location');
		}
		//get students
		$this->data['students'] = $this->crud->get('students', array(), 0, array('name' => 'ASC'));
		$this->template->load('default', 'admin/students', $this->data);
	}
	public function my_info(){
		if( $this->input->post('company_name')  != "" )
		{
			$d['company_name'] = $this->input->post('company_name');
			$d['company_state'] = $this->input->post('company_state');
			$d['company_city'] = $this->input->post('company_city');
			$this->crud->update('admin', $d, array('id' => $this->session->id));
			$this->session->set_flashdata('success', $this->lang->line('edit_success_message'));
			redirect('admin/my_info','location');
		}
		if( $this->input->post('old_pass')  != "" )
		{
			//verify current pass
			if( $this->crud->count('admin', array('password' => sha1($this->input->post('old_pass')) , 'id' => $this->session->id) ) <= 0)
			{
				$this->session->set_flashdata('danger', $this->lang->line('incorrect_password'));
				redirect('admin/my_info','location');
			}
			//check new passord
			if ( trim($this->input->post('new_pass'))  == ""  || strlen(($this->input->post('new_pass'))) < 3 ) 
			{
				$this->session->set_flashdata('danger', $this->lang->line('invalid_new_password'));
				redirect('admin/my_info','location');
			}
			//if passwords don't match
			if( $this->input->post('new_pass') != $this->input->post('new_pass2') )
			{
				$this->session->set_flashdata('danger', $this->lang->line('passwords_dont_match'));
				redirect('admin/my_info','location');
			}
			$this->crud->update('admin', array('password' => sha1($this->input->post('new_pass'))), array('id' => $this->session->id)  );
			$this->session->set_flashdata('success', $this->lang->line('edit_success_message'));
		}
		$this->data['admin_data'] = $this->crud->get('admin', array('id' => $this->session->id));
		$this->template->load('default', 'admin/my_info', $this->data);
	}
	public function classes(){
		$this->data['courses'] = $this->crud->get('courses', array(), 0, array('description' => 'ASC'));
		$this->data['admin_data'] = $this->crud->get('admin', array('id' => $this->session->id));
		$this->template->load('default', 'admin/classes', $this->data);
	}
	public function add_students_class(){
		$d = $this->input->post();
		$d['id_student_ar'] = json_decode($d['id_student_ar']);
		$i = 0;
		$add = array();
		foreach ($d['id_student_ar'] as $st) {
			$add[$i]['id_course'] = $d['id_course']; 
			$add[$i]['id_student'] = $st; 
			$i = $i + 1;
		}
		if ( count($add) > 0)
			$this->crud->insert_batch('students_course', $add);
		$this->session->set_flashdata('success', $this->lang->line('edit_success_message'));
		redirect(base_url('admin/classes'),'refresh');
	}
	public function remove_from_class($id = NULL){
		if($id != NULL):
			$id == intval($id);
			if($id > 0)
				$this->crud->delete('students_course', array('id' => $id)); 
			echo "ok";
			return true;
		endif;
	}
	function alter_cert_description(){
		$d = $this->input->post();
		//echo $d['long_description'];
		//update info
		$this->crud->update('courses', array('long_description' => $d['long_description']), array('id' => $d['id']) );
		$this->session->set_flashdata('success', $this->lang->line('edit_success_message'));
		redirect('admin/courses','refresh');
	}
	//functions developed for ajax
	public function get_classes( $id_class = NULL ){
		$r = "";
		if ( $id_class != NULL ):
			$id_class = intval($id_class);
			$r['course'] = $this->crud->get('courses', array('id' => $id_class));
			$j['students s'] = "s.id = sc.id_student";
			$w['sc.id_course'] = $id_class;
			$c = "s.*, sc.id as id_reg";
			$r['students_added'] = $this->crud->getJoined('students_course sc', $c, $j, $w,"", array('s.name' => 'ASC'));
			//i know.. its not the best pratice, but...
			$r['students_to_add'] = $this->crud->query("SELECT * FROM students s WHERE NOT EXISTS (SELECT id FROM students_course sc WHERE id_course=".$id_class." AND sc.id_student = s.id) ORDER BY s.name ASC");
		endif; 
		echo json_encode($r);
	}
	/**
	 * Get custom description
	 * @author MARQUARDT, William <williammqt@gmail.com> (2015-12-04)
	 * @param  int $id_course id of course
	 * @return string
	 */
	function get_cert_description($id_course = NULL){
		$r = "";
		if( $id_course != NULL ):
			$id_course = intval($id_course);
			$res = $this->crud->get('courses',array('id' => $id_course),1,array(),'long_description');
			if($res[0]->long_description != null)
				$r = $res[0]->long_description;
		endif;
		echo $r;
	}	
}
/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */