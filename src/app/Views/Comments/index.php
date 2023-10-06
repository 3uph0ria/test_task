<?= $this->extend('layout/default');?>
<?= $this->section('content');?>

<div class="container">

    <div class="row mt-3 justify-content-center">
        <h1>Комментарии</h1>
    </div>

    <?= form_open('Comments/index'); ?>
    <div class="row p-2">
        <select name="fieldSort" class="form-select mx-2" aria-label="Выберите поле для сортировки">
            <option value="Id" <?php if ($sort['fieldSort'] == 'ID'): ?>selected<?php endif; ?>>ID</option>
            <option value="Date" <?php if ($sort['fieldSort'] == 'Date'): ?>selected<?php endif; ?>>Date</option>
        </select>
        <select name="typeSort" class="form-select mx-2" aria-label="Выберите тип сортировки">
            <option value="DESC" <?php if ($sort['typeSort'] == 'DESC'): ?>selected<?php endif; ?>>По убыванию</option>
            <option value="ASC" <?php if ($sort['typeSort'] == 'ASC'): ?>selected<?php endif; ?>>По возрастанию</option>
        </select>
        <button type="submit" class="btn btn-success mx-2">Сортировать</button>
    </div>
    <?= form_close(); ?>

    <div class="output">
        <?php foreach ($comments as $comment): ?>
            <div class="card shadow rounded-3 mt-3">
                <div class="card-body">
                    <h5 class="card-title"><?= $comment['Name']; ?></h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary"><?= $comment['Text']; ?></h6>
                    <p><?= $comment['Date']; ?></p>
                    <p><?= $comment['Id']; ?></p>

                    <button type="button" id="delButton" class="btn btn-danger" onclick="deleteComment(<?=$comment['Id'];?>)">Удалить</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <nav class="mt-5 d-flex justify-content-center" aria-label="Page navigation">
        <?php echo $pager->links(); ?>
    </nav>

    <div class="alerts mt-3"></div>

    <div class="my-5">
        <h2>Добавление комментария</h2>
        <form method="post" accept-charset="utf-8" id="addForm">

            <div class="my-3">
                <label for="forEmail" class="form-label">Email</label>
                <input name="Name" type="text" class="form-control" id="forEmail" placeholder="name@example.com" maxlength="50">
            </div>
            <div class="mb-3">
                <label for="forText" class="form-label">Комментарий</label>
                <textarea name="Text" class="form-control" id="forText" rows="3" maxlength="500"></textarea>
            </div>
            <div class="mb-3">
                <label for="forDate" class="form-label">Дата публикации</label>
                <input name="Date" type="date" class="form-control" id="forDate">
            </div>

            <button type="submit" id="addButton"  class="btn btn-primary">Добавить</button>

        </form>
    </div>

</div>

<script>
    $("#addForm").submit(function (e)
    {
        e.preventDefault();
        var form_data = $(this).serialize();
        $.ajax(
        {
            type: "POST",
            url: "http://localhost/comments/store",
            data: form_data,
            success: function (data)
            {
                $('.alerts').html('');

                if(data.success)
                    $('.alerts').html('<div class="success-alert">' + data.message + "</div>");
                else
                    $('.alerts').html('<div class="errors-alert">' + data.message + "</div>");

                alert(data.message);
                window.location.replace(location.href);
            },
        });
    });

    function deleteComment(Id)
    {
        if (confirm('Вы действительно хотите удалить комментарий?')) {
            $.ajax({
                type: "GET",
                url: "http://localhost/comments/delete?Id=" + Id,
                success: function (data)
                {
                    $('.alerts').html('');

                    if(data.success)
                        $('.alerts').html('<div class="success-alert">' + data.message + "</div>");
                    else
                        $('.alerts').html('<div class="errors-alert">' + data.message + "</div>");

                    alert(data.message);
                    window.location.replace(location.href);
                },
            });
        }
    }
</script>

<?= $this->endSection(); ?>




