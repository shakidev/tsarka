<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Контакты</title>
    <link href="/template/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template/dashboard.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
    <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse"
            data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <form class="form-inline mt-2 mt-md-0" method="get">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" name="filter">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
            <section class="row text-center placeholders">
                <div class="col-10 col-sm-12">
                    <form style="padding-top:100px" method="post" action="/index.php/phone/update"
                          enctype="multipart/form-data">
                        <?php if(isset($_SESSION['error'])){ ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']  ?></div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Телефон</label>
                            <input type="hidden" name="id" value="<?= $view['phone']->id?>">
                            <input type="text" name="phone" placeholder="Телефон" class="form-control" value="<?= $view['phone']->phone?>">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</div>
<script>window.jQuery || document.write('<script src="/template/jquery.min.js"><\/script>')</script>
<script src="/template/js/bootstrap.min.js"></script>
</body>
</html>