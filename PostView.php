<?php
include("config.php");

class PostView {

    private $userName;
    private $userEmail;
    private $userActive;
    private $postTitle;
    private $postBody;
    private $postDateCreated;
    private $postActive;

    public function __construct(string $userName, string $userEmail, bool $userActive,
                                string $postTitle, string $postBody, string $postDateCreated, bool $postActive) {
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->userActive = $userActive;
        $this->postTitle = $postTitle;
        $this->postBody = $postBody;
        $this->postDateCreated = $postDateCreated;
        $this->postActive = $postActive;
    }

    public function display() {
        ?>
            <div class=user-data>
                <img class="user-avatar" src=<?php echo AVATAR_FILE_NAME ?> alt="Avatar">
                <h2 class="user-name"> <?php echo $this->userName ?> </h2>
                <p class="user-email"> <?php echo $this->userEmail ?> </p>
                <?php
                    if ($this->userActive) {
                        ?>
                        <p class="is_user_active">Active</p>
                        <?php
                    }
                    else {
                        ?>
                        <p class="is_user_active">Inactive</p>
                        <?php
                    }
                ?>
            </div>
            <div class=post-data>
                <h1 class="post-title"> <?php echo $this->postTitle ?> </h1>
                <p class="post-body"> <?php echo $this->postBody ?> </p>
                <p class="post-date-created"> <?php echo $this->postDateCreated ?> </p>
                <?php
                    if ($this->postActive) {
                        ?>
                        <p class="is_post_active">Active</p>
                        <?php
                    }
                    else {
                        ?>
                        <p class="is_post_active">Inactive</p>
                        <?php
                    }
                ?>
            </div>
        <?php
    }

}