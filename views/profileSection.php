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
        <img src="<?= $view_user_image ?>" alt="user image" class="mark-image">
    </div>

    <!-- User info and actions -->
    <div class="user-section">
        <div class="top-row">

            <!-- User name and followers -->
            <div>
                <a href="#" class="user-name"><?= $view_user_name ?>
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
                <?php foreach(array_slice($friends_arr, 0, 6) as $friend){ ?>
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

