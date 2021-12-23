<?php session_start();?>
<?php $title="New Baste | VDBP"; ?>
<?php $currentPage="newbaste"; ?>
<?php include("res/php/_authcheck.php"); ?>
<?php include("res/php/header.php"); ?>
<?php include("res/php/_connect.php"); ?>
<?php include("res/php/navbar.php"); ?>
<?php include("res/php/functions.inc.php"); ?>
<?php $user = GetUser($connect); ?>
<?php $baste = GetBaste($connect, $_GET["BasteID"]);?>

<!-- Main Page Content -->
<div class="container">

    <!-- Welcome Greeting -->
    <div class="row">
        <div class="col-12 mt-5 align-items-center">
            <h1 class="text-center">Edit Baste</h1>
        </div>
    </div>
    <!-- End Welcome Greeting -->


    <form class="mt-5" method="POST" id="newBasteForm">

        <div class="form-group">
            <label for="basteName">Baste Name</label>
            <input type="text" required class="form-control" id="basteName" name="basteName" value="<?php echo $baste["BasteName"];?>">
        </div>

        <div class="form-group">
            <label for="basteContents">Baste Contents</label>
            <pre><code><textarea class="form-control" id="basteContents" required name="basteContents" rows="3"><?php echo htmlspecialchars($baste["BasteContents"]);?></textarea></code></pre>
        </div>

        <div class="form-group">
            <label for="basteVisibility">Visibility</label>
            <select class="form-control" id="basteVisibility" name="basteVisibility"
                <?php if($user["IsPremium"] == 0) {echo "disabled";} ?>>
                <option <?php if($baste["Visibility"] == 2) {echo "default";} ?> value="2">Public</option>
                <option <?php if($baste["Visibility"] == 1) {echo "default";} ?> value="1">Unlisted</option>
                <option <?php if($baste["Visibility"] == 0) {echo "default";} ?> value="0">Private</option>
            </select>
        </div>

        <div class="form-group">
            <div class="col-4">
                <span class="input-group-addon">
                    <label for="basteExpiresAt">Expires?</label>
                </span>
                <span class="input-group-addon">
                    <input type="checkbox" id="basteExpiresCheck"<?php if($user["IsPremium"] == 0) {echo "disabled";} ?> <?php if($baste["ExpiresAt"] != null){echo "checked";}?>>
                </span>
            </div>
            <div class="col-8">
            <input type="date" id="basteExpiresAt" class="form-control" disabled value="<?php echo $baste["ExpiresAt"]?>">
            </div>
        </div>

        <div class="form-group">
            <span class="input-group-addon">
                <label for="bastePassword">Password?</label>
            </span>
            <span class="input-group-addon">
                <input id="bastePasswordRequired" type="checkbox"
                    <?php if($user["IsPremium"] == 0) {echo "disabled";}?>>
            </span>
            <input type="password" id="bastePassword" class="form-control" disabled>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>