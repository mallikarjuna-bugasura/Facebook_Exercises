<div class="mypage-header">

	<!-- Left section: logo and search input -->
	<div class="header-left">
		<img src="./images/logo.svg" alt="logo image" class="logo">
		<input type="text" class="fb-search" placeholder="Search Facebook">
	</div>

	<!-- Middle section: navigation icons -->
	<div class="header-middle">
		<span class="edit-styles ui-hovers">
			<img src="./images/home.svg" alt="home image" class="edit-styles-img">
		</span>
		<span class="edit-styles ui-hovers middle-icons">
			<img src="./images/insta.svg" alt="insta image" class="edit-styles-img">
		</span>
		<span class="edit-styles ui-hovers middle-icons">
			<img src="./images/market.svg" alt="marketplace image" class="edit-styles-img">
		</span>
		<span class="edit-styles ui-hovers middle-last">
			<img src="./images/friends.svg" alt="friends icon" class="edit-styles-img">
		</span>
		<span class="edit-styles ui-hovers middle-last">
			<img src="./images/gaming.svg" alt="gaming image" class="edit-styles-img">
		</span>
	</div>

	<!-- Right section: user profile, menu, messages, notifications -->
	<div class="profile-details">
		<span class="header-end">
			<img src="./images/menu.svg" class="header-end-img">
		</span>
		<span class="header-end">
			<img src="./images/message.svg" class="header-end-img">
		</span>
		<span class="header-end">
			<img src="./images/noti.svg" class="header-end-img">
		</span>

		<!-- Profile dropdown -->
		<span class="profiles profile-wrapper header-end">
			<img src="<?= $logged_user_image ?>" class="right-icons profile-icon dropdown-btn" height="40" width="40">
			<img src="./images/drop.svg" class="drop-icon dropdown-btn">
			<ul class="dropdown-menu-profile">

				<!-- Profile card -->
				<li class="profile-card dorpdown-lists">
					<a href="#" id="edit_profile_btn" class="dorpdown-content">
						<img src="<?= $logged_user_image ?>" class="dp">
						<span><?= $logged_user_name ?></span>
					</a>
				</li>

				<!-- Settings and other menu options -->
				<li class="dorpdown-lists">
					<img src="./images/settings.svg" class="icon">
					<a href="#" class="dorpdown-content">Settings & privacy</a>
				</li>
				<li class="dorpdown-lists">
					<img src="./images/help.svg" class="icon">
					<a href="#" class="dorpdown-content">Help & support</a>
				</li>
				<li class="dorpdown-lists">
					<img src="./images/display.svg" class="icon">
					<a href="#" class="dorpdown-content">Display & accessibility</a>
				</li>

				<!-- Logout button -->
				<li class="dorpdown-lists">
					<form action="logout.php" method="POST">
						<button type="submit" class="logout-btn">
							<img src="./images/logout.png" class="icon"> Log out
						</button>
					</form>
				</li>
			</ul>
		</span>
	</div>
</div>
