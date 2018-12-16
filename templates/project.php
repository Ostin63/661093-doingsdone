<h2 class="content__main-heading">Добавление проекта</h2>

<form class="form" action="" method="post" enctype="multipart/form-data">
    <div class="form__row">
        <label class="form__label" for="project_name">Название <sup>*</sup></label>
        <?php $classname = isset($errors['name']) ? "form__input--error" : "";
        $value = isset($projects['name']) ? htmlspecialchars($projects['name']) : "" ?>
        <input class="form__input <?= $classname ?>" type="text" name="project[name]" id="project_name"
               value="<?= $value ?>" placeholder="Введите название проекта">
        <?php if (isset($errors['name'])): ?>
            <p class="form__message"><?= $errors['name'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row form__row--controls">
        <?php if (isset($errors)): ?>
            <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
        <?php endif; ?>
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
