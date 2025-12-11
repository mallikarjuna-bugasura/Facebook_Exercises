<?php
// Start session and include DB config
session_start();
include 'config.php';

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
	header("Location: index.php");
	exit;
}

$logged_user_id = $_SESSION['user_id'];

// Function to render a single post box (Post UI layout)
function render_post($p,$username) {
	echo <<<HTML
<div class="post-box">
	<div class="post-header">
		<img src="./images/mark.jpg" alt="">
		<div class="post-details">
			<a href="">{$username}</a>
			<img src="./images/blue.svg" alt="" class="posts-icon">
			<p><b>{$p['posting_date']}</b></p>
		</div>
		<div class="three-dots">
			<img src="./images/dots.svg" alt="">
		</div>
	</div>

	<!-- Post text content -->
	<div class="middle-content">
		<p>{$p['post']}</p>
	</div>

	<!-- Like, comment, share section -->
	<div class="footer">
		<div class="footer-content">
			<div class="emojis">
				<img src="./images/like.svg" alt="">
				<img src="./images/heart.svg" alt="">
				<img src="./images/smile.svg" alt="">
				<span>125k</span>
			</div>

			<!-- Comments and shares count -->
			<div>
				<span>47.8k</span>
				<span class="message"><i class="fa-solid fa-comment"></i></span>
				<span>13k</span>
				<span class="share"><i class="fa-solid fa-share"></i></span>
			</div>
		</div>

		<!-- Like button -->
		<div class="user-options">
			<div class="mains">
				<span><img src="./images/postlike.png" alt=""></span>
				<div class="content"><a>Like</a></div>
			</div>
		</div>

		<!-- Comment button -->
		<div class="user-options">
			<div class="mains">
				<span><img src="./images/comment.png" alt=""></span>
				<div class="content"><a>Comment</a></div>
			</div>
		</div>

		<!-- Share button -->
		<div class="user-options">
			<div class="mains">
				<span><img src="./images/postshare.png" alt=""></span>
				<div class="content"><a>Share</a></div>
			</div>
		</div>
	</div>
</div>
HTML;
}

// Handle adding new post to tWall (Insert post into DB)
if(isset($_POST['new_post']) && trim($_POST['new_post']) != ""){
	$post = $conn->real_escape_string(trim($_POST['new_post']));
	$sql = "INSERT INTO tWall(user_id, posting_date, post) VALUES($logged_user_id, NOW(), '$post')";
	$conn->query($sql);
}

// Default: show logged-in user's posts
$view_uid = $logged_user_id;

// When clicking on a friend, show their posts instead
if(isset($_POST['view_friend_id'])){
	$view_uid = intval($_POST['view_friend_id']);
}

// Fetch viewed user's name
$view_user_sql = "SELECT name FROM tUser WHERE user_id=$view_uid";
$view_user_res = $conn->query($view_user_sql);
$view_user = $view_user_res->fetch_assoc();
$view_user_name = $view_user['name'];

// Fetch posts for the selected user
$post_sql = "SELECT * FROM tWall WHERE user_id=$view_uid ORDER BY posting_date DESC";
$all_posts = $conn->query($post_sql);

// Fetch logged-in User details
$user_sql = "SELECT * FROM tUser WHERE user_id=$logged_user_id";
$user_res = $conn->query($user_sql);
$user = $user_res->fetch_assoc();

// Fetch friends list for sidebar
$friends_sql = "SELECT user_id, name, image_path FROM tUser WHERE user_id IN (SELECT friend_id FROM tFriends WHERE user_id=$logged_user_id)";
$friends = $conn->query($friends_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Basic page info and stylesheets -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>facebook</title>
	<link rel="icon" type="image/png" href="./images/facebooklogo.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="home.css">
</head>
<body>

	<!-- TOP HEADER SECTION -->
	<div class="logo-details">

		<!-- Logo + search bar -->
		<div class="search">
			<img src="./images/logo.svg" alt="" class="logo">
			<input type="text" class="fb-search" placeholder="Search Facebook">
		</div>

		<!-- Middle navigation icons -->
		<div class="middle">
			<span class="edit_styles"><img src="./images/home.svg" alt=""></span>
			<span class="edit_styles middle-icons"><img src="./images/insta.svg" alt=""></span>
			<span class="edit_styles middle-icons"><img src="./images/market.svg" alt=""></span>
			<span class="edit_styles middle-last"><img src="./images/friends.svg" alt=""></span>
			<span class="edit_styles middle-last"><img src="./images/gaming.svg" alt=""></span>
		</div>

		<!-- Right profile icons -->
		<div class="profile-details">
			<span class="end"><img src="./images/menu.svg" alt="" class="last"></span>
			<span class="end"><img src="./images/message.svg" alt="" class="last"></span>
			<span class="end"><img src="./images/noti.svg" alt="" class="last"></span>

			<!-- Profile dropdown -->
			<span class="profiles profile-wrapper end">
				<img src="./images/village.jpg" class="right-icons profile-icon" height="40" width="40">
				<img src="./images/drop.svg" class="drop-icon">
				<!-- Dropdown menu -->
				<ul class="dropdown-menu-profile">
					<li><a href="profile.php?uid=<?= $logged_user_id ?>">Profile</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>

			</span>
		</div>
	</div>
		</div>

		<!-- PROFILE BANNER -->
		<div class="body">
			<div class="body-header">
				<img src="./images/main.png" alt="" class="profile">
			</div>
		</div>

		<!-- USER PROFILE SECTION -->
		<div class="row main">

			<!-- Left: Profile image -->
			<div class="col-lg-2">
				<img src="./images/mark.jpg" alt="" class="mark-image">
			</div>

			<!-- Right: User details -->
			<div class="col-lg-10 user-section">
				<div class="top-row">

					<!-- User name, verification badge -->
					<div>
						<a href="#" class="user-name">Mark Zuckerberg</a>
						<img src="./images/blue.svg" alt="" class="verify-icon">
						<br>
						<div class="follow">
							<a href="#" class="followers">120M followers</a>
						</div>
					</div>

					<!-- Follow and search buttons -->
					<div class="buttons">
						<button class="btn follow-btn">
							<img src="https://static.xx.fbcdn.net/rsrc.php/v4/yw/r/LJ8KuNpi23A.png" class="icon-white">
							Follow
						</button>

						<button class="btn search-btn">
							<img src="./images/search.svg" class="icon-black" height="18" width="18">
							Search
						</button>
					</div>

				</div>

				<!-- User bio + public info -->
				<div class="user-info">
					<p class="desc">Bringing the world closer together.</p>

					<!-- Public info line (education, work, etc) -->
					<p class="info-line">
						<img src="./images/public.svg" class="info-icon public-figure">
						<a href="#">Public figure</a>
						<span class="dots">.</span>

						<img src="./images/location.svg" class="info-icon icons">
						<a href="#">Palo Alto, California</a>
						<span class="dots">.</span>

						<img src="./images/meta.svg" class="info-icon public-figure">
						<a href="#">Meta</a>
						<span class="dots">.</span>

						<img src="./images/meta.svg" class="info-icon dates">
						<a href="#">Biohub</a>
						<span class="dots">.</span>

						<img src="./images/education.svg" class="info-icon">
						<a href="#">Harvard University</a>
					</p>

					<!-- Followers images -->
					<p class="followers">
						<img src="./images/followings.png" class="followers-img" alt="">
					</p>
				</div>
			</div>
		</div>

		<!-- PROFILE NAVIGATION TABS -->
		<div class="body-tabs">
			<ul class="nav nav-tabs">
				<li class="active">All</li>
				<li>About</li>
				<li>Photos</li>
				<li class="close1">Friends</li>
				<li class="close1">Reels</li>
				<li>More <span class="caret more-icon"></span></li>
			</ul>
		</div>

	</div>

	<!-- SECOND HALF LAYOUT -->
	<div class="second-half">
		<div class="layout">

			<!-- LEFT SIDE PANEL -->
			<div class="left-side">

				<!-- Personal details -->
				<div class="details-box">
					<h3 class="section-title">Personal details</h3>

					<!-- Basic details (location, hometown, DOB) -->
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

					<!-- Communities -->
					<h3 class="section-title">Communities</h3>
					<div class="detail-item">
						<img src="../images/pmeta.svg" class="detail-icon">
						<span>Meta Channel · 799K members</span>
					</div>
					<p class="see-more">See more communities</p>

					<!-- Work info -->
					<h3 class="section-title">Work</h3>
					<div class="detail-item">
						<img src="./images/work.jpg" class="detail-icon">
						<span>Meta — Founder and CEO</span>
					</div>
					<p class="sub">4 Feb 2004 – Present · 21 years, 9 months</p>
					<p class="see-more">See more work</p>

					<!-- Education info -->
					<h3 class="section-title">Education</h3>
					<div class="detail-item">
						<img src="./images/harvard.jpg" class="detail-icon">
						<span>Harvard University</span>
					</div>
					<p class="sub">30 August 2002 – 30 April 2004</p>
					<p class="see-more">See more education</p>
				</div>

				<!-- Friends list -->
				<div class="box friends">
					<h3 class="section-title" align="center">Friends</h3>

					<!-- Loop through friends -->
					<?php while ($f = $friends->fetch_assoc()) { ?>
						<form method="POST" style="display:inline-block;">
							<input type="hidden" name="view_friend_id" value="<?= $f['user_id'] ?>">

							<!-- Friend clickable row -->
							<button type="submit" class="detail-item friend-link" style="border:none; background:none; cursor:pointer;">
								<img src="<?= $f['image_path']; ?>" alt="profile" height="40" width="40">
								<span><b><?= $f['name'] ?><b></span>
							</button>

						</form>
					<?php } ?>
				</div>
			</div>

			<!-- RIGHT SIDE PANEL -->
			<div class="right-side">

				<!-- Header for posts -->
				<div class="post-box">
					<h3 class="section-title post-title" align="center">Posts</h3>
				</div>

				<!-- Add new post form -->
				<div class="post-box">
					<form method="POST">
						<textarea name="new_post" placeholder="Write something..." style="width:100% ; border:none"></textarea><br>
						<button type="submit">Add Post</button>
					</form>
				</div>

				<!-- Display all posts -->
				<div id="wallPosts">
					<?php while ($p = $all_posts->fetch_assoc()) { render_post($p, $view_user_name); } ?>
				</div>

			</div>
		</div>
	</div>

	<script>
	// Handle profile dropdown toggle
	document.querySelector('.drop-icon').addEventListener('click', function() {
		let menu = document.querySelector('.dropdown-menu-profile');
		menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
	});

	// Close dropdown when clicking outside
	document.addEventListener('click', function(e){
		if(!e.target.closest('.profile-wrapper')){
			document.querySelector('.dropdown-menu-profile').style.display = 'none';
		}
	});
	</script>
</body>
</html>
