<main class="content__main">
    <h2 class="content__main-heading">Добавление проекта</h2>

    <form class="form"  action="/add_project.php" method="post">
        <? if (isset($errors)): ?>
            <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
        <? endif; ?>
        <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>
            <input class="form__input <?= isset($errors['name']) ? " form__input--error" : '' ?>" type="text" name="name" id="project_name" value="<?= isset($_POST['name']) ? esc($_POST['name']) : ''; ?>" placeholder="Введите название проекта">
        </div>
        <? if (isset($errors['name'])): ?>
            <p class="form__message"><?= $errors['name']; ?></p>
        <? endif; ?>
        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</main>
