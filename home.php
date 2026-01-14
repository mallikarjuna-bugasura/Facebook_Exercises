<?php
	session_start();

	// Prevent browser caching
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");

	// Redirect to login if user not logged in
	if (!isset($_SESSION['user_id'])) {
		header("Location: index.php");
		exit;
	}
	include 'config.php';

	// Fetch logged-in user details
	$loggedUserId = $_SESSION['user_id'];
	$loggedUserSql = "SELECT name, image_path 
						FROM tUser 
						WHERE user_id=$loggedUserId";
	$loggedUserRes = $conn->query($loggedUserSql);
	$loggedUser = $loggedUserRes->fetch_assoc();
	$loggedUserName = $loggedUser['name'];
	$loggedUserImage = $loggedUser['image_path'];

	// Determine which user's profile to view
	$viewUid = $loggedUserId;
	if (isset($_GET['uid'])) {
		$viewUid = intval($_GET['uid']);
	}

	// Fetch editable details of logged-in user
	$editSql = "SELECT name, email_id, phone, address 
				 FROM tUser 
				 WHERE user_id=$loggedUserId";
	$editRes = $conn->query($editSql);
	$editUser = $editRes->fetch_assoc();

	// Fetch details of the profile being viewed
	$viewUserSql = "SELECT name, image_path 
					  FROM tUser 
					  WHERE user_id=$viewUid";
	$viewUserRes = $conn->query($viewUserSql);
	$viewUser = $viewUserRes->fetch_assoc();
	$viewUserName = $viewUser['name'];
	$viewUserImage = $viewUser['image_path'];

	// Function to render a single post
	function renderPost($posts, $username, $image) {
		$formattedDate = date("d F Y", strtotime($posts['posting_date']));
		echo <<<HTML
			<div class="post-box">
				<div class="post-header">
					<img src="{$image}" alt="post user image" class="post-user">
					<div class="post-user-details">
						<div class="post-details">
							<a href="#" class="post-name">{$username}</a>
							<img src="./images/blue.svg" alt="blue icon image" class="posts-icon">
							<p class="post-date"><b>{$formattedDate}</b></p>
						</div>
						<div class="three-dots">
							<div class="dots-img">
								<img src="./images/dots.svg" alt="three dots image" class="three-dots-image">
							</div>
						</div>
					</div>
				</div>
				<div class="middle-content">
					<p>{$posts['post']}</p>
				</div>
				<div class="footer">
					<div class="footer-content">
						<div class="emojis">
							<img src="./images/like.svg" alt="like image" class="emoji-like-img emojis-images">
							<img src="./images/heart.svg" alt="heart image" class="emoji-heart-img emojis-images">
							<span class="comment-count">125k</span>
						</div>
						<div class="comment-count">
							<span>47.8k comments &nbsp; 13k shares</span>
						</div>
					</div>
					<div class="reactions">
						<div class="reaction-options ui-hovers">
							<div class="reaction-options-content">
								<span><i data-visualcompletion="css-img" class="likes-icons"></i></span>
								<a class="comment-count likes-content">Like</a>
							</div>
						</div>
						<div class="reaction-options ui-hovers">
							<div class="reaction-options-content">
								<span><i data-visualcompletion="css-img" class="comments-icons"></i></span>
								<div>
									<a class="comment-count likes-content">Comment</a>
								</div>
							</div>
						</div>
						<div class="reaction-options ui-hovers">
							<div class="reaction-options-content">
								<span><i data-visualcompletion="css-img" class="shares-icons"></i></span>
								<div>
									<a class="comment-count likes-content">Share</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		HTML;
	}

	// Fetch all posts of the viewed user
	$postSql = "SELECT * 
				 FROM tWall 
				 WHERE user_id=$viewUid
				 ORDER BY posting_date DESC";
	$allPosts = $conn->query($postSql);

	// Fetch friends of the viewed user
	$friendsSql = "SELECT u.user_id, u.name, u.image_path
					FROM tFriends f
					LEFT OUTER JOIN tUser u 
					ON u.user_id = f.friend_id
					WHERE f.user_id = $viewUid";
	$friendsRes = $conn->query($friendsSql);
	$friendsArr = [];
	while($friends = $friendsRes->fetch_assoc()){
		$friendsArr[] = $friends;
	}

	// Handle profile update
	if (isset($_POST['update_profile'])) {
		$name = $conn->real_escape_string($_POST['name']);
		$email = $conn->real_escape_string($_POST['email']);
		$phone = $conn->real_escape_string($_POST['phone']);
		$address = $conn->real_escape_string($_POST['address']);

		$updateSql = "UPDATE tUser 
					   SET name='$name', email_id='$email', phone='$phone', address='$address'
					   WHERE user_id=$loggedUserId";

		if ($conn->query($updateSql)) {
			header("Location: " . $_SERVER['PHP_SELF']);
			exit;
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>facebook</title>
		<link rel="icon" type="image/svg+xml" href="./images/logo.svg">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="home.css">
	</head>
	<body>
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
					<img src="<?= $loggedUserImage ?>" class="right-icons profile-icon dropdown-btn" height="40" width="40">
					<img src="./images/drop.svg" class="drop-icon dropdown-btn">
					<ul class="dropdown-menu-profile">

						<!-- Profile card -->
						<li class="profile-card dorpdown-lists">
							<a href="#" id="edit_profile_btn" class="dorpdown-content">
								<img src="<?= $loggedUserImage ?>" class="dp">
								<span><?= $loggedUserName ?></span>
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

		<!-- Header image / banner -->
		<div class="mypage-body">
			<div class="body-header">
				<img src="./images/main.png" class="profile">
			</div>
		</div>

		<!-- Main section with user details -->
		<div class="main">

			<!-- User cover/profile image -->
			<div>
				<img src="<?= $viewUserImage ?>" alt="user image" class="mark-image">
			</div>

			<!-- User info and actions -->
			<div class="user-section">
				<div class="top-row">

					<!-- User name and followers -->
					<div>
						<a href="#" class="user-name"><?= $viewUserName ?>
							<img src="./images/blue.svg" class="verify-icon">
						</a>
						<br>
						<div class="follow">
							<a class="followers">121M followers</a>
						</div>
					</div>

					<!-- Action buttons: Follow, Search, Dropdown -->
					<div class="buttons">
						<button class="btn follow-btn">
							<img src="./images/followbtn.png" class="icon-white">
							Follow
						</button>
						<button class="btn search-btn">
							<img src="./images/search.svg" class="icon-black" height="18" width="18">
							Search
						</button>
						<button class="btn drop-btn">
							<img src="./images/drop.svg" class="icon-drop" height="18" width="18">
						</button>
					</div>
				</div>

				<!-- User description and additional info -->
				<div class="user-info">
					<p class="user-description">Bringing the world closer together.</p>
					<p class="info-line">
						<img src="./images/public.svg" class="info-icon public-figure">
						<a href="#" class="info-line-content">Public figure</a> <span class="dots">.</span>
						<img src="./images/location.svg" class="info-icon icons">
						<a href="#" class="info-line-content">Palo Alto, California</a> <span class="dots">.</span>
						<img src="./images/meta.svg" class="info-icon meta-icon">
						<a href="#" class="info-line-content">Meta</a> <span class="dots">.</span>
						<img src="./images/education.svg" class="info-icon meta-icon">
						<a href="#" class="info-line-content">Harvard University</a>
					</p>

					<!-- <p><img src="./images/followings.png" class="followers-img"></p> -->
					<div class="followers-img">
						<?php foreach(array_slice($friendsArr, 0, 6) as $friend){ ?>
							<img src="<?= $friend['image_path'] ?>" alt="friend image" class="follow-img">
						<?php } ?>
						<img src="./images/photos1.jpeg" alt="photos1" class="follow-img">
						<img src="./images/photos2.jpeg" alt="photos2" class="follow-img">
						<img src="./images/photos3.jpeg" alt="photos3" class="follow-img">
						<img src="./images/photos4.jpg" alt="photos4" class="follow-img">
					</div>
				</div>
			</div>
		</div>
		<div class="body-tabs">

			<!-- Profile navigation tabs -->
			<ul class="nav nav-tabs body-tabs-list" role="tablist">
				<li class="active profile-tabs">
					<a href="#all" data-toggle="tab" class="body-tabs-content">All</a>
				</li>
				<li class="profile-tabs">
					<a href="#about" data-toggle="tab" class="body-tabs-content">About</a>
				</li>
				<li class="profile-tabs">
					<a href="#" data-toggle="tab" class="body-tabs-content">Photos</a>
				</li>
				<li class="body-tabs-hides profile-tabs">
					<a href="#friends" data-toggle="tab" class="body-tabs-content">Friends</a>
				</li>
				<li class="body-tabs-hides profile-tabs">
					<a href="#" data-toggle="tab" class="body-tabs-content">Reels</a>
				</li>
				<li class="profile-tabs">
					<a href="#" data-toggle="tab" class="body-tabs-content">More<span><img src="./images/more.svg" class="more-icon" alt="more"></span></a> 
				</li>

				<!-- Additional options button -->
				<button class="btn body-tabs-btn ui-hovers">
					<img src="./images/dots.svg" height="18" width="18">
				</button>
			</ul>
		</div>
		<div class="tab-content second-half">

			<!-- "All" tab content -->
			<div class="tab-pane fade in active" id="all">
				<div class="layout">
					<div class="left-side">

						<!-- Personal details, communities, work, and education -->
						<div class="details-box">
							<h2 class="section-title">Personal details</h2>
							<div class="detail-item"> 
								<img src="../images/ploc.svg" class="detail-icon"> 
								<span>Lives in Palo Alto, California</span> 
							</div>
							<div class="detail-item"> 
								<img src="../images/phome.svg" class="detail-icon"> 
								<span>From Dobbs Ferry, New York</span> 
							</div>
							<div class="detail-item"> 
								<img src="../images/pdob.svg" class="detail-icon"> 
								<span>14 May 1984</span> 
							</div>
							<p class="see-more">See more personal details</p>

							<h3 class="section-title">Communities</h3>
							<div class="">
								<div class="detail-item community-content"> 
									<img src="../images/pmeta.svg" class="detail-icon"> 
									<a class="meta-content">Meta Channel</a> 
								</div>
								<p class="sub-content"> Channel· 799K members</p>
							</div>
							<h3 class="section-title">Work</h3>
							<div class="detail-meta-item">
								<div class="detail-item"> 
									<img src="./images/work.jpg" class="detail-icon detail-meta-icon"> 
									<span>Meta</span>
								</div>
								<p class="sub-content">Founder and CEO <br> 4 Feb 2004 – Present · 21 years, 9 months</p>
							</div>
							<p class="see-more">See more work</p>

							<h3 class="section-title">Education</h3>
							<div class="detail-meta-item">
								<div class="detail-item"> 
									<img src="./images/harvard.jpg" class="detail-icons detail-meta-icon"> 
									<span>Harvard University</span> 
								</div>
								<p class="sub-content">30 August 2002 – 30 April 2004</p>
							</div>
							<p class="see-more">See more education</p>
						</div>

						<!-- User photos section -->
						<div class="details-box photos">
							<div class="photos-header">
								<p>Photos</p>
								<a href="#" class="ui-hovers photos-header-content">See All Photos</a>
							</div>
							<div class="user-imgs">
								<img src="./images/photos1.jpg" alt="photo1" class="user-image">
								<img src="./images/photos2.jpg" alt="photo2" class="user-image">
								<img src="./images/photos3.jpg" alt="photo3" class="user-image">
								<img src="./images/photos4.jpg" alt="photo4" class="user-image">
								<img src="./images/photos5.jpg" alt="photo5" class="user-image">
								<img src="./images/photos6.jpg" alt="photo6" class="user-image">
								<img src="./images/photos7.jpg" alt="photo7" class="user-image">
								<img src="./images/photos8.jpg" alt="photo8" class="user-image">
								<img src="./images/photos9.jpg" alt="photo9" class="user-image">
							</div>
						</div>
						<div>
							<ul class="footer-links">
								<li>
									<a href="#" class="footer-content">Privacy .</a>
								</li>
								<li>
									<a href="#" class="footer-content">Terms .</a>
								</li>
								<li>
									<a href="#" class="footer-content">Advertising .</a>
								</li>
								<li class="adds-link">
									<a href="#" class="footer-content">AdChoices 
										<img src="./images/photo_ad.png" alt="add choice image" class="ad-img"> .
									</a>
								</li>
								<li>
									<a href="#" class="footer-content">Cookies .</a>
								</li>
								<li>
									<a href="#" class="footer-content">More</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="right-side">

						<!-- Posts header with filter -->
						<div class="post-box postbox-header">
							<h3 class="section-title post-title" >Posts</h3>
							<button class="filter-btn ui-hovers">
								<img src="./images/filter.svg" alt="filter image"> Filter
							</button>
						</div>

						<!-- Add new post form -->
						<?php if ($loggedUserId == $viewUid) { ?>
							<div class="post-box add-post">
								<form id="add_post_form">
									<textarea name="new_post" id="new_post" placeholder="Write something..."></textarea><br>
									<button type="submit" id="post_btn">Post</button>
									<p id="post_error"></p>
								</form>
							</div>
						<?php } ?>
						
						<!-- Display wall posts -->
						<div id="wall_posts">
							<?php while ($posts = $allPosts->fetch_assoc()) { renderPost($posts, $viewUserName, $viewUserImage); } ?>
						</div>
					</div>
				</div>
			</div>

			<!-- "About" tab content -->
			<div class="tab-pane fade" id="about">
				<div class="about-content">

					<!-- About tab navigation -->
					<div class="about-tabs">
						<h2 class="tabs-header">About</h2>
						<ul class="about-tabs-list">
							<li class="tab-item ui-hovers active">Intro</li>
							<li class="tab-item ui-hovers">Category</li>
							<li class="tab-item ui-hovers">Personal details</li>
							<li class="tab-item ui-hovers">Work</li>
							<li class="tab-item ui-hovers">Education</li>
							<li class="tab-item ui-hovers">Privacy and legal info</li>
						</ul>
					</div>

					<!-- User bio -->
					<div class="about-bio">
						<h2 class="tabs-header">Bio</h2>
						<p class="bio-content">
							<span>
								<img src="./images/bio.svg" alt="bio image">
							</span> &nbsp; 
							Bringing the world closer together.
						</p>
					</div>
				</div>
			</div>

			<!-- "Friends" tab content -->
			<div class="tab-pane fade" id="friends">
				<div class="friends-page">

					<!-- Friends header and search -->
					<div class="friends-header">
						<h4 class="friend-title">Friends</h4>
						<input type="text" class="fb-search friends-search" placeholder="Search Facebook">
					</div>

					<p id="no_friends_msg">
						No friends found
					</p>
					
					<!-- Friends list -->
					<div class="all-friends">
						<?php foreach($friendsArr as $friends){ ?>
							<a href="?uid=<?= $friends['user_id'] ?>" class="friend-details friend-box-link">
								<img src="<?= $friends['image_path'] ?>" class="friend-img">
								<span><b><?= $friends['name'] ?></b></span>
							</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Edit Profile Modal -->
		<div id="edit_profile_modal" class="modal-overlay">
			<div class="modal-box">
				<h3>Edit Profile</h3>
				<form method="POST">
					<label>Name</label>
					<input type="text" name="name" value="<?= $editUser['name'] ?>" class="form-control edit-input" required>
					<label>Email</label>
					<input type="email" name="email" value="<?= $editUser['email_id'] ?>" class="form-control edit-input" required>
					<label>Phone</label>
					<input type="text" name="phone" value="<?= $editUser['phone'] ?>" class="form-control edit-input">
					<label>Address</label>
					<input type="text" name="address" value="<?= $editUser['address'] ?>" class="form-control edit-input">
					<div class="modal-actions">
						<button type="submit" name="update_profile" class="save-btn">Save Changes</button>
						<button type="button" id="close_modal" class="cancel-btn">Cancel</button>
					</div>
				</form>
			</div>
		</div>

		<!-- Make sure jQuery is loaded -->
		<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script src="home.js"></script>
	</body>
</html>
