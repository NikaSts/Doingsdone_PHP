<main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form" action="/add_task.php" method="post" enctype="multipart/form-data">
        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>
            <input class="form__input <?= isset($errors['name']) ? " form__input--error" : '' ?>" type="text" name="name" id="name" value="<?= isset($_POST['name']) ? esc($_POST['name']) : ''; ?>"
                   placeholder="Введите название">
            <? if (isset($errors['name'])): ?>
                <p class="form__message"><?= $errors['name']; ?></p>
            <? endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект</label>
            <select class="form__input form__input--select <?= isset($errors['project']) ? " form__input--error" : '' ?>" name="project" id="project">
                <option>Выберите проект</option>
                <? foreach ($projects as $key => $val): ?>
                <?
                $selected_project = 0;
                if (isset($_POST['project'])) {
                    intval($_POST['project']);
                }
                ?>
                <option value="<?= ($val['id']); ?>"<?= $val['id'] == $selected_project ? ' selected' : '' ?>><?= ($val['name']); ?>
                    <? endforeach; ?>
                </option>
            </select>
            <? if (isset($errors['project'])):?>
                <p class="form__message"><?= $errors['project'];?></p>
            <? endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date <?= isset($errors['date']) ? " form__input--error" : '' ?>" type="date" name="date" id="date" value="<?= isset($_POST['date']) ? esc($_POST['date']) : ''; ?>"
                   placeholder="Введите дату в формате ДД.ММ.ГГГГ">
            <? if (isset($errors['date'])): ?>
                <p class="form__message"><?= $errors['date']; ?></p>
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
