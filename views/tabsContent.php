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
				<?php if ($logged_user_id == $view_uid) { ?>
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
					<?php 
						while ($posts = $all_posts->fetch_assoc()) { 
							render_post($posts, $view_user_name, $view_user_image); 
						} 
					?>
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
				<?php foreach($friends_arr as $friends){ ?>
					<a href="?uid=<?= $friends['user_id'] ?>" class="friend-details friend-box-link">
						<img src="<?= $friends['image_path'] ?>" class="friend-img">
						<span><b><?= $friends['name'] ?></b></span>
					</a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
