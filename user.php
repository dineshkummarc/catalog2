<?php include_once ('application/snippets/header.php'); ?>
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-2 desktopOnly"></div>
			<div class="col-md-8">
				<?php
				$userData = yaml::read('application/config/config.yml');
				if (isset($_POST['userModify'])) {
					userModify();
				}
				?>
				<h3>Your profile</h3>
				<div class="alert alert-info" role="alert">
					<ul class="mb-0">
						<li>Your username is <strong><?php echo $userData['username']; ?></strong>.</li>
						<?php
						if ($userData['nicename'] !== '') {
							echo '<li>Your "nice name" is <strong>'. $userData['nicename'] .'</strong>.</li>';
						} else {
							echo '<li>You haven\'t set up a "nice name" yet.</li>';
						}
						if ($userData['apikey'] !== '') {
							echo '<li>Your Google Books API Key is <code>'. $userData['apikey'] .'</code>.</li>';
						} else {
							echo '<li>Your Google Books API Key is not yet set.</li>';
						}
						?>
					</ul>
				</div>
				<form method="post" action="">
					<div class="form-group">
						<h6>Set a "nice name" for yourself</h6>
						<label for="nicename">Nice name <span>(will be displayed in the header menu)</span></label>
						<input class="form-control" type="text" name="nicename" id="nicename" />
					</div>
					<div class="form-group">
						<h6>Change your password</h6>
						<label for="password">Current password</label>
						<input class="form-control" type="password" name="password" id="password" />
					</div>
					<div class="form-group">
						<label for="passwordNew">New password</label>
						<input class="form-control" type="password" name="passwordNew" id="passwordNew" />
					</div>
					<div class="form-group">
						<label for="passwordNewConfirm">Confirm new password</label>
						<input class="form-control" type="password" name="passwordNewConfirm" id="passwordNewConfirm" />
					</div>
					<div class="form-group">
						<h6>Modify your Google Books API Key</h6>
						<label for="apikey">New Google Books API Key</span></label>
						<input class="form-control" type="text" name="apikeyNew" id="apikeyNew" />
					</div>
					<div class="form-group">
						<input class="btn btn-primary" type="submit" name="userModify" value="Save modifications" />
					</div>
				</form>
			</div>
			<div class="col-md-2 desktopOnly"></div>
		</div>

	</div>
</div>
<?php include_once ('application/snippets/footer.php'); ?>
