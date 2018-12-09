<section class="content__side">
    <h2 class="content__main-heading">Регистрация аккаунта</h2>

    <form class="form" action="" method="post" enctype="multipart/form-data">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>
            <?php $classname = isset($errors['email']) ? "form__input--error" : ""; $value = isset($form['email']) ? $form['email'] : ""?>
            <input class="form__input <?=$classname?>" type="text" name="form_reg[email]" id="email" value="<?=$value?>" placeholder="Введите e-mail">
            <?php if (isset($errors['email'])): ?>
                <p class="form__message"><?=$errors['email']?></p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>
            <?php $classname = isset($errors['password']) ? "form__input--error" : ""; $value = isset($form['password']) ? $form['password'] : ""?>
            <input class="form__input <?=$classname?>" type="password" name="form_reg[password]" id="password" value="<?=$value?>" placeholder="Введите пароль">
            <?php if (isset($errors['password'])): ?>
                <p class="form__message"><?=$errors['password']?></p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="name">Имя <sup>*</sup></label>
            <?php $classname = isset($errors['name']) ? "form__input--error" : ""; $value = isset($form['name']) ? $form['name'] : ""?>
            <input class="form__input <?=$classname?>" type="text"  id="name" value="<?=$value?>"  name="form_reg[name]" placeholder="Введите имя">
            <?php if (isset($errors['name'])): ?>
                <p class="form__message"><?=$errors['name']?></p>
            <?php endif; ?>
        </div>

        <div class="form__row form__row--controls">
            <?php if (isset($errors)): ?>
                <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
            <?php endif; ?>
            <input class="button" type="submit" name="" value="Зарегистрироваться">
        </div>
    </form>
</section>
