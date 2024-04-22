<div class="col-md-12 review">
    <div class="row">
        <div class="col-md-1 text-center">
            <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $review->user->getImage() ?>');"></div>
        </div>
        <div class="col-md-9 author-details-container">
            <h4 class="author-name">
                <a href="<?= $BASE_URL ?>profile.php?id=<?= $review->user->id ?>"><?= $review->user->getFullName() ?></a>
            </h4>
            <p><i class="fas fa-star"></i> <?= $review->rating ?></p>
        </div>
        <div class="col-md-12">
            <p class="comment-title">Comentário:</p>
            <p><?= $review->review ?></p>
        </div>
    </div>
</div>