<?php 


	class Students extends CI_Controller{ 
		public function index(){
			$this->fetchStudents();
		}

		public function fetchStudents(){
			$this->load->model("model_students");
			$data['title'] = 'Student Management System';
			$data['students'] = $this->model_students->getStudentList();
			$this->load->view('view_students', $data);
		}

		//Agregar estudiante
		public function addStudentView(){
			$this->load->helper('form');
			$this->load->view('view_add_student');
		}

		public function addStudent(){
            $this->load->model("model_students");
            
			foreach ($_POST['interests'] as $interest){
			        $checkedIntr[] = $interest;
			    }   $finalIntr = implode(',', $checkedIntr);



			$data = array('rno' => $this->input->post('rno'),
				'name' => $this->input->post('name'),
				'res_add' => $this->input->post('res_add'),
				'gender' => $this->input->post('gender'),
				'passing_year' => $this->input->post('passing_year'),
				'interests' => $finalIntr
				);

			$this->model_students->addStudent($data);
			$this->fetchStudents();
	
		}



		//Editar Estudiante
		public function editStudentView() { 
	        $this->load->helper('form'); 
	        $rno = $this->uri->segment('3'); 
	        $query = $this->db->get_where("students",array("rno"=>$rno));
	        $data['current'] = $query->result();
	        $data['old_rno'] = $rno; 
	        $this->load->view('view_edit_student', $data); 
      	} 

      	public function editStudent(){ 
	        $this->load->model('model_students');

			foreach ($_POST['interests'] as $interest){
			        $checkedIntr[] = $interest;
			    }   $finalIntr = implode(',', $checkedIntr);
				
	        $data = array('rno' => $this->input->post('rno'),
				'name' => $this->input->post('name'),
				'res_add' => $this->input->post('res_add'),
				'gender' => $this->input->post('gender'),
				'passing_year' => $this->input->post('passing_year'),
				'interests' => $finalIntr
				);

	        $old_rno = $this->input->post('old_rno'); 
	        $this->model_students->editStudent($data, $old_rno);
			$this->fetchStudents();
      } 
  		

  	 	public function deleteStudent(){
  	 		$this->load->model('model_students');
  	 		$rno = $this->uri->segment('3');
  	 		$this->model_students->deleteStudent($rno);
  	 		$this->fetchStudents();
  	 	}

	}

?>