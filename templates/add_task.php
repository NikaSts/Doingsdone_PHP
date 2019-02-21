<main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form" action="/add.php?" method="post" enctype="multipart/form-data">
        <div class="form__row">
            <?php $classname = isset($errors['name']) ? "form__input--error" : "";
            $value = isset($form_task['name']) ? $form_task['name'] : ""; ?>
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input" <?= $classname; ?> type="text" name="name" id="name" value="<?= $value; ?>"
                   placeholder="Введите название" required>
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект</label>

            <select class="form__input form__input--select" name="project" id="project">
                <? foreach ($projects as $key => $val): ?>
                <option value=""><?= esc($val['name']); ?>
                    <? endforeach; ?>
                </option>

            </select>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date" type="text" name="date" id="date" value=""
                   placeholder="Введите дату в формате ДД.ММ.ГГГГ">
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

        <?php if (isset($errors)): ?>
            <div class="form__errors">
                <p>Пожалуйста, исправьте следующие ошибки:</p>
                <ul>
                    <?php foreach ($errors as $err => $val): ?>
                        <li><strong><?= $dict[$err]; ?>:</strong><?= $val; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>


        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</main>
