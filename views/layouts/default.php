<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/src/bootstrap-4.3.1/css/bootstrap.min.css">
    <!-- FontAwesome CSS -->
    <link href="/src/fontawesome-5.10.2/css/all.css" rel="stylesheet">
    <!-- My CSS -->
    <link rel="stylesheet" href="/src/templates/main/css/style.css">

    <title>Мой блог</title>
</head>
<body>

<div class="container">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/index.php">Мой блог</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Главная <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="post-manager.php" role="button">
                            Управление статьями
                        </a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <a href="#" id="register"><i class="fas fa-users"></i>&nbsp;Регистрация</a>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="margin-left: 1rem;"><i class="fas fa-sign-in-alt"></i>&nbsp;Войти</button>
                </form>
            </div>
        </nav>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">Добро пожаловать!</h1>
                <p class="lead">Это мой блог и здесь будут публиковаться посты с моими мыслями по разным моментам.</p>
            </div>
        </div>
    </header>
    <main>
        <?=$content?>
    </main>
    <footer>

    </footer>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="/src/bootstrap-4.3.1/js/bootstrap.min.js"></script>
</body>
</html>