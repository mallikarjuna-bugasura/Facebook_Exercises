$(document).ready(function () {

	// Toggle dropdown when button is clicked
	$('.dropdown-btn').click(function (e) {
		e.stopPropagation(); // prevent document click from firing
		$('.dropdown-menu-profile').toggle();
	});

	// Close dropdown if clicked outside
	$(document).click(function () {
		$('.dropdown-menu-profile').hide();
	});

	// Prevent dropdown click from closing itself
	$('.dropdown-menu-profile').click(function (e) {
		e.stopPropagation();
	});

	// Open edit profile modal when clicking the Edit Profile button
	$('#edit_profile_btn').click(function (e) {
		e.preventDefault();
		$('#edit_profile_modal').show();
	});

	// Close edit profile modal when clicking the close button
	$('#close_modal').click(function () {
		$('#edit_profile_modal').hide();
	});

	// Show tab based on hash on page load
	var hash = window.location.hash;
	if (hash) {
		$('.body-tabs-list a[href="' + hash + '"]').tab('show');
	}

	// Update URL when a tab is clicked
	$('.body-tabs-list a').on('shown.bs.tab', function (e) {
		history.replaceState(null, null, e.target.hash);
	});

	// Handle new post submission via AJAX
	$('#add_post_form').on('submit', function (e) {
		e.preventDefault();
		let postText = $('#new_post').val().trim();

		// Validate that the post is not empty
		if (postText === '') {
			$('#post_error').css({ color: 'red', fontSize: '14px' }).text('Post cannot be empty');
			setTimeout(function () {
				$('#post_error').fadeOut(500, function () {
					$(this).text('').show();
				});
			}, 2000);
			return;
		}

		// Send post data to server
		$.ajax({
			url: 'addpost.php',
			type: 'POST',
			data: { new_post: postText },
			success: function (res) {
				if (res === 'success') {
					// Clear input and reload posts section
					$('#new_post').val('');
					$('#wall_posts').load(location.href + ' #wall_posts>*');

					// Show success message
					$('#post_error').css({ color: 'green', fontSize: '14px' }).text('Post added successfully');
					setTimeout(function () {
						$('#post_error').fadeOut(500, function () {
							$(this).text('').show();
						});
					}, 2000);
				}
				else {
					// Show error message if AJAX fails
					$('#post_error').css({ color: 'red', fontSize: '14px' }).text('Failed to add post');
				}
			}
		});
	});

	// Reload page if coming back from cache
	window.addEventListener("pageshow", function (event) {
		if (event.persisted) {
			window.location.reload();
		}
	});

	$('.friends-search').on('keyup', function () {
		let value = $(this).val().toLowerCase();
		let visibleCount = 0;

		$('.all-friends .friend-box-link').each(function () {
			let match = $(this).find('span').text().toLowerCase().indexOf(value) > -1;
			$(this).toggle(match);
			if (match) visibleCount++;
		});

		if (visibleCount === 0) {
			$('#no_friends_msg').show();
		} else {
			$('#no_friends_msg').hide();
		}
	});
});