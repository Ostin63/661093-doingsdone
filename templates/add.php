<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form"  action="" method="post" enctype="multipart/form-data">
    <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>
        <?php $classname = isset($errors['name']) ? "form__input--error" : ""; $value = isset($task['name']) ? $task['name'] : ""?>
        <input class="form__input <?=$classname;?>" type="text" name="task[name]" id="name" value="<?=$value;?>" placeholder="Введите название">
        <?php if (isset($errors['name'])): ?>
            <p class="form__message"><?=$errors['name']?></p>
        <?php endif; ?>
    </div>
    <div class="form__row">
        <label class="form__label" for="project">Проект <sup>*</sup></label>
        <?php $classname = isset($errors['project']) ? "form__input--error" : ""; $value = isset($task['project']) ? $task['project'] : ""?>
        <select class="form__input form__input--select" name="task[project]" id="project">
            <?php foreach ($projects as $project): ?>
                <option value="<?= htmlspecialchars($project['id']) ?>"><?= htmlspecialchars($project['name']) ?></option>
            <?php endforeach ?>
        </select>
        <?php if (isset($errors['project'])): ?>
            <p class="form__message"><?=$errors['project']?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="date">Дата выполнения</label>
        <?php $classname = isset($errors['date']) ? "form__input--error" : ""; $value = isset($task['date']) ? $task['date'] : ""?>
        <input class="form__input form__input--date <?=$classname?>" type="date" name="task[date]" id="date" value="<?=$value?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
        <?php if (isset($errors['date'])): ?>
            <p class="form__message"><?=$errors['date']?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="file">Файл</label>

        <div class="form__input-file">
            <?php $classname = isset($errors['file']) ? "form__input--error" : "" ;?>
            <input class="visually-hidden" type="file" name="task[file]" id="file" value="">
            <?php if (isset($errors['file'])): ?>
                <p class="form__message"><?=$errors['file']?></p>
            <?php endif; ?>
            <label class="button button--transparent" for="file">
                <span>Выберите файл</span>
            </label>
        </div>
    </div>


    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>