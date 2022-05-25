<header class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 py-3 text-end">
            <a href="/create" class="btn btn-outline-primary">Добавить</a>
        </div>
    </div>
</header>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="table-responsive">
            <table class="table align-middle table-striped table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th scope="col">Имя</th>
                        <th scope="col">Фамилия</th>
                        <th scope="col">Мобильный телефон</th>
                        <th scope="col">Комментарий</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach($items as $item): ?>
                    <tr>
                        <td><?=$item['first_name']?></td>
                        <td><?=$item['last_name']?></td>
                        <td>+<?=$item['phone']?></td>
                        <td><?=$item['comments']?></td>
                    </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
        </div>
    </div>
</main>