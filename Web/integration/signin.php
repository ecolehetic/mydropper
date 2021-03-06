<?php include('header.php'); ?>
<html>
	<body>

		<div id="formHome">
			<img src='../assets/images/myDropper-logo.png' id="logo" alt="logo MyDropper">
			<h2>Store your data, save time, and reuse <br>
			it quickly in an effective way !</h2>
			<div class="containerHome">
					<form action="" id="inscriptionForm">
						<div class="form-group">
				            <label for="username">Username</label>
				            <input type="text" name="username" placeholder="Username"
				                   value="{{ values.username ? values.username : '' }}" required/>
				        </div>

				        <div class="form-group">
				            <label for="firstname">Firstname</label>
				            <input type="text" name="firstname" placeholder="FirstName"
				                   value="{{ values.firstname ? values.firstname : '' }}" required/>
				        </div>

				        <div class="form-group">
				            <label for="lastname">Lastname</label>
				            <input type="text" name="lastname" placeholder="Lastname"
				                   value="{{ values.lastname ? values.lastname : '' }}" required/>
				        </div>

				        <div class="form-group">
				            <label for="mail">Mail</label>
				            <input type="email" name="mail" placeholder="Mail" value="{{ values.mail ? values.mail : '' }}" required/>
				        </div>

				        <div class="form-group">
				            <label for="birthday">Birthday</label>
				            <input type="date" name="birthday" placeholder="birthday"
				                   value="{{ values.birthday ? values.birthday : '' }}" required/>
				        </div>

				        <div class="form-group">
				            <label for="avatar">Avatar</label>
				            <input type="file" name="avatar">
				        </div>

				        <div class="form-group">
				            <label for="password_1">Password</label>
				            <input type="password" name="password_1" placeholder="Password" required/>
				        </div>

				        <div class="form-group">
				            <label for="password_2">Password check</label>
				            <input type="password" name="password_2" placeholder="Repeat password" required/>
				        </div>

                        <div class="form-group">
                            <input type="submit" class="hidden" value="Subscribe"/>
							<a href="#" class="button submitBtn" id="submitInscriptionForm">
					            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
			                        <line class="top" x1="0" y1="0" x2="465" y2="0" />
			                        <line class="left" x1="0" y1="50" x2="0" y2="-100" />
			                        <line class="bottom" x1="155" y1="50" x2="-310" y2="50" />
			                        <line class="right" x1="155" y1="0" x2="155" y2="150" />
			                    </svg>
			                    <span>Sign In</span>
		                    </a>
				        </div>
				</form>
				<p>Already have an account?  Please <a href="login.php">log in</a>.</p>
			</div>
		</div>
	    <!-- JAVASCIRPT -->
	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.transit/0.9.9/jquery.transit.min.js"></script>
	    <script type="text/javascript" src="../assets/js/scripts.js"></script>
	    <script type="text/javascript" src="../assets/js/authentification.js"></script>
	</body>

</html>
