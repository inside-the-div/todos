<?php 
	

	// ini_set('memory_limit', '-1');

	require '../vendor/autoload.php';
	use Todos\Database;

	class CLS_Todos extends Database{


		public function todos(){
			return $this->select("*")->from("todos")->get();
		}

		public function store($data){
			$val = [
				'text' => $data
			];
			return $this->insert("todos")->values($val)->get();
		}

		public function delete_todo($id){
			$con = 'id = '.$id;
			return $this->delete("todos")->where($con)->get();
		}


		public function delete_completed(){
			$con = 'status = 1';
			return $this->delete("todos")->where($con)->get();
		}


		public function update_todo_text($id,$val){
			$val = [
				'text' => $val
			];
			$con = 'id = '.$id;

			return $this->update("todos")->set($val)->where($con)->get();
		}


		public function update_status($id,$status){
			$val = [
				'status' => $status
			];
			$con = 'id = '.$id;
			return $this->update("todos")->set($val)->where($con)->get();
		}




	}



// show all todos 
	if(isset($_POST['method']) && $_POST['method'] == 'showAll'){

		$todo = new CLS_Todos;
		$todos = $todo->todos(); 
		$html = '';

		if(mysqli_num_rows($todos) > 0){
			while($todo = mysqli_fetch_array($todos)){

				if($todo['status'] == 1){
					$html  .= '<div class="todo" data-complete="1">
										<label class="container-checkbox">
										  <input checked data-complete="1" class="check-box" type="checkbox" data-todoId="'.$todo['id'].'">
										  <span class="checkmark" ></span>
										</label>
										<span contenteditable="true" class="text del" data-todoId="'.$todo['id'].'">'.$todo['text'].'</span>
										<span class="remove" data-todoId="'.$todo['id'].'">x</span>
									</div>';
				}else{
					$html  .= '<div class="todo" data-complete="0">
										<label class="container-checkbox">
										  <input data-complete="0" class="check-box" type="checkbox" data-todoId="'.$todo['id'].'">
										  <span class="checkmark" ></span>
										</label>
										<span contenteditable="true" class="text" data-todoId="'.$todo['id'].'">'.$todo['text'].'</span>
										<span class="remove" data-todoId="'.$todo['id'].'">x</span>
									</div>';
				}

			}
			echo $html;
		}

	}


// add todos 

	if(isset($_POST['method']) && $_POST['method'] == 'addTodo'){
		$todo = new CLS_Todos;
		$value = $_POST['value']; 
		$insert = $todo->store($value);
		if($insert){
			echo "success";
		}else{
			echo "error";
		}
	}

// update todo status 
	if(isset($_POST['method']) && $_POST['method'] == 'updateTodo'){
		$todo = new CLS_Todos;
		$id = $_POST['id']; 
		$status = $_POST['status'];

		$update = $todo->update_status($id,$status);
		if($update){
			echo "success";
		}else{
			echo "error";
		}

		
	}

// update todo text 

	if(isset($_POST['method']) && $_POST['method'] == 'updateTodoText'){
		$todo = new CLS_Todos;
		$id = $_POST['id']; 
		$text = $_POST['value'];

		$update = $todo->update_todo_text($id,$text);
		if($update){
			echo "success";
		}else{
			echo "error";
		}
		
	}
// delete todo text 

	if(isset($_POST['method']) && $_POST['method'] == 'DeleteTodo'){
		$todo = new CLS_Todos;
		$id = $_POST['id']; 
		
		$delete = $todo->delete_todo($id);
		if($delete){
			echo "success";
		}else{
			echo "error";
		}
		
	}
// DeleteCompleted todos

	if(isset($_POST['method']) && $_POST['method'] == 'DeleteCompleted'){
		$todo = new CLS_Todos;
		 
		
		$delete = $todo->delete_completed($id);
		if($update){
			echo "success";
		}else{
			echo "error";
		}
		
	}


	 
	 


?>