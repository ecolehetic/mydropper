<?php include('header.php'); ?>
<html>
	<body>

		<div id="homePage" class="loginPage">
			<img src='../assets/images/myDropper-logo.png' id="logo" alt="logo MyDropper">
			<h2>Store your data, save time, and reuse <br>
			it quickly in an effective way !</h2>
			<div class="container">
				<form action="" id="connexionForm">
					<div class="form-group">
			            <label for="username">Username</label>
			            <input type="text" name="username" value="" required/>
			        </div>
			        
					<div class="form-group">
			            <label for="Password">Password</label>
			            <input type="password" name="Password" value="" required/>
			        </div>
			        
					<div class="form-group">
						<input type="submit" class="hidden" value="Login"/>
						<a href="#" class="button submitBtn" id="submitConnexionForm">
				            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
		                        <line class="top" x1="0" y1="0" x2="465" y2="0" />
		                        <line class="left" x1="0" y1="50" x2="0" y2="-100" />
		                        <line class="bottom" x1="155" y1="50" x2="-310" y2="50" />
		                        <line class="right" x1="155" y1="0" x2="155" y2="150" />
		                    </svg>
		                    <span>Log In</span>
	                    </a>
			        </div>
				</form>
				<p>Don't have an account?  Please <a href="signin.php">sign in</a>.</p>
			</div>
		</div>
	    <!-- JAVASCIRPT -->
	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.transit/0.9.9/jquery.transit.min.js"></script>
	    <script type="text/javascript" src="../assets/js/scripts.js"></script>
	    <script type="text/javascript" src="../assets/js/authentification.js"></script>
	</body>

</html>

