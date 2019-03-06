<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{title}}</title>
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
    <a class="navbar-brand" href="#">Dashboard</a>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
            <section class="row text-center placeholders">
                <div class="col-10 col-sm-12">
                    <form style="padding-top:100px" method="post" action="/index.php/discount/create"
                          enctype="multipart/form-data">
                        <?php if($view['checkTable']){ ?>
                        <div class="alert alert-success" role="alert">
                            <strong>Discounts</strong> таблица существует.
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Import CSV</label>
                            <input type="file" name="csv" class="form-control-file" onchange="form.submit()">
                        </div>
                    </form>
                </div>
            </section>

            <h2>Section title</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Status</th>
                        <th>URL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($view['discounts'] as $discount){
                    $random = '';
                    if(!empty($_GET['rand']) && $_GET['rand'] == $discount->id) {
                    $discount->status = $discount->status === 'On' ? 'Off' : 'On';
                    $random = 'style="color:blue!important"';
                    }
?>
                    <tr <?php echo $random ?>>
                        <td><?= $discount->id ?></td>
                        <td><?= $discount->title ?></td>
                        <td><?= date('Y-m-d',$discount->start) ?></td>
                        <td><?= $discount->end ?></td>
                        <td><?= $discount->status ?></td>
                        <td><?= $discount->slug ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<script>window.jQuery || document.write('<script src="/template/jquery.min.js"><\/script>')</script>
<script src="/template/js/bootstrap.min.js"></script>
</body>
</html>