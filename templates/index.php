<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="" method="get">
    <input class="search-form__input" type="text" name="search" value="<?=$search?>" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/index.php?filter=all" class="tasks-switch__item <?=!isset($filter) || $filter == "all" ? "tasks-switch__item--active" : ""  ?>">Все задачи</a>
        <a href="/index.php?filter=agenda" class="tasks-switch__item <?=$filter == "agenda"  ? "tasks-switch__item--active" : ""  ?>">Повестка дня</a>
        <a href="/index.php?filter=tomorrow" class="tasks-switch__item <?=$filter == "tomorrow"  ? "tasks-switch__item--active" : ""  ?>">Завтра</a>
        <a href="/index.php?filter=expired" class="tasks-switch__item <?=$filter == "expired"  ? "tasks-switch__item--active" : ""  ?>">Просроченные</a>
    </nav>
    <label class="checkbox">
        <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?= ($show_complete_tasks == 1) ? "checked" : "" ?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>

</div>
<p><?=!empty($search) && empty($tasksList) ? "Ничего не найдено по вашему запросу" :'' ?></p>
<table class="tasks">
    <?php foreach ($tasksList as $taskInfo): ?>
        <?php if (!$taskInfo['done'] || $show_complete_tasks == 1): ?>
            <tr class="tasks__item task <?=$taskInfo['done'] ? "task--completed" : "" ?> <?=isTaskImportant($taskInfo['date_completion'], 24) && !$taskInfo['done'] ? "task--important" : "" ?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox"  value="<?=$taskInfo['id']?>"<?= ($taskInfo['done']) ? "checked" : "" ?>>
                        <span class="checkbox__text"><?=htmlspecialchars($taskInfo['name']) ?></span>
                    </label>

                </td>

                <td class="task__file">
                    <a class="download-link" href="#"><?=htmlspecialchars($taskInfo['project_name']) ?></a>
                </td>

                <td class="task__date"><?= $taskInfo['date_completion']==null ? '' : date('d.m.Y', strtotime($taskInfo['date_completion'])) ?></td>
            </tr>
        <?php endif ?>
    <?php endforeach ?>
</table>
