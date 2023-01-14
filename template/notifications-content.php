<div class="row">
    <div class="col-1 col-md-2 col-xl-3"> </div>
    <section id="output" class="output col-10 col-md-8 col-xl-6">
        <div id="output-list" class="col">
            <?php if (!empty($templateParams["notifications"])): ?>
                <?php foreach($templateParams["notifications"] as $notification): ?>
                    <article class="row p-1 notification mt-2">    
                        <div class="col-12">
                    <?php if ($notification["type"] == NotificationTypes::Follow->value): ?>
                        <a class="row reset-a" href="profile.php?user=<?php echo $notification["sender"] ?>">
                            <div class="col-3 ps-1">
                                <img class="profile-preview" src="<?php echo $PROFILE_PIC_DIR.$notification["profilePic"] ?>" alt="Profile pic of <?php echo $notification["sender"] ?>"/>
                            </div>
                            <div class="col-6">
                                <p class="notification-label mt-2"> <strong><?php echo $notification["sender"]?></strong> started following you </p>
                            </div>
                            <div class="col-3">
                                <p class="timestamp"><?php echo datetimeToString($notification["date"]) ?></p>
                            </div>
                        </a> 
                    <?php elseif ($notification["type"] == NotificationTypes::Like->value): ?>
                        <a class="row reset-a" href="profile.php?user=<?php echo $notification["sender"] ?>#article-<?php echo $notification["postId"]?>">
                            <div class="col-3 ps-1 ">
                                <img class="profile-preview" src="<?php echo $PROFILE_PIC_DIR.$notification["profilePic"] ?>" alt="Profile pic of <?php echo $notification["sender"] ?>"/>
                            </div>
                            <div class="col-6">
                                <p class="notification-label mt-2"> <strong><?php echo $notification["sender"] ?></strong> liked your post </p>
                            </div>
                            <div class="col-3">
                                <p class="timestamp"><?php echo datetimeToString($notification["date"]) ?></p>
                            </div>
                        </a>
                    <?php elseif ($notification["type"] == NotificationTypes::Comment->value): ?>
                        <a class="row reset-a" href="comments.php?post=<?php echo $notification["postId"] ?>#comment-<?php echo $notification["commentId"]?>">
                            <div class="col-3 ps-1">
                                <img class="profile-preview" src="<?php echo $PROFILE_PIC_DIR.$notification["profilePic"] ?>" alt="Profile pic of <?php echo $notification["sender"] ?>"/>
                            </div>
                            <div class="col-6">
                                <p class="notification-label mt-2"><strong><?php echo $notification["sender"]?></strong> wrote a comment to your post</p>
                            </div>
                            <div class="col-3">
                                <p class="timestamp"><?php echo datetimeToString($notification["date"]) ?></p>
                            </div>
                        </a>
                    <?php endif ?>
                        </div>    
                    </article>       
                <?php endforeach ?>
            <?php else: ?>
                <p class="info-message"> <strong>No notifications found</strong> </p>
            <?php endif ?>
        </div>
    </section>
    <div class="col-1 col-md-2 col-xl-3"> </div>  
</div>
