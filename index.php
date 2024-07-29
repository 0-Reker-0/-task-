<?php
require_once 'backend/sdbh.php';
require_once 'backend/added/New_funcs.php';
$dbh = new sdbh();
$price = 0;
if(isset($_POST['btn']))
    $price = New_funcs::select_cars($dbh, $_POST);
?>
<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
    <style>
            .container{
                margin-top: 50px;
                border-radius: 15px;
                border: 3px solid #333;
            }
            .col-3{
                background-color: #FF9A00;
                border-radius: 0;
                border-top-left-radius: 13px;
                border-bottom-left-radius: 13px;
                display: flex;
                align-items: center;
                flex-flow: column;
                justify-content: center;
                font-size: 26px;
                font-weight: 900;
            }
            label:not([class="form-check-label"]) {
                font-size: 16px;
                font-weight: 600;
            }
            .form-check-input:checked{
                background-color: #FF9A00;
                border-color: #FF9A00;
            }
            .col-9{
                padding: 25px;
            }
            .btn-primary {
                color: #fff;
                background-color: #FF9A00;
                border-color: #FF9A00;
            }
            .price{
                font-size: 24px;
                padding-top: 2rem;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row row-header">
                <div class="col-12">
                    <img src="assets/img/logo.png" alt="logo" style="max-height:50px"/>
                    <h1>Прокат</h1>
                </div>
            </div>
            <div class="row row-body">
                <div class="col-12">
                    <h4>Дополнительные услуги:</h4>
                    <ul>
                    <?php
                        $services = unserialize($dbh->mselect_rows('a25_settings', ['set_key' => 'services'], 0, 1, 'id')[0]['set_value']);
                        foreach($services as $k => $s) { ?>
                            <li><?=$k?>: <?=$s?></li>
                        <?php }
                    ?>
                    </ul>
                </div>
            </div>
            <div class="container">
            <div class="row row-body">
                <div class="col-3">
                    <span style="text-align: center">Форма обратной связи</span>
                    <i class="bi bi-activity"></i>
                </div>
                <div class="col-9">
                    <form action="" id="form" method="POST">
                            <label class="form-label" for="product">Выберите продукт:</label>
                            <select class="form-select" name="product" id="product">

                            <?php
                            //this request has been modified and improved for convenience
                            $cars = $dbh->mselect_rows('a25_products', method: 'new');
                            foreach($cars as $result) {?>
                                <option value="<?=$result['ID']?>"><?=$result['NAME']?> за <?=$result['PRICE']?></option>
                            <?php }?>
                            </select>

                            <label for="customRange1" class="form-label">Количество дней:</label>
                            <input type="number" class="form-control" required id="customRange1" name="dayImput" min="1" max="30">

                            <label for="customRange1" class="form-label">Дополнительно:</label>

                            
                            <?php
                                $services = unserialize($dbh->mselect_rows('a25_settings', ['set_key' => 'services'], 0, 1, 'id')[0]['set_value']);
                                $i = 1;
                                foreach($services as $k => $s) {?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="<?=$s?>" name="chekBox_<?=$i?>" id="flexCheckChecked" checked>
                                <label class="form-check-label" for="flexCheckChecked1">
                                    Дополнительно <?=$k?> за <?=$s?>
                                </label>
                            </div>
                                <?php $i++;}?>
                            <button type="submit" id="btn" name="btn" class="btn btn-primary">Рассчитать</button>
                            <div class="price">
                                Итоговая цена аренды:
                                <?php if($price !== 0){?> <?=$price?>
                                <?php }else{?>
                                    <label class="form-label" for="btn">Нажмите кнопку "Рассчитать"</label>
                                <?php }?>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>
