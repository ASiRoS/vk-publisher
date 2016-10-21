<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php if(!ACCESS_TOKEN) { ?>
    <a href="<?=getAuthorizeUrl();?>">Получить код</a>
    <p>
        У вас уже есть код?
        Введите его сюда:
        <form action="" method="get">
            <input type="text" name="code">
            <input type="submit" value="Отправить!">
        </form>
    </p>
    <?php exit(); } ?>

<form action="" method="post" enctype="multipart/form-data">
    <p class="Text">Текст:
        <textarea rows="10" cols="50" name="text"></textarea>
    </p>
    <p class="groups">Группы:
        <textarea rows="2" cols="30" name="groups"></textarea>
    </p>
    <p>Изображения:
        <input type="file" name="pictures[]" multiple="true" min="1" max="20"/>
        <input type="submit" value="Отправить" />
    </p>

</form>

<?php
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imagesPath = [];
    if(isset($_FILES['pictures']['name']) && file_exists($_FILES['pictures']['tmp_name'][0])) {
        $imgCnt = count($_FILES['pictures']['name']);
        for($i = 0; $i < $imgCnt; $i++) {
            $imagePath = IMAGES_DIR.'/'.$_FILES['pictures']['name'][$i];
            move_uploaded_file($_FILES['pictures']['tmp_name'][$i], $imagePath);
            $imagesPath[] = $imagePath;
        }
    }
    $text = '';
    if(isset($_POST['text'])) {
        $text = $_POST['text'];
    }
    if(!isset($_POST['groups']) || empty(trim($_POST['groups']))){
        exit('Укажите группы.');
    } else {
        $groups = trim($_POST['groups']);
        $groups = explode(' ', $_POST['groups']);
    }
    wallPost(getGroupsIdByName($groups), $text, $imagesPath);
    header('Location:'. strok($_SERVER['REQUEST_URI'], '?'));
}
?>
</body>
</html>
