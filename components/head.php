<?php
    $config = include("{$_SERVER['DOCUMENT_ROOT']}/afungaz/config.php");
    $uri = $_SERVER['REQUEST_URI'];
    date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Afungaz</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css" integrity="sha384-eoTu3+HydHRBIjnCVwsFyCpUDZHZSFKEJD0mc3ZqSBSb6YhZzRHeiomAUWCstIWo" crossorigin="anonymous">
    
    <link rel="stylesheet" type="text/css" href="<?= $config['URL'] ?>/css/head.css">
</head>

<body class="bg-light">
    <nav class="navbar bg-dark-blue shadow">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <button class="navbar-toggler bg-white me-2 shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand text-white fw-bold fs-4 m-0" href="/afungaz">Afungaz</a>
            </div>
            <div class="d-flex align-items-center">
                <div class="btn-group">
                    <button type="button" class="d-flex align-items-center btn text-white border-0 p-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4 me-1"></i> <?= $_SESSION['nome'] ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="?logout" class="dropdown-item text-end" type="button">
                                Sair<i class="bi bi-box-arrow-right ms-1"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="offcanvas offcanvas-start bg-light" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header bg-dark-blue shadow">
                    <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div>
                    <ul class="navbar-nav justify-content-end flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link px-3 border-bottom <?= $uri === '/afungaz/' ? 'active' : '' ?>" aria-current="page" href="<?= $config['URL'] ?>"><i class="bi bi-house me-2"></i>Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 border-bottom <?= $uri === '/afungaz/agendamento_quioesque/agendamento.php' ? 'active' : '' ?>" aria-current="page" href="<?= $config['URL'] ?>agendamento_quioesque/agendamento.php"><i class="bi bi-calendar3 me-2"></i>Agendar Quioesque</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 border-bottom <?= $uri === '/afungaz/agendamento_chale/agendamento.php' ? 'active' : '' ?>" aria-current="page" href="<?= $config['URL'] ?>agendamento_chale/agendamento.php"><i class="bi bi-calendar3 me-2"></i>Agendar Chalé</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 border-bottom <?= $uri === '/afungaz/agendamento_quadra/agendamento.php' ? 'active' : '' ?>" aria-current="page" href="<?= $config['URL'] ?>agendamento_quadra/agendamento.php"><i class="bi bi-calendar3 me-2"></i>Agendar Campos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 border-bottom <?= $uri === '/afungaz/user/user.php' ? 'active' : '' ?>" href="<?= $config['URL'] ?>user/user.php"><i class="bi bi-clock-fill me-2"></i>Meus Agendamentos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 border-bottom <?= $uri === '/afungaz/user/update.php' ? 'active' : '' ?>" href="<?= $config['URL'] ?>user/update.php"><i class="bi bi-person-fill me-2"></i>Manutenção de Cadastro</a>
                        </li>
                        <?php if($_SESSION['id_tipo_funcionario'] == 2){?>
                        <li class="nav-item">
                            <a class="nav-link px-3 border-bottom <?= $uri === '/afungaz/admin/read_agendamento.php' ? 'active' : '' ?>" href="<?= $config['URL'] ?>admin/read_agendamento.php"><i class="bi bi-person-fill me-2"></i>Relatório de agendametnos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 border-bottom <?= $uri === '/afungaz/admin/read_funcionario.php' ? 'active' : '' ?>" href="<?= $config['URL'] ?>admin/read_funcionario.php"><i class="bi bi-person-fill me-2"></i>Relatório de funcionários</a>
                        </li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-white div-content rounded shadow-lg">