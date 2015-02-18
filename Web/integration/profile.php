<?php include('header.php'); ?>
<?php include('aside.php'); ?>

<div id="profilePageWrapper" class="container">
    <div id="profilePage">
        <div id="topContainer">
            <div class="text">
                <h1>HENG Patrick</h1>
                <h2>pat_sushi - 22 ans</h2>
            </div>

            <div id="avatarContainer">
                <img src="../assets/images/avatar-demo.jpg" alt="avatar"/>

                <a class="ghostBtn" href="#" id="editButton">
                    <span>Edit profile</span>
                </a>
            </div>
        </div>


        <div id="bottomContainer">
            <form action="" class="disabled" id="editForm">
                <div class="col">
                    <div class="form-group">
                        <label for="firstname">Firstname :</label>
                        <input type="text" name="firstname" placeholder="FirstName"
                               value="{{ values.firstname ? values.firstname : '' }}" disabled="disabled" required/>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname  :</label>
                        <input type="text" name="lastname" placeholder="Lastname"
                               value="{{ values.lastname ? values.lastname : '' }}" disabled="disabled" required/>
                    </div>
                    <div class="form-group">
                        <label for="mail">Mail :</label>
                        <input type="email" name="mail" placeholder="Mail" value="{{ values.mail ? values.mail : '' }}"
                               disabled="disabled" required/>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Date of Birth :</label>
                        <input class="date" type="date" name="birthday" placeholder="birthday"
                               value="{{ values.birthday ? values.birthday : '' }}" disabled="disabled" required/>
                    </div>
                </div>

                <div class="col clearfix">
                    <div class="form-group">
                        <label for="username">Username :</label>
                        <input type="text" name="username" placeholder="Username"
                               value="{{ values.username ? values.username : '' }}" disabled="disabled" required/>
                    </div>
                    <div class="form-group">
                        <label for="password_1">Password :</label>
                        <input type="password" name="password_1" placeholder="Password" disabled="disabled" required/>
                    </div>

                    <div class="form-group">
                        <label for="password_2">Password check :</label>
                        <input type="password" name="password_2" placeholder="Repeat password" disabled="disabled" required/>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="hidden" value="Edit"/>
                        <a href="#" id="submitEdit" class="ghostBtn submitBtn clearfix">
                            <span>Validate</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JAVASCIRPT -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script
        src="http://cdnjs.cloudflare.com/ajax/libs/jquery.transit/0.9.9/jquery.transit.min.js"></script>
<!--<script src="../assets/js/scripts.js"></script>-->
<script src="../assets/js/views/ui.js"></script>
<script src="../assets/js/controllers/mainCtrl.js"></script>
<script src="../assets/js/authentification.js"></script>
</body>
