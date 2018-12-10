<form class="form" action="" method="post" enctype="multipart/form-data">
    <div class="form__row">
        <label class="form__label" for="email">E-mail <sup>*</sup></label>
        <?php $classname = isset($errors['email']) ? "form__input--error" : ""; $value = isset($form['email']) ? $form['email'] : ""?>
        <input class="form__input <?=$classname?>" type="text" name="form_ent[email]" id="email" value="<?=$value?>" placeholder="Введите e-mail">
        <?php if (isset($errors['email'])): ?>
            <p class="form__message"><?=$errors['email']?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="password">Пароль <sup>*</sup></label>
        <?php $classname = isset($errors['password']) ? "form__input--error" : ""; $value = isset($form['password']) ? $form['password'] : ""?>
        <input class="form__input <?=$classname?>" type="password" name="form_ent[password]" id="password" value="<?=$value?>" placeholder="Введите пароль">
        <?php if (isset($errors['password'])): ?>
            <p class="form__message"><?=$errors['password']?></p>
        <?php endif; ?>
    </div>

    <div class="form__row form__row--controls">
        <?php if (isset($errors)): ?>
            <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
        <?php endif; ?>
        <input class="button" type="submit" name="" value="Войти">
    </div>
</form>
