<?= $this->extend('layout/default');?>
<?= $this->section('content');?>
<?php

?>

<div class="container">
    <div class="row mt-3 justify-content-center">
        <h1>Комментарии</h1>
    </div>

    <div class="row p-2">
        <select name="fieldSort" class="form-select mx-2" aria-label="Выберите поле для сортировки">
            <option value="1" selected>ID</option>
            <option value="2">Date</option>
        </select>
        <select name="typeSort" class="form-select mx-2" aria-label="Выберите тип сортировки">
            <option value="1" selected>По убыванию</option>
            <option value="2">По возрастанию</option>
        </select>
        <button id="sortBtn" class="btn btn-success mx-2">Сортировать</button>
    </div>


    <div id="output" class="paginated">

    </div>

<!--    <div class="paginatedButtons"></div>-->

    <nav class="mt-3" aria-label="Page navigation">
        <ul class="paginatedButtons pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
        </ul>
    </nav>

    <div class="my-5">
        <h2>Добавление комментария</h2>

        <form method="post" accept-charset="utf-8" id="addForm">

            <div class="my-3">
                <label for="forEmail" class="form-label">Email</label>
                <input name="Name" type="email" class="form-control" id="forEmail" placeholder="name@example.com" maxlength="50" required>
            </div>
            <div class="mb-3">
                <label for="forText" class="form-label">Комментарий</label>
                <textarea name="Text" class="form-control" id="forText" rows="3" maxlength="500" required></textarea>
            </div>
            <div class="mb-3">
                <label for="forDate" class="form-label">Дата публикации</label>
                <input name="Date" type="date" class="form-control" id="forDate">
            </div>

            <button type="submit" id="addButton" class="btn btn-primary">Добавить</button>

        </form>

    </div>

</div>

<script>
    $("#addForm").submit(function (e) {
        e.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "http://localhost/comments/store",
            data: form_data,
            success: function () {
                updateComments();
            }
        });
    });


</script>

<script>
    function deleteComment(Id)
    {
        if (confirm('Вы действительно хотите удалить комментарий?')) {
            $.ajax({
                type: "GET",
                url: "http://localhost/comments/delete?Id=" + Id,
                success: function () {
                    updateComments();
                }
            });
        }
    }
</script>

<script>
    function updateComments() {
        $('.paginated').html('');
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'http://localhost/Data', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                document.getElementById('output').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
        refrashHide();

    }
</script>

<script>

    function refrashHide()
    {

        // ждем подгрузку комментариев
        if ($('.card').length < 1) {
            setTimeout(refrashHide, 100); // try again in 300 milliseconds
        }

        $('.card').show();
        $('.paginatedButtons').html('');

        var cardsPerPage = 3;
        $('.card:gt(' + (cardsPerPage - 1) + ')').hide();
        var totalPages = Math.ceil($('.card').length / cardsPerPage);

        for (var i = 1; i <= totalPages; i++)
        {
            $('.paginatedButtons').append('<li class="page-item"><a href="#" class="page-link">' + i + '</a></li>');
        }

        $('.page-link:first').addClass('active');

        $('.page-link').on('click', function(e)
        {
            e.preventDefault();

            $('.page-link').removeClass('active');
            $(this).addClass('active');
            var startIndex = ($(this).text() - 1) * cardsPerPage;
            $('.card').hide();
            $('.card').slice(startIndex, startIndex + cardsPerPage).show();
        });
    }

    $(document).ready(function() {

        updateComments(); // подгрузка комментариев

        // сортировка
        $("#sortBtn").click(function()
        {
            var fieldSort = $("select[name=fieldSort]").val();
            var typeSort  = $("select[name=typeSort]").val();

            // ID desc
            if(fieldSort == 1 && typeSort == 1)
            {
                var cards = $('.card').after("Id");
                cards.sort(function(a, b)
                {
                    var idcardA = $(a).find('.idcard').text();
                    var idcardB = $(b).find('.idcard').text();
                    return parseFloat(idcardB) - parseFloat(idcardA);
                });
                $('.paginated').html(cards);
                refrashHide();
            }


            // ID ask
            if(fieldSort == 1 && typeSort == 2)
            {
                var cards = $('.card');
                cards.sort(function(a, b)
                {
                    var idcardA = $(a).find('.idcard').text();
                    var idcardB = $(b).find('.idcard').text();
                    return parseFloat(idcardA) - parseFloat(idcardB);
                });
                $('.paginated').html(cards);
                refrashHide();
            }

            // Date desc
            if(fieldSort == 2 && typeSort == 1)
            {
                var cards = $('.card');
                cards.sort(function(a, b)
                {
                    var dateA = parseDate($(a).find('.date').text());
                    var dateB = parseDate($(b).find('.date').text());
                    return dateB - dateA;
                });
                $('.paginated').html(cards);
                refrashHide();
            }

            // Date ask
            if(fieldSort == 2 && typeSort == 2)
            {
                var cards = $('.card');
                cards.sort(function(a, b)
                {
                    var dateA = parseDate($(a).find('.date').text());
                    var dateB = parseDate($(b).find('.date').text());
                    return dateA - dateB;
                });
                $('.paginated').html(cards);
                refrashHide();
            }

            function parseDate(str)
            {
                var mdy = str.split('-');
                return new Date(mdy[1], mdy[0] - 1, mdy[2]);
            }

        });
    });
</script>




<?= $this->endSection(); ?>




