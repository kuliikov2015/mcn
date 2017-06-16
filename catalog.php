<!DOCTYPE html>
<?php
    list($items, $steel_types, $roll_types) = require_once __DIR__.'/db.php';

    function url($key, $value) {
        $params = [];
        if(isset($_GET['roll'])) $params['roll'] = "roll={$_GET['roll']}";
        if(isset($_GET['steel'])) $params['steel'] = "steel={$_GET['steel']}";
        if(is_null($value)) {
            unset($params[$key]);
        } else {
            $params[$key] = "{$key}={$value}";
        }

        return "/catalog.php?".implode('&', $params);
    }

    function items() {
        global $items;
        return array_filter($items, function ($item) {
            $rollMatch = !isset($_GET['roll']) || $_GET['roll'] === $item['roll_type_id'];
            $steelMatch = !isset($_GET['steel']) || $_GET['steel'] === $item['steel_type_id'];
            return $rollMatch && $steelMatch;
        });
    }

    function steels() {
        global $steel_types, $items;

        $filtered = array_filter($items, function ($item) {
            return !isset($_GET['roll']) || $_GET['roll'] === $item['roll_type_id'];
        });

        $ids = array_map(function ($item) {
            return $item['steel_type_id'];
        }, $filtered);

        $ids = array_unique($ids);
        return array_filter($steel_types, function ($type) use ($ids) {
            return in_array($type['id'], $ids);
        });
    }
?>
<html>
<head>
    <meta charset="utf-8">
    <title> Арматура А3 в Санкт-Петербурге</title>
    <link rel="stylesheet" href="reset.css" type="text/css">
    <link rel="stylesheet" href="styl.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
</head>
<body>

<!-- *********  Header  ********** -->

<div id="header">
    <div id="header_in">
        <p><a href="index.html"><b>МЦ</b> НЕВСКИЙ</a></p>
        <div id="menu">
            <ul>
                <li><a href="index.html" >Главная</a></li>
                <li><a href="about.html">О компании</a></li>
                <li><a href="catalog.html" class="active">Продукция</a></li>
                <li><a href="blog.html">Услуги</a></li>
                <li><a href="contact.html">Контакты</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- *********  Main part – headline ********** -->


<div id="main_part_inner">
    <div id="main_part_inner_in">
        <h1>Арматура А3</h1>
    </div>
</div>


<!-- *********  Content  ********** -->

<div id="content_inner">
    <ul id="work_filter">
        <?php foreach ($roll_types as $type) :?>
            <li
                <?php if(isset($_GET['roll']) && $_GET['roll'] === $type['id']) : ?>
                    class="active"
                <?php else : ?>
                    onclick="document.location='<?php echo url('roll', $type['id']) ?>'"
                <?php endif ; ?>>
                <?php echo $type['name'] ?>
            </li>
        <?php endforeach; ?>
        <li
            <?php if(!isset($_GET['roll'])) : ?>
                class="active"
            <?php else : ?>
                onclick="document.location='<?php echo url('roll', null) ?>'"
            <?php endif ; ?>>
            Все
        </li>
    </ul>
</div>


<!-- **** Items **** -->

<!-- <div class="fourths_portfolio">
     <h4>Арматура А3<br>
     <span></span>
     </h4>
     <a href="#"><img src="img/portfolio16.jpg" alt="арматура а3"></a>
 </div>

 </div>
  <div class="balka">
    <ul>
         <li><a href="armatura.html" class="active">А3</a></li>/
         <li><a href="armatura1.html">А1</a></li>/

     </ul>
 </div>-->


<table border="1">
    <caption></caption>
    <tr class="filtre"><th>Наименование</th><th>Размер мм.</th><th>Марка ст.</th><th>Прим</th></tr>
    <?php foreach (items() as $item) :?>
    <tr class="curs" onclick="document.location='/single.html'">
        <td><a><?php echo $roll_types[$item['roll_type_id']]['name'] ?></a></td>
        <td><?php echo $item['size'] ?></td>
        <td><?php echo $steel_types[$item['steel_type_id']]['name'] ?></td>
        <td>Заказать</td>
    </tr>
    <?php endforeach; ?>
    <?php if(count(items()) === 0): ?>
        <tr><td colspan="4">Ничего не найдено. <a href="/catalog.php">Cбросить фильтры</a></td></tr>
    <?php endif ?>
</table>

<div class="marki">
    <ul class="marki">
        <?php foreach (steels() as $steel) :?>
            <li
            <?php if(isset($_GET['steel']) && $_GET['steel'] === $steel['id']) : ?>
                class="active"
            <?php else : ?>
                onclick="document.location='<?php echo url('steel', $steel['id']) ?>'"
            <?php endif ; ?>
            ><?php echo $steel['name'] ?></li>
        <?php endforeach;?>
        <li
            <?php if(!isset($_GET['steel'])) : ?>
                class="active"
            <?php else : ?>
                onclick="document.location='<?php echo url('steel', null) ?>'"
            <?php endif ; ?>
        >Все</li>
    </ul>
</div>



<hr class="cleanit">

<!-- ** Pagination ** -->
<div class="cara"></div>
<p class="textit">Для того чтобы приобрести заинтересовавшую Вас продукцию, отправьте нам сообщение на адресс info@mcn-spb.ru или позвоните по номеру +7 (812) 642-25-38</p>
</div>
<!-- *********  Footer  ********** -->

<hr class="cleanit">
<div id="footer">
    <div id="footer_in">
        <p>© Металлоцентр "НЕВСКИЙ" – Продажа металлопроката в СПб и по России.<a href="index.html" ></a>  </p>
        <span> <a href=></a>Санкт-Петербург, +7 (812) 642-25-38</span>
    </div>
</div>



</body>
</html>
