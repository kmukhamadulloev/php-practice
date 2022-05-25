<header class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 py-3 text-end">
            <a href="/" class="btn btn-outline-danger">Назад</a>
        </div>
    </div>
</header>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <?php foreach($errors as $error): ?>
                <div class="alert alert-<?=$error['type']?>">
                    Ошибка: <?=$error['message']?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form method="POST" action="/add">
                <div class="mb-3">
                    <label for="first_name" class="form-label">ИМЯ <span style="color: red;">*</span>:</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" required placeholder="Иван" value="<?=$items['first_name'] ?? ""?>"/>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">ФАМИЛИЯ <span style="color: red;">*</span>:</label>
                    <input type="text" class="form-control" name="last_name" id="last_name" required placeholder="Иванов" value="<?=$items['last_name'] ?? ""?>"/>
                </div>
                <label for="phone" class="form-label">ТЕЛЕФОН <span style="color: red;">*</span>:</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">+</span>
                    <input type="text" class="form-control" name="phone" required id="phone" placeholder="7999999999" value="<?=$items['phone'] ?? ""?>"/>
                </div>
                <div class="mb-3">
                    <label for="comments" class="form-label">КОММЕНТАРИЙ:</label>
                    <textarea class="form-control" id="comments" name="comments" rows="5"><?=$items['comments'] ?? ""?></textarea>
                    <small><i>Максимальнное количество символов: 200</i></small>
                </div>
                <div class="mb-3 d-grid gap-2">
                    <button class="btn btn-primary btn-lg btn-full">Добавить</button>
            </form>
        </div>
    </div>
</main>
    