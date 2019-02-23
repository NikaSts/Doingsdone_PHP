<main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form" action="/add.php?" method="post" enctype="multipart/form-data">
        <div class="form__row <?= empty($form_task['name']) ? " form__input--error" : '' ?>">
            <label class="form__label" for="name">Название <sup>*</sup></label>
            <input class="form__input" type="text" name="name" id="name" value=""
                   placeholder="Введите название" required>
            <? if (isset($errors['name'])): ?>
                <p class="form__error"><?= $errors['name']; ?></p>
            <? endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект</label>
            <select class="form__input form__input--select" name="project" id="project" required>
                <option selected>Выберите проект</option>
                <? foreach ($projects as $key => $val): ?>
                <option value="<?= ($val['id']); ?>"><?= ($val['name']); ?>
                    <? endforeach; ?>
                </option>
                <? if (isset($errors['project'])):?>
                    <p class="form__error"><?=$errors['project'];?></p>
                <? endif; ?>
            </select>
        </div>

        <div class="form__row <?= $date === 0 ? " form__input--error" : '' ?>">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date" type="date" name="date" id="date" value=""
                   placeholder="Введите дату в формате ДД.ММ.ГГГГ">
            <? if (isset($errors['date'])): ?>
                <p class="form__error"><?= $errors['date']; ?></p>
            <? endif; ?>

        </div>

        <div class="form__row">
            <label class="form__label" for="preview">Файл</label>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="preview" id="preview" value="">

                <label class="button button--transparent" for="preview">
                    <span>Выберите файл</span>
                </label>
            </div>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</main>
