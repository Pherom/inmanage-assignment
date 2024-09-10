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
            <article class="post">
                <div class=user-data>
                        <div class="user-avatar-container">
                            <img class="user-avatar" src=<?php echo AVATAR_FILE_NAME ?> alt="Avatar">
                        </div>
                        <h2 class="user-name"> <?php echo $this->userName ?> </h2>
                        <p class="user-email"> <?php echo $this->userEmail ?> </p>
                        <?php
                            if ($this->userActive) {
                                ?>
                                <p class="is-user-active">Active</p>
                                <?php
                            }
                            else {
                                ?>
                                <p class="is-user-active">Inactive</p>
                                <?php
                            }
                        ?>
                    </div>
                    <div class=post-data>
                        <div class="post-content">
                            <h1 class="post-title"> <?php echo $this->postTitle ?> </h1>
                            <p class="post-body"> <?php echo $this->postBody ?> </p>
                        </div>
                        <div class="post-metadata">
                            <p class="post-date-created"> <?php echo $this->postDateCreated ?> </p>
                            <?php
                                if ($this->postActive) {
                                    ?>
                                    <p class="is-post-active">Active</p>
                                    <?php
                                }
                                else {
                                    ?>
                                    <p class="is-post-active">Inactive</p>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
            </article>
        <?php
    }

}