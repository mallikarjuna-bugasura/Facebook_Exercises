<?php
    // Function to render a single post
	function render_post($posts, $username, $image) {
		$formatted_date = date("d F Y", strtotime($posts['posting_date']));
		echo <<<HTML
			<div class="post-box">
				<div class="post-header">
					<img src="{$image}" alt="post user image" class="post-user">
					<div class="post-user-details">
						<div class="post-details">
							<a href="#" class="post-name">{$username}</a>
							<img src="./images/blue.svg" alt="blue icon image" class="posts-icon">
							<p class="post-date"><b>{$formatted_date}</b></p>
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
?>