<?php foreach ($Comments as $comment): ?>
    <div class="card shadow rounded-3 mt-3" id="cardId<?= $comment['Id']; ?>">
        <div class="card-body">
            <h5 class="card-title"><?= $comment['Name']; ?></h5>
            <h6 class="card-subtitle mb-2 text-body-secondary"><?= $comment['Text']; ?></h6>
            <p class="date"><?= $comment['Date']; ?></p>
            <p class="idcard d-none"><?= $comment['Id']; ?></p>
            <button type="button" id="delButton" class="btn btn-danger" onclick="deleteComment(<?=$comment['Id'];?>)">Удалить</button>
        </div>
    </div>
<?php endforeach; ?>


<?php if(isset($_SESSION['errors'])): ?>

    <div class="mt-3" role="alert" style="
            position: relative;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
            border-left: 0.25rem solid #d7a818 !important;
            border: 1px solid transparent;"
    >
        <?php foreach($_SESSION['errors'] as $error):?>
            <?= $error; ?>
        <?php endforeach;?>

        <?php unset($_SESSION['errors']);?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>

<?php endif;?>

<?php if(isset($_SESSION['success'])):?>

    <div class="mt-3" role="alert" style="
            position: relative;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
            border-left: 0.25rem solid #1cc88a !important;
            border: 1px solid transparent;"
        >
            <?=$_SESSION['success'];?>
            <?php unset($_SESSION['success']);?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>

<?php endif;?>