<?php $title="New Baste | VDBP"; ?>
<?php $currentPage="newbaste"; ?>
<?php include_once("res/php/header.php"); ?>
<?php include_once("res/php/navbar.php"); ?>
<?php include_once("res/php/functions.inc.php"); ?>


<!-- Main Page Content -->
<div class="container">

    <!-- Welcome Greeting -->
    <div class="row">
        <div class="col-12 mt-5 align-items-center">
            <h1 class="text-center">New Baste</h1>
        </div>
    </div>
    <!-- End Welcome Greeting -->


    <form class="mt-5" action="res/php/newbaste.inc.php" method="POST">
        <div class="form-group">
            <label for="basteName">Baste Name</label>
            <input type="text" class="form-control" id="basteName" name="basteName" placeholder="Enter Baste Name">
        </div>
        <div class="form-group">
            <label for="basteContents">Baste Contents</label>
            <textarea class="form-control" id="basteContents" name="basteContents" rows="3"></textarea>
        </div>
        <div class="form-group" <?php if($user["IsPremium"] == 0) {echo "disabled";} ?>>
            <label for="basteVisibility">Visibility</label>
            <select class="form-control" id="basteVisibility" name="basteVisibility" <?php if($user["IsPremium"] == 0) {echo "disabled";} ?>>
                <option default value="2">Public</option>
                <option value="1">Unlisted</option>
                <option value="0">Private</option>
            </select>
        </div>
        <div class="form-group" <?php if($user["IsPremium"] == 0) {echo "disabled";} ?>>
            <label for="basteType">Expires?</label>
            <input type="checkbox" class="form-control" id="BasteExpires" name="BasteExpires" <?php if($user["IsPremium"] == 0) {echo "disabled";} ?>>
            <input type="date" class="form-control" id="basteExpiresAt" name="basteExpiresAt" placeholder="DD-MM-YYYY" <?php if($user["IsPremium"] == 0) {echo "disabled";} ?>>
        </div>
        <div class="form-group">
            <label for="basteType">Baste Subcategory</label>
            <select class="form-control" id="basteSubcategory" name="basteSubcategory">
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>