<div class="row">
    <div class="col-1 col-md-2 col-xl-3"> </div>
    <section id="output" class="output col-10 col-md-8 col-xl-6">
        <div id="output-list" class="col">
            <?php foreach($templateParams["notifications"] as $notification): ?>
                <?php if ($notification["type"] == NotificationTypes::Follow->value): ?>
                    <article class="row p-1 notification mt-2">    
                        <a class="row reset-a" href="profile.php?user=<?php echo $notification["sender"] ?>">
                            <div class="col-4 ps-1">
                                <img class="profile-preview" src="<?php echo $notification["profilePic"] ?>" />
                            </div>
                            <div class="col d-flex flex-column align-items-center">
                                <p class="notification-label m-2"> This is a follow notification </p>
                            </div>
                        </a>
                    </article>
                    
                <?php elseif ($notification["type"] == NotificationTypes::Like->value): ?>
                    <article class="row p-1 notification mt-2">    
                        <a class="row reset-a" href="profile.php?user=<?php echo $notification["sender"] ?>">
                            <div class="col-4 ps-1">
                                <img class="profile-preview" src="<?php echo $notification["profilePic"] ?>" />
                            </div>
                            <div class="col d-flex flex-column align-items-center">
                                <p class="notification-label m-2"> This is a like notification </p>
                            </div>
                        </a>
                    </article>
                <?php elseif ($notification["type"] == NotificationTypes::Comment->value): ?>
                    <article class="row p-1 notification mt-2">    
                        <a class="row reset-a" href="profile.php?user=<?php echo $notification["sender"] ?>">
                            <div class="col-4 ps-1">
                                <img class="profile-preview" src="<?php echo $notification["profilePic"] ?>" />
                            </div>
                            <div class="col d-flex flex-column align-items-center">
                                <p class="notification-label m-2"> This is a comment notification </p>
                            </div>
                        </a>
                    </article>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </section>
    <div class="col-1 col-md-2 col-xl-3"> </div>  
</div>
