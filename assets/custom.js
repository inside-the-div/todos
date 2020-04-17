$(document).ready(function(){




// add and remove active class to menu (footer)
	var lis = $("#footer-menu ul li");
	for(var i = 0; i<lis.length; i++){
		if(i==0){
			$(lis[i]).addClass('active');
		}
	}
	function removeActiveClass(){
		for(var i = 0; i<lis.length; i++){
			 $(lis[i]).removeClass('active');
		}
	}
// end process



//  footer menu click operations ============
	$("#all").click(function (){
		removeActiveClass(); 
		$(this).addClass('active');
		showAll(); // show all todos
	})
	$("#active").click(function (){
		removeActiveClass(); 
		$(this).addClass('active');
		showActive(); // show active todos
	})
	$("#completed").click(function (){
		removeActiveClass(); 
		$(this).addClass('active');
		showCompletedTodos();
	})

	$("#clear_complete").click(function (){
		removeALlCompletedTodos(); // remove compreted todos from Front-end
		deleteCompletedTodos() // delete all compreted todos form database
	})

// end process ======




	var totalActiveTodos = $("#rem-val"); // total active todos element
	showAllTodos(); // show all todos





// add new todo when press enter button
	$('#input-todo').keyup(function(e){
	    if(e.which == '13'){
	       var value = $(this).val();

	       if(value != ''){
	       	$(this).val(''); // make input field empty 

	       	var method = 'addTodo';
	       	$.ajax({  
	       	  url:"script/CLS_Todos.php",  
	       	  method:"POST",  
	       	  data:{method:method,value:value},  
	       	  success:function(data){  
	       	    showAllTodos();
	       	  }  
	       	})
	       }
	       e.preventDefault();
	    }
	});
// =========== end process ============



// menu show based on total todos 
function totalTodos(){
	var todos = $(document).find('.todo');
	
	for(var i = 0; i< todos.length; i++){
		if($(todos[i]).attr('data-complete') == 1){
			$("#clear_complete").show();
			break;
		}else{
			$("#clear_complete").hide();
		}
	}

	if(todos.length <= 0){
		$("#footer-area").hide();
		$("#lists").hide();
		removeActiveClass();
		$("#all").addClass('active');
		$("#drop-img").hide();
	}else{
		$("#footer-area").show();
		$("#lists").show();
		$("#drop-img").show();

	}
}
// end process

// ===== count remaining todos and set to the area ====== 
	function countActiveTodo(){
		var todos = $(document).find('.todo');
		var count = 0;
		for(var i = 0; i< todos.length; i++){
			if($(todos[i]).attr('data-complete') == 0){
				count++;
			}
		}
		totalActiveTodos.html(count);
	}
// end precess



// show all todos and after show count active todos
	function showAllTodos(){
		var method = 'showAll';
		$.ajax({  
		  url:"script/CLS_Todos.php",  
		  method:"POST",  
		  data:{method:method},  
		  success:function(data){  
		    $('#lists').html(data);
		    countActiveTodo(); // count active todos
		    totalTodos();
		  }  
		})
	}
// end process







	function showAll(){
		var todos = $(document).find('.todo');
		for(var i = 0; i< todos.length; i++){
			$(todos[i]).show();
		}
	}
	 function showActive(){

	 	showAll();  // first show all todos
		 var todos = $(document).find('.todo');
		 for(var i = 0; i< todos.length; i++){
		 	if($(todos[i]).attr('data-complete') == '1'){
		 		$(todos[i]).hide();
		 	}
		 }
	 }

	 function showCompletedTodos(){
	 	showAll();// first show all todos
	 	var todos = $(document).find('.todo');
	 	for(var i = 0; i< todos.length; i++){
	 		if($(todos[i]).attr('data-complete') == 0){
	 			$(todos[i]).hide();
	 		}
	 	}
	 }



	 function removeALlCompletedTodos(){
	 	showAll();// first show all todos
	 	var todos = $(document).find('.todo');
	 	for(var i = 0; i< todos.length; i++){
	 		if($(todos[i]).attr('data-complete') == 1){
	 			$(todos[i]).hide();
	 		}
	 	}
	 	removeActiveClass();
	 	$("#all").addClass('active');
	 }

// update status of todos 
	 function updateStatus(operation,id){
	 	var status = 0;
	 	var id = id;
	 	if(operation == 'complete'){
	 		status = 1;
	 	}else{
	 		status = 0;
	 	}
	 	var method = 'updateTodo';

	 	$.ajax({  
	 	  url:"script/CLS_Todos.php",  
	 	  method:"POST",  
	 	  data:{method:method,id:id,status:status},  
	 	  success:function(data){  
	 	    countActiveTodo(); // count active todos
	 	    totalTodos();
	 	  }  
	 	})

	 }
// end process ==========



// update todos =============
	 function updateTodo(id,value){
	 	// send ajax call with id and value
	 	var method = 'updateTodoText';
	 	$.ajax({  
	 	  url:"script/CLS_Todos.php",  
	 	  method:"POST",  
	 	  data:{method:method,id:id,value:value},  
	 	  success:function(data){
	 	    countActiveTodo(); // count active todos
	 	    totalTodos();
	 	  }  
	 	})
	 }
// end precess ===========



// delete single todo
	 function deleteTodo(id){

	 	// send ajax call with id
	 	var method = 'DeleteTodo';
	 	$.ajax({  
	 	  url:"script/CLS_Todos.php",  
	 	  method:"POST",  
	 	  data:{method:method,id:id},  
	 	  success:function(data){
	 	  	showAllTodos(); 
	 	  }  
	 	})
	 }
// end precess =========



// delete all completed todos
	 function deleteCompletedTodos(){
	 	
	 	var method = 'DeleteCompleted';
	 	$.ajax({  
	 	  url:"script/CLS_Todos.php",  
	 	  method:"POST",  
	 	  data:{method:method},  
	 	  success:function(data){
	 	  	showAllTodos();

	 	  }  
	 	})

	 }
// end process



// operation when click on the check box;
	$(document).on("click", ".check-box", function() {

		var todoId = $(this).data('todoid');
		var remVal = Number(totalActiveTodos.html());

		if($(this).prop("checked") == true){

			updateStatus('complete',todoId); // update todo's status 
			$(this).parents('.todo').attr('data-complete','1');
			totalActiveTodos.html(remVal - 1); // update total remaining items 

		}else{

			$(this).parents('.todo').attr('data-complete','0');
			updateStatus('active',todoId); // update todo's status 
			totalActiveTodos.html(remVal + 1); // update total remaining items 

		}

		var checkbox = $(this);
		var parent = checkbox.parent();
		var text = checkbox.parent().next('.text').eq(0);
		text.toggleClass('del'); // add del class for completed design

		

	})
// end precess


// edit and update todo
	$(document).on("blur", ".text", function() {
		var value = $(this).html();
		var id = $(this).data('todoid');
		updateTodo(id,value);
	})
// end process 


// delete todis 
	$(document).on("click", ".remove", function() {
		var todoId = $(this).data('todoid');
		deleteTodo(todoId);
	})
// end process

	


})