<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="post">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/index.php?filter_task=all" class="tasks-switch__item <?= $_GET['filter_task'] === 'all' ? "tasks-switch__item--active" : '' ?>">Все задачи</a>
            <a href="/index.php?filter_task=today" class="tasks-switch__item <?= $_GET['filter_task'] === 'today' ? "tasks-switch__item--active" : '' ?>">Повестка дня</a>
            <a href="/index.php?filter_task=tomorrow" class="tasks-switch__item <?= $_GET['filter_task'] === 'tomorrow' ? "tasks-switch__item--active" : '' ?>">Завтра</a>
            <a href="/index.php?filter_task=overdue" class="tasks-switch__item <?= $_GET['filter_task'] === 'overdue' ? "tasks-switch__item--active" : '' ?>">Просроченные</a>
        </nav>

        <label class="checkbox">

            <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed" type="checkbox"
                <?= $show_complete_tasks === 1 ? 'checked' : '' ?>
            >

            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

    <table class="tasks">
        <? foreach ($tasks as $key => $val): ?>
            <? if (isset($_GET['project_id'])) {
                $project_id = intval($_GET['project_id']);
                if ($val['project_id'] != $project_id) {
                    continue;
                }
            }
            ?>
            <? if (!$val['is_done'] || $show_complete_tasks === 1): ?>

                <tr class="tasks__item task <?= $val['is_done'] ? " task--completed" : '' ?><?= !$val['is_done'] && time_counter($val['time_limit']) === true ? " task--important" : '' ?>">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden task__checkbox"
                                   type="checkbox"
                                   value="<?= $val['id']; ?>" <?= $val['is_done'] ? " checked" : '' ?>>
                            <span class="checkbox__text"><?= esc($val['name']); ?></span>
                        </label>
                    </td>

                    <td class="task__file">
                        <? if ($val['file_link']): ?>
                            <a class="download-link" href="<?= $val['file_link']; ?>"><?= $val['file_link']; ?></a>
                        <? endif; ?>
                    </td>

                    <td class="task__date"><?= date('Y', strtotime($val['time_limit'])) > 1970 ? date('d.m.Y', strtotime($val['time_limit'])) : ''; ?></td>
                </tr>

            <? endif; ?>
        <? endforeach; ?>

        <? if ($show_complete_tasks === 1): ?>
            <tr class="tasks__item task task--completed">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden" type="checkbox" checked>
                        <span class="checkbox__text">Записаться на интенсив "Базовый PHP"</span>
                    </label>
                </td>
                <td class="task__date">10.10.2019</td>

                <td class="task__controls">
                </td>
            </tr>
        <? endif; ?>
    </table>
</main>
