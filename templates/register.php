<main class="content__main">
    <h2 class="content__main-heading">Регистрация аккаунта</h2>

    <form class="form" action="/register.php" method="post">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>
            <input class="form__input <?= isset($errors['email']) ? " form__input--error" : '' ?>" type="text" name="email" id="email" value="<?= isset($_POST['email']) ? esc($_POST['email']) : ''; ?>" placeholder="Введите e-mail">
            <? if (isset($errors['email'])): ?>
            <p class="form__message">E-mail введён некорректно</p>
            <? endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>
            <input class="form__input <?= isset($errors['email']) ? " form__input--error" : '' ?>" type="password" name="password" id="password" value="" placeholder="Введите пароль">
            <? if (isset($errors['password'])): ?>
                <p class="form__message">Это поле надо заполнить</p>
            <? endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="name">Имя <sup>*</sup></label>
            <input class="form__input <?= isset($errors['name']) ? " form__input--error" : '' ?>" type="text" name="name" id="name" value="<?= isset($_POST['name']) ? esc($_POST['name']) : ''; ?>" placeholder="Введите имя">
            <? if (isset($errors['name'])): ?>
                <p class="form__message">Это поле надо заполнить</p>
            <? endif; ?>
        </div>

        <div class="form__row form__row--controls">
            <? if (isset($errors)): ?>
            <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
            <? endif; ?>
            <input class="button" type="submit" name="" value="Зарегистрироваться">
        </div>
    </form>
</main>
