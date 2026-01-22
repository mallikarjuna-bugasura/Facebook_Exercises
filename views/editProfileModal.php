<!-- Edit Profile Modal -->
<div id="edit_profile_modal" class="modal-overlay">
	<div class="modal-box">
		<h3>Edit Profile</h3>
		<form method="POST">
			<label>Name</label>
			<input type="text" name="name" value="<?= $edit_user['name'] ?>" class="form-control edit-input" required>
			<label>Email</label>
			<input type="email" name="email" value="<?= $edit_user['email_id'] ?>" class="form-control edit-input" required>
			<label>Phone</label>
			<input type="text" name="phone" value="<?= $edit_user['phone'] ?>" class="form-control edit-input">
			<label>Address</label>
			<input type="text" name="address" value="<?= $edit_user['address'] ?>" class="form-control edit-input">
			<div class="modal-actions">
				<button type="submit" name="update_profile" class="save-btn">Save Changes</button>
				<button type="button" id="close_modal" class="cancel-btn">Cancel</button>
			</div>
		</form>
	</div>
</div>