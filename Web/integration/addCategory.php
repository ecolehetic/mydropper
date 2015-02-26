<?php include('header.php'); ?>
<?php include('aside.php'); ?>

    <!-- MAIN CONTENT -->
    <div class="container">
        <div id="addData">
            <h1>Add a category</h1>
            <form action="" class="formData">
                <div class="form-group">
                    <label for="dataName">Name :</label>
                    <input type="text" name="dataName" placeholder="dataName" required/>
                </div>

                <div class="form-group">
                    <input type="submit" class="hidden" value="addData"/>
                    <a href="#" id="submitPopIn" class="ghostBtn submitBtn clearfix">
                        <span>Validate</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

<?php include('footer.php'); ?>
