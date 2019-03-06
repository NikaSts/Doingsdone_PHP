<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="post">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <?foreach ($tasks_menu as $menu):?>
            <a href="<?=$menu['url']?>" class="tasks-switch__item<?=$menu['active']?' tasks-switch__item--active':''?>"><?=$menu['name']?></a>
            <?endforeach;?>
        </nav>

        <label class="checkbox">

            <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed" type="checkbox"
                <?= $show_complete_tasks === 1 ? 'checked' : '' ?>
            >

            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

    <?$showed = false;?>
    <table class="tasks">
        <? foreach ($tasks as $key => $val): ?>
            <? if (!$val['now_status'] || $show_complete_tasks === 1): ?>
                <?$showed = true;?>
                <tr class="tasks__item task <?= $val['now_status'] ? " task--completed" : '' ?><?= date('Y', strtotime($val['time_limit'])) > 1970 && time_counter($val['time_limit']) && !$val['now_status'] ? " task--important" : '' ?>">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden task__checkbox"
                                   type="checkbox"
                                   value="<?= $val['id']; ?>"<?= $val['now_status'] ? " checked" : '' ?>>
                            <span class="checkbox__text"><?= esc($val['name']); ?></span>
                        </label>
                    </td>
                    <td class="task__file">
                        <?if ($val['file_link']):?>
                        <a class="download-link" href="<?= $val['file_link'];?>"><?= $val['file_link']; ?></a>
                        <?endif;?>
                    </td>
                    <td class="task__date"><?= date('Y', strtotime($val['time_limit'])) > 1970 ? date('d.m.Y', strtotime($val['time_limit'])) : ''; ?></td>
                </tr>
            <? endif; ?>
        <? endforeach; ?>
    </table>
    <?if (!$showed):?>
    <p>Нет задач по данному запрсоу...</p>
    <?endif?>
</main>
