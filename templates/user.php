<div class="main-header__side">
    <a class="main-header__side-item button button--plus open-modal" href="/add.php">Добавить
        задачу</a>

    <div class="main-header__side-item user-menu">
        <div class="user-menu__image">
            <img src="img/user-pic.jpg" width="40" height="40" alt="Пользователь">
        </div>

        <div class="user-menu__data">
            <p><?= isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : "" ?></p>

            <a href="/logout.php">*Выйти</a>
        </div>
    </div>
</div>
