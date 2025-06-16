<!DOCTYPE html>
<html lang="pt-br"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>CULTURA EFATÁ | Dashboard</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE v4 | Dashboard">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="/vendors/css/adminlte.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
            <div class="container-fluid"> <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i style="color: #0B3222 !important;" class="bi bi-list"></i> </a> </li>
                    <li class="nav-item d-none d-md-block"> <a href="/dashboard" class="nav-link">SITE CULTURA EFATÁ</a> </li>

                </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
                <?php if (!empty($_SESSION['mensagem'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['mensagem'];
                        unset($_SESSION['mensagem']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($_SESSION['erro'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['erro'];
                        unset($_SESSION['erro']); ?>
                    </div>
                <?php endif; ?>
                <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->


                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <a href="#" class="dropdown-item"> <!--begin::Message-->
                            <div class="d-flex">
                                <div class="flex-shrink-0"> <img src="vendors/assets/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                                <div class="flex-grow-1">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-end fs-7 text-danger"><i class="bi bi-star-fill"></i></span>
                                    </h3>
                                    <p class="fs-7">Call me whenever you can...</p>
                                    <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div> <!--end::Message-->
                        </a>
                        <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <!--begin::Message-->
                            <div class="d-flex">
                                <div class="flex-shrink-0"> <img src="vendors/assets/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                                <div class="flex-grow-1">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-end fs-7 text-secondary"> <i class="bi bi-star-fill"></i> </span>
                                    </h3>
                                    <p class="fs-7">I got your message bro</p>
                                    <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div> <!--end::Message-->
                        </a>
                        <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <!--begin::Message-->
                            <div class="d-flex">
                                <div class="flex-shrink-0"> <img src="vendors/assets/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 rounded-circle me-3"> </div>
                                <div class="flex-grow-1">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-end fs-7 text-warning"> <i class="bi bi-star-fill"></i> </span>
                                    </h3>
                                    <p class="fs-7">The subject goes here</p>
                                    <p class="fs-7 text-secondary"> <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div> <!--end::Message-->
                        </a>
                        <div class="dropdown-divider"></div> <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                    </li> <!--end::Messages Dropdown Menu--> <!--begin::Notifications Dropdown Menu-->

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i class="bi bi-envelope me-2"></i> 4 new messages
                            <span class="float-end text-secondary fs-7">3 mins</span> </a>
                        <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i class="bi bi-people-fill me-2"></i> 8 friend requests
                            <span class="float-end text-secondary fs-7">12 hours</span> </a>
                        <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                            <span class="float-end text-secondary fs-7">2 days</span> </a>
                        <div class="dropdown-divider"></div> <a href="#" class="dropdown-item dropdown-footer">
                            See All Notifications
                        </a>
                    </div>
                    </li> <!--end::Notifications Dropdown Menu--> <!--begin::Fullscreen Toggle-->
                    <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i style="color: #0B3222 !important;" data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
                    <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> <img src="<?= htmlspecialchars(BASE_URL . 'uploads/' . $_SESSION['userFoto'], ENT_QUOTES, 'UTF-8'); ?>" class="user-image rounded-circle shadow" alt="User Image"> <span class="d-none d-md-inline"> <?php echo htmlspecialchars($_SESSION['userNome'], ENT_QUOTES, 'UTF-8'); ?></span> </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <!--begin::User Image-->
                            <!-- <li class="user-header text-bg-primary">
                                <img
                                    src=" ////"
                                    alt="User Image">
                            </li> -->

                            <li style="background-color: #06121E !important; display: flex; align-items: center; justify-content: center;" class="user-header text-bg-primary">
                                <img
                                    src="<?= htmlspecialchars(BASE_URL . 'uploads/' . $_SESSION['userFoto'], ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="User Image">
                            </li>

                            <p>
                                <?php echo htmlspecialchars($_SESSION['userNome'], ENT_QUOTES, 'UTF-8'); ?>
                                <small><?php echo htmlspecialchars($_SESSION['userEndereco'] ?? 'Endereço não disponível', ENT_QUOTES, 'UTF-8'); ?></small>
                            </p>

                    </li> <!--end::User Image--> <!--begin::Menu Body-->

                    <li class="user-footer"> <a href="/login/sair" class="btn btn-default btn-flat float-end">Sair</a> </li>
                    <!-- end::Menu Footer  -->
                    <!-- <a style="display: none  ; " href="#" class="btn btn-default btn-flat">Perfil</a> -->
                </ul>
                </li> <!--end::User Menu Dropdown-->
                </ul> <!--end::End Navbar Links-->
            </div> <!--end::Container-->
        </nav> <!--end::Header--> <!--begin::Sidebar-->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
            <div class="sidebar-brand" style=" background-color: #06121E !important;"> <!--begin::Brand Link--> <a href="/dashboard" class="brand-link"> <!--begin::Brand Image--> <img src="/assets/img/Logo_Cultura.png" alt="LOGO_SITE"> <!--end::Brand Image--> <!--begin::Brand Text--> <span class="brand-text fw-light"></span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper" style="    background-color: #06121E !important; ">
                <nav class="mt-2"> <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-open"> <a href="/dashboard" class="nav-link active"> <i class="bi bi-speedometer2"></i>
                                <p>
                                    Dashboard

                                </p>
                            </a>

                        </li>


                        </a> </li>



                        <!-- <li class="nav-item"> <a href="#" class="nav-link"> <i class="bi bi-briefcase"></i>
                                <p>
                                    Recursos Humanos
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="./UI/general.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Funcionarios</p>
                                    </a> </li>


                            </ul>
                        </li> -->









                        <li class="nav-header">MATRICULAS VOLEI</li>

                        <li class="nav-item"> <a href="/matricula/matriculas" class="nav-link"> <i class="bi bi-clipboard-check"></i>


                                <p>Cadastros</p>
                            </a> </li>

                        <li class="nav-item"> <a href="/newsletter/contato_Newsletter" class="nav-link"> <i class="bi bi-envelope-check"></i>
                                <p>Newsletter</p>
                            </a> </li>

                    </ul> <!--end::Sidebar Menu-->
                </nav>
            </div> <!--end::Sidebar Wrapper-->
        </aside>
        <!--end::Sidebar--> <!--begin::App Main-->
        <main class="app-main">


            <div class="app-content-header">
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Dashboard</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">

                                <li class="breadcrumb-item active" aria-current="page">
                                    Dashboard
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div>

            <div class="app-content">

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                            <div class="small-box text-bg-primary" style="background-color: #06121E !important;">
                                <div class="inner">
                                    <h3 id="totalInativos">0</h3>
                                    <p>Matrículas Inativas</p>
                                </div>

                                <div class="icon" style="position: absolute; top: 10px; right: 10px; font-size: 3rem; color: white;">
                                    <i class="bi-x-circle-fill"></i>
                                </div>

                                <a href="/matricula/matriculas" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                    <i class="bi-x-circle-fill" style="color: white;"></i>
                                </a>
                            </div>

                        </div> <!--end::Col-->
                        <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 2-->
                            <div class="small-box text-bg-success" style="background-color: #06121E !important;">
                                <div class="inner">
                                    <h3 id="totalAtivos">0</h3>
                                    <p>Matrículas Ativas</p>
                                </div>

                                <div class="icon" style="position: absolute; top: 10px; right: 10px; font-size: 3rem; color: white;">
                                    <i class="bi-check-circle-fill"></i>
                                </div>

                                <a href="/matricula/matriculas" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                    <i class="bi-check-circle-fill" style="color: white;"></i>
                                </a>
                            </div>

                        </div>
                        <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 3-->
                            <div class="small-box text-bg-warning" style="background-color: #06121E !important;">
                                <div class="inner">
                                    <h3 id="totalMatriculas">0</h3>
                                    <p>MATRÍCULAS</p>
                                </div>

                                <!-- Ícone de Chat -->
                                <div class="icon" style="position: absolute; top: 10px; right: 10px; font-size: 3rem; color: white;">
                                    <i class="bi-journal-text"></i>
                                </div>

                                <a href="/matricula/matriculas" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                    <i class="bi-journal-text" style="color: white;"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-danger" style="background-color: #06121E !important;">
                                <div class="inner">
                                    <h3 id="totalNewsletter">0</h3>
                                    <p>Inscritos na Newsletter</p>
                                </div>
                                <div class="icon" style="position: absolute; top: 10px; right: 10px; font-size: 3rem; color: white;">
                                    <i class="bi-envelope-fill"></i>
                                </div>
                                <a href="/newsletter/listar" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                    <i class="bi-envelope-fill" style="color: white;"></i>
                                </a>
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>

                    <div class="row">





                        <!-- CONTEUDO -->

                        <?php

                        if (isset($conteudo)) {
                            $this->carregarViews($conteudo, $dados);
                        } else {
                        }


                        ?>
                        <?php if (!isset($conteudo) || $conteudo === 'dashboard') : ?>

                            <div class="text-center mb-4">
                                <div class="row g-2">
                                    <div class="col-6 col-md-2">
                                        <button class="btn btn-primary w-100 btn-filtro" data-filtro="total">Total</button>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <button class="btn btn-secondary w-100 btn-filtro" data-filtro="idade">Faixa Etária</button>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <button class="btn btn-success w-100 btn-filtro" data-filtro="atividade">Atividade</button>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <button class="btn btn-info w-100 btn-filtro" data-filtro="status">Status</button>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <button class="btn btn-warning w-100 btn-filtro" data-filtro="cadastro">Por Mês</button>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <button class="btn btn-dark w-100 btn-filtro" data-filtro="cidade">Por Cidade</button>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <button class="btn 	btn-danger w-100 btn-filtro" data-filtro="bairro">Por Bairro</button>
                                    </div>

                                </div>
                            </div>


                            <div class="col-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title" id="tituloGrafico">📊 Total de Matrículas</h3>
                                    </div>
                                    <div class="card-body" style="height: 400px;">
                                        <canvas id="graficoMatriculas"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- Chart.js -->
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

                            <script>
                                const cores = ['#42A5F5', '#66BB6A', '#FFA726', '#AB47BC', '#FF7043', '#26C6DA', '#EF5350'];
                                let graficoAtual = null;

                                const rotas = {
                                    total: {
                                        url: '/matricula/totalMatriculas',
                                        titulo: '📊 Total de Matrículas',
                                        tipo: 'bar',
                                        unicoValor: true
                                    },
                                    idade: {
                                        url: '/matricula/graficoPorIdade',
                                        titulo: '👤 Faixa Etária',
                                        tipo: 'bar'
                                    },
                                    atividade: {
                                        url: '/matricula/graficoPorAtividade',
                                        titulo: '📚 Atividades',
                                        tipo: 'bar'
                                    },
                                    status: {
                                        url: '/matricula/graficoPorStatus',
                                        titulo: '📌 Status',
                                        tipo: 'bar'
                                    },
                                    cadastro: {
                                        url: '/matricula/graficoPorMes',
                                        titulo: '📆 Por Mês',
                                        tipo: 'line'
                                    },
                                    cidade: {
                                        url: '/matricula/graficoPorCidade',
                                        titulo: '🌆 Por Cidade',
                                        tipo: 'bar'
                                    },
                                    bairro: {
                                        url: '/matricula/graficoPorBairro',
                                        titulo: '🏘️ Por Bairro',
                                        tipo: 'bar'
                                    }

                                };

                                function criarGradiente(ctx, cor1, cor2) {
                                    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                                    gradient.addColorStop(0, cor1);
                                    gradient.addColorStop(1, cor2);
                                    return gradient;
                                }

                                async function carregarGrafico(tipo) {
                                    const config = rotas[tipo];
                                    document.getElementById('tituloGrafico').innerText = config.titulo;

                                    const res = await fetch(config.url);
                                    const dados = await res.json();

                                    const ctx = document.getElementById('graficoMatriculas').getContext('2d');
                                    if (graficoAtual) graficoAtual.destroy();

                                    let labels = [];
                                    let valores = [];
                                    let cor = (config.tipo === 'bar' || config.tipo === 'line') ? criarGradiente(ctx, '#42A5F5', '#1E88E5') : cores;

                                    if (config.unicoValor) {
                                        labels = ['Total de Matrículas'];
                                        valores = [dados.total];
                                    } else {
                                        labels = dados.map(item => item.label);
                                        valores = dados.map(item => item.valor);
                                    }

                                    graficoAtual = new Chart(ctx, {
                                        type: config.tipo,
                                        data: {
                                            labels: labels,
                                            datasets: [{
                                                label: 'Quantidade',
                                                data: valores,
                                                backgroundColor: cor,
                                                borderRadius: 10,
                                                datalabels: {
                                                    anchor: 'end',
                                                    align: 'top',
                                                    color: '#000',
                                                    font: {
                                                        weight: 'bold'
                                                    }
                                                }
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            plugins: {
                                                legend: {
                                                    display: config.tipo !== 'bar'
                                                },
                                                tooltip: {
                                                    callbacks: {
                                                        label: ctx => {
                                                            const valor = ctx.raw || 0;
                                                            return `Quantidade: ${valor}`;
                                                        }
                                                    }
                                                }
                                            },
                                            scales: (config.tipo === 'bar' || config.tipo === 'line') ? {
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        stepSize: 1
                                                    }
                                                }
                                            } : {}
                                        },
                                        plugins: typeof ChartDataLabels !== 'undefined' ? [ChartDataLabels] : []
                                    });
                                }

                                document.addEventListener('DOMContentLoaded', () => {
                                    carregarGrafico('total'); // Gráfico inicial

                                    document.querySelectorAll('.btn-filtro').forEach(botao => {
                                        botao.addEventListener('click', () => {
                                            const filtro = botao.getAttribute('data-filtro');
                                            carregarGrafico(filtro);
                                        });
                                    });
                                });
                            </script>




                        <?php endif; ?>





                    </div>

                </div> <!-- /.row (main row) -->
            </div> <!--end::Container-->

    </div> <!--end::App Content-->
    </main> <!--end::App Main--> <!--begin::Footer-->


    <footer>

    </footer>

    </div>
    <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->






    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <!-- Bootstrap -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src=" /vendors/js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script> <!--end::OverlayScrollbars Configure--> <!-- OPTIONAL SCRIPTS --> <!-- sortablejs -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ=" crossorigin="anonymous"></script> <!-- sortablejs -->
    <script>
        const connectedSortables =
            document.querySelectorAll(".connectedSortable");
        connectedSortables.forEach((connectedSortable) => {
            let sortable = new Sortable(connectedSortable, {
                group: "shared",
                handle: ".card-header",
            });
        });

        const cardHeaders = document.querySelectorAll(
            ".connectedSortable .card-header",
        );
        cardHeaders.forEach((cardHeader) => {
            cardHeader.style.cursor = "move";
        });
    </script> <!-- apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script> <!-- ChartJS -->
    <script>
        // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
        // IT'S ALL JUST JUNK FOR DEMO
        // ++++++++++++++++++++++++++++++++++++++++++

        const sales_chart_options = {
            series: [{
                    name: "Digital Goods",
                    data: [28, 48, 40, 19, 86, 27, 90],
                },
                {
                    name: "Electronics",
                    data: [65, 59, 80, 81, 56, 55, 40],
                },
            ],
            chart: {
                height: 300,
                type: "area",
                toolbar: {
                    show: false,
                },
            },
            legend: {
                show: false,
            },
            colors: ["#0d6efd", "#20c997"],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                type: "datetime",
                categories: [
                    "2023-01-01",
                    "2023-02-01",
                    "2023-03-01",
                    "2023-04-01",
                    "2023-05-01",
                    "2023-06-01",
                    "2023-07-01",
                ],
            },
            tooltip: {
                x: {
                    format: "MMMM yyyy",
                },
            },
        };

        const sales_chart = new ApexCharts(
            document.querySelector("#revenue-chart"),
            sales_chart_options,
        );
        sales_chart.render();
    </script> <!-- jsvectormap -->
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js" integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js" integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script> <!-- jsvectormap -->
    <script>
        const visitorsData = {
            US: 398, // USA
            SA: 400, // Saudi Arabia
            CA: 1000, // Canada
            DE: 500, // Germany
            FR: 760, // France
            CN: 300, // China
            AU: 700, // Australia
            BR: 600, // Brazil
            IN: 800, // India
            GB: 320, // Great Britain
            RU: 3000, // Russia
        };

        // World map by jsVectorMap
        const map = new jsVectorMap({
            selector: "#world-map",
            map: "world",
        });

        // Sparkline charts
        const option_sparkline1 = {
            series: [{
                data: [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
            }, ],
            chart: {
                type: "area",
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: "straight",
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ["#DCE6EC"],
        };

        const sparkline1 = new ApexCharts(
            document.querySelector("#sparkline-1"),
            option_sparkline1,
        );
        sparkline1.render();

        const option_sparkline2 = {
            series: [{
                data: [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921],
            }, ],
            chart: {
                type: "area",
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: "straight",
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ["#DCE6EC"],
        };

        const sparkline2 = new ApexCharts(
            document.querySelector("#sparkline-2"),
            option_sparkline2,
        );
        sparkline2.render();

        const option_sparkline3 = {
            series: [{
                data: [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21],
            }, ],
            chart: {
                type: "area",
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: "straight",
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ["#DCE6EC"],
        };

        const sparkline3 = new ApexCharts(
            document.querySelector("#sparkline-3"),
            option_sparkline3,
        );
        sparkline3.render();
    </script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/matricula/totalMatriculas')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('graficoMatriculas').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Matrículas'],
                            datasets: [{
                                label: 'Total',
                                data: [data.total],
                                backgroundColor: '#1E88E5'
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: true
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    precision: 0
                                }
                            }
                        }
                    });
                });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/matricula/totalMatriculas')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalMatriculas').textContent = data.total;
                });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/matricula/totalAtivos')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalAtivos').textContent = data.total;
                })
                .catch(error => {
                    console.error('Erro ao buscar matrículas ativas:', error);
                });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/matricula/totalInativos')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalInativos').textContent = data.total;
                })
                .catch(error => {
                    console.error('Erro ao buscar matrículas inativas:', error);
                });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/newsletter/totalNewsletter')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalNewsletter').textContent = data.total;
                })
                .catch(error => {
                    console.error('Erro ao buscar  Newsletter ', error);
                });
        });
    </script>





    <!--end::Script-->
</body><!--end::Body-->





</html>