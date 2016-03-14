<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Student extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('student', config_item('language'));
	}
	public function index()
	{
		$this->load->model('custom_model', 'cm');
		$d = $this->input->post();
		//search student.
		if( count( $d ) > 0 ):
			$s = $this->cm->getStudents($d['toverify']);
			if( count( $s ) > 0 )
			{
				//get email.
				$email = $s[0]->email;
				redirect('student/get_certificates/'.$email,'refresh');
			}
			else
			{
				$this->session->set_flashdata('danger', $this->lang->line('not_found'));
				redirect('','refresh');
			}
		endif;
		$this->load->view('student/index');
	}
	public function get_certificates($email = NULL)
	{
		if($email == NULL)
		{
			$this->session->set_flashdata('danger', $this->lang->line('not_found'));
			redirect('','refresh');
		}
		//validates e-mail sent
		if( $this->crud->count( 'students', array('email' => $email) ) < 1 ){
			$this->session->set_flashdata('danger', $this->lang->line('not_found'));
			redirect('','refresh');
		}
		//ok shows the courses
		//joins
		$j['students s'] = "sc.id_student = s.id";
		$j['courses c'] = "sc.id_course = c.id";
		//fields
		$f = "sc.id as id_class, c.description, c.id as id_course, s.id as id_student, s.email";
		//condition
		$w['s.email'] = $email;
		$data['courses'] = $this->crud->getJoined( 'students_course sc', $f, $j, $w, "", array( 'sc.id' => 'DESC' ) );
		$this->load->view('student/select_course', $data);
	}
	public function print_certificate($id_student = NULL, $id_course = NULL){
		$this->load->library('pdf');
		//validations
		if( $id_student == NULL || $id_course == NULL )
		{
			$this->session->set_flashdata('danger', $this->lang->line('not_found'));
			redirect('','refresh');
		}
		if( $this->crud->count( 'students_course' , array('id_student' => $id_student, 'id_course' => $id_course )  ) < 1)
		{
			$this->session->set_flashdata('danger', $this->lang->line('not_found'));
			redirect('','refresh');
		}
		//get course data
		////joins
		$j['students s'] = "sc.id_student = s.id";
		$j['courses c'] = "sc.id_course = c.id";
		//fields
		$f = "sc.id as id_class, c.description as course_name, c.long_description, c.id as id_course, s.id as id_student, s.email, s.name as student_name, c.date as course_date, c.time as course_time";
		//condition
		$w['s.id'] = $id_student;
		$w['c.id'] = $id_course;
		$data['courses'] = $this->crud->getJoined( 'students_course sc', $f, $j, $w );
		//joga o id do curso para um obj
		//para usar nos metodos privados de footer e header.
		$this->id_course = $id_course;
		$data['admin'] = $this->crud->get('admin');
		$data['img_singnatures'] = $this->crud->get('courses_images', array('id_course' => $this->id_course, 'type' => 'singnature'));
		$html=$this->load->view('certificate', $data, true);
		//echo $html;
		//this the the PDF filename that user will get to download
		$pdfFilePath = "certificate_".date('Ymd_His').".pdf";
		//envia L para imprimir em Landscape (paisagem) , para imprimir em modo retrato nao precisa passar nenhum parametro.
	    $pdf = $this->pdf->load("L");
	    //$pdf->SetHTMLFooter( $this->footer() ); 
	    $pdf->SetHTMLHeader( $this->header() ); 
	    $pdf->WriteHTML( $html ); // write the HTML into the PDF
	    $pdf->Output( $pdfFilePath, 'D' ); // save to file because we can
	}
	private function header(){
		$logos = $this->crud->get('courses_images', array('id_course' => $this->id_course, 'type' => 'logo'));
		if( count( $logos ) > 0 ):
			//se for apenas um mostra dos dois lados.
			if( count( $logos ) === 1 ):
				$header = '<div style="text-align: center; top: 50px; ">';
				$header .= "<table>";
					$header .= "<tr>";
						$header .= "<td width=20%><img style='width: 240px;  margin-top: 30px; margin-left: 30px; ' src='".base_url('media/'.$logos[0]->name)."'></td>";
						$header .= "<td style='text: align:center; padding-top: 140px;' width=60%><center><span style='font-size: 40px; margin-top: 30px; text-align:center;'>".strtoupper($this->lang->line('cert_title'))."</span></center></td>";
						$header .= "<td width=20%><img style='width: 240px ; margin-top: 30px; margin-rigth: 30px; ' src='".base_url('media/'.$logos[0]->name)."'></td>";
						$header .= "</tr>";
					$header .= "</table>";
				$header .= '</div>';
			elseif( count($logos) === 2):
				$header = '<div style="text-align: center; top: 50px; ">';
					$header .= "<table>";
						$header .= "<tr>";
							$header .= "<td width=20%><img style='width: 240px;  margin-top: 30px; margin-left: 30px; ' src='".base_url('media/'.$logos[0]->name)."'></td>";
							$header .= "<td style='text: align:center; padding-top: 140px;' width=60%><center><span style='font-size: 40px; margin-top: 30px; text-align:center;'>".strtoupper($this->lang->line('cert_title'))."</span></center></td>";
							$header .= "<td width=20%><img style='width: 240px ; margin-top: 30px; margin-rigth: 30px; ' src='".base_url('media/'.$logos[1]->name)."'></td>";
						$header .= "</tr>";
					$header .= "</table>";
				$header .= '</div>';
			else:
				///mais de 3..
				///faz um loop exibindo todos (visual nao testado)
				$header = '<div style="text-align: center; top: 50px; ">';
					$header .= "<table>";
						$header .= "<tr>";
							foreach ($logos as $l) 
							{
								$header .= "<td><img style='width: 240px;  margin-top: 30px; margin-left: 30px; ' src='".base_url('media/'.$l->name)."'></td>";
							}
						$header .= "</tr>";
					$header .= "</table>";
					$header .= "<center><span style='font-size: 40px;  text-align:center;'>".strtoupper($this->lang->line('cert_title'))."</span></center>";
				$header .= '</div>';
			endif;
		else:
			//Se nao for passado logo exibe cabecalho padrao
			$header = '<div style="text-align: center; top: 50px; ">';
			//titulo antigo - nao sera usado letra gotica - comentado porque ficava mais bonito.
			//$header .= '<br><br><center><span style="text-align: center; font-family: anglotext; font-size: 200px; color: #333;">'.$this->lang->line('cert_title').'</span></center>';
			$header .= '<br><br><br><br><center><span style="text-align: center; font-family: arial; font-size: 40px; color: #333;">'.strtoupper($this->lang->line('cert_title')).'</span></center>';
			$header .= '</div>';
		endif;
		return $header;
	}
	private function footer(){
		//$admin  = $this->crud->get('admin');
		//$footer = '<div style="text-align: center; top -20px; margin-top: -20px; ">';
		//$footer .= '<strong><center><span style="text-align: center; font-family: sans-serif; font-size: 16px; color: #333; font-weight: bolder;">'.$admin[0]->company_name.'</span></center></strong>';
		//$footer .= '</div>';
		$footer = "";
		return $footer;
	}
}
/* End of file Student.php */
/* Location: ./application/controllers/Student.php */