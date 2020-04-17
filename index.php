<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Todos</title>
	<!-- custom css  -->
	<link rel="stylesheet" href="assets/style.css"> 
</head>
<body>
	
	<div class="container">
		
			<h1>todos</h1>
			<div class="todos-box">
				<div class="input-area">
					<img id="drop-img" src="assets/next.png" alt="">
					<input type="text" id="input-todo" placeholder="What needs to be done?">
				</div>
				
				<div id="lists">








					
				</div>

				<div class="footer" id="footer-area">
					<div id="total-remaining"><span id="rem-val">0</span> items left</div>
					<div id="footer-menu" class="menu">
						<ul>
							<li id="all"  class="">All</li>
							<li id="active" class="" >Active</li>
							<li id="completed" class="" >Completed</li>
						</ul>
					</div>
					<div id="clear_complete" class="">Clear completed</div>

					<span class="border"></span>
				</div>
			</div>
		
	</div>

<!-- jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="assets/custom.js"></script>
</body>
</html>