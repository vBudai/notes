<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Заметки</title>

    <link rel="stylesheet" href="templates/styles/reset.css" type="text/css">
    <link rel="stylesheet" href="templates/styles/notes.css" type="text/css">

</head>
<body>

<header>
    <h1></h1>
</header>


<div class="content-container">
    <div class="notes"></div>
</div>

<div class="create-btn">
    <div class="create-btn_plus">
        <span class="create-btn_plus_line"></span>
        <span class="create-btn_plus_line"></span>
    </div>
</div>

<div class="note-bg">
    <div class="note">
        <div class="note_text-data">
            <input class="text-data_title" type="text" placeholder="Название">
            <textarea class="text-data_text" placeholder="Введите текст"></textarea>
            <span class="text-data_date"></span>
        </div>


        <div class="note_panel">
            <div class="panel_settings">
                <div class="settings_close">
                    <span class="close_line"></span>
                    <span class="close_line"></span>
                </div>
                <div class="settings_palette">
                    <img src="templates/images/palette.svg" alt="Цвет">
                    <div class="palette_colors">
                        <label>
                            <input type="radio" name="bgColor" value="FFFFFF" checked>
                            <span style="background: #FFFFFF; border: 1px solid #000"></span>
                        </label>
                        <label>
                            <input type="radio" name="bgColor" value="4747FF">
                            <span style="background: #4747FF"></span>
                        </label>
                        <label>
                            <input type="radio" name="bgColor" value="C73434">
                            <span style="background: #C73434"></span>
                        </label>
                        <label>
                            <input type="radio" name="bgColor" value="3CA947">
                            <span style="background: #3CA947"></span>
                        </label>
                    </div>
                </div>
                <img class="settings_delete" src="templates/images/basket.svg" alt="Удалить">
            </div>
            <div class="note_panel_save">
                <img src="templates/images/check_mark.svg" alt="Сохранить">
            </div>
        </div>

        <div class="note_delete-confirm">
            <span class="delete-confirm_title">Вы точно хотите удалить заметку?</span>
            <div class="delete-confirm_submit">
                <div class="submit_yes">Ес, офкорзе</div>
                <div class="submit_no">Ноу</div>
            </div>
        </div>
    </div>
</div>


<script src="templates/scripts/notes.js"></script>

</body>
</html>
