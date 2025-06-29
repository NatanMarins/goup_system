<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EmpresaPerfilController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GuiaImpostoController;
use App\Http\Controllers\HoldingController;
use App\Http\Controllers\HoldingUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\TomadorContabilidadeController;
use App\Http\Controllers\TomadorPerfilController;
use App\Http\Controllers\TomadorServicoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


// Rotas Públicas

// Contratação plano para tomadores
Route::get('/tomadores/planos-contratacao', [TomadorServicoController::class, 'planosInicial'])->name('tomadores.planos.planosInicial'); //apagar
Route::get('/tomadores/contratacao', [TomadorServicoController::class, 'contratacaoInicial'])->name('tomadores.planos.contratacaoInicial');
Route::get('/tomadores/contratacao-abertura', [TomadorServicoController::class, 'aberturaEmpresa'])->name('tomadores.planos.aberturaEmpresa');
Route::post('/tomadores/contratacao-abertura-store', [TomadorServicoController::class, 'storeAbertura'])->name('tomadores.planos.storeAbertura');
Route::get('/tomadores/contratacao-troca-contador', [TomadorServicoController::class, 'trocaContador'])->name('tomadores.planos.trocaContador');
Route::post('/tomadores/contratacao-troca-store', [TomadorServicoController::class, 'storeTroca'])->name('tomadores.planos.storeTroca');
Route::get('/tomadores/contratacao-MEI', [TomadorServicoController::class, 'regularizaMei'])->name('tomadores.planos.regularizaMei');
Route::post('/tomadores/contratacao-MEI-store', [TomadorServicoController::class, 'storeMei'])->name('tomadores.planos.storeMei');
Route::get('/tomadores/contratacao-eSocial', [TomadorServicoController::class, 'regularizaEsocial'])->name('tomadores.planos.regularizaEsocial');
Route::post('/tomadores/contratacao-eSocial-store', [TomadorServicoController::class, 'storeEsocial'])->name('tomadores.planos.storeEsocial');
Route::get('/tomadores/boas-vindas', [TomadorServicoController::class, 'welcomeVideo'])->name('tomadores.planos.welcomeVideo');


// Login
Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');
Route::get('/logout', [LoginController::class, 'destroy'])->name('login.destroy');

// Recuperar a Senha
Route::get('/forgot-password',  [ForgotPasswordController::class, 'forgotPassword'])->name('login.forgotPassword');
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPasswordSubmit'])->name('login.forgotPasswordSubmit');
Route::get('/reset-password/{token}',  [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');



Route::group(['middleware' => 'auth:web,holding,tomador'], function () {


    // Rotas paras as Holdings

    // Dashboard
    Route::get('/holdings/dashboard', [DashboardController::class, 'holdingDashboard'])->name('holdings.dashboard.dashboard');

    // Holdings
    Route::get('/holdings/index-holding', [HoldingController::class, 'index'])->name('holdings.holding.index');
    Route::get('/holdings/show-holding/{holding}', [HoldingController::class, 'show'])->name('holdings.holding.show');
    Route::get('/holdings/create-holding', [HoldingController::class, 'create'])->name('holdings.holding.create');
    Route::post('/holdings/store-holding', [HoldingController::class, 'store'])->name('holdings.holding.store');
    Route::get('/holdings/edit-holding/{holding}', [HoldingController::class, 'edit'])->name('holdings.holding.edit');
    Route::put('/holdings/update-holding/{holding}', [HoldingController::class, 'update'])->name('holdings.holding.update');
    Route::delete('/holdings/destroy-holding/{holding}', [HoldingController::class, 'destroy'])->name('holdings.holding.destroy');
    Route::get('/holdings/show-empresa/{holding}/{empresa}', [HoldingController::class, 'showEmpresa'])->name('holdings.holding.show-empresa');
    Route::get('/holdings/pdf-dados{holding}', [HoldingController::class, 'gerarPdf'])->name('holdings.holding.pdf-dados');

    // Usuário
    Route::get('/holdings/index-usuario', [HoldingUserController::class, 'indexHolding'])->name('holdings.usuario.index');
    Route::get('/holdings/show-usuario/{usuario}', [HoldingUserController::class, 'showHolding'])->name('holdings.usuario.show');
    Route::get('/holdings/create-usuario', [HoldingUserController::class, 'createHolding'])->name('holdings.usuario.create');
    Route::post('/holdings/store-usuario', [HoldingUserController::class, 'storeHolding'])->name('holdings.usuario.store');
    Route::get('/holdings/edit-usuario/{usuario}', [HoldingUserController::class, 'editHolding'])->name('holdings.usuario.edit');
    Route::put('/holdings/update-usuario/{usuario}', [HoldingUserController::class, 'updateHolding'])->name('holdings.usuario.update');
    Route::get('/holdings/edit-usuario-password/{usuario}', [HoldingUserController::class, 'editPasswordHolding'])->name('holdings.usuario.edit-password');
    Route::put('/holdings/update-usuario-password/{usuario}', [HoldingUserController::class, 'updatePasswordHolding'])->name('holdings.usuario.update-password');
    Route::delete('/holdings/destroy-usuario/{usuario}', [HoldingUserController::class, 'destroyHolding'])->name('holdings.usuario.destroy');

    // Empresas
    Route::get('/holdings/index-empresa-empresa', [EmpresaController::class, 'indexEmpresa'])->name('holdings.empresas.index');
    Route::get('/holdings/show-empresa-empresa/{empresa}', [EmpresaController::class, 'showEmpresa'])->name('holdings.empresas.show');
    Route::get('/holdings/create-empresa-empresa', [EmpresaController::class, 'createEmpresa'])->name('holdings.empresas.create');
    Route::post('/holdings/store-empresa-empresa', [EmpresaController::class, 'storeEmpresa'])->name('holdings.empresas.store');
    Route::get('/holdings/edit-empresa-empresa/{empresa}', [EmpresaController::class, 'editEmpresa'])->name('holdings.empresas.edit');
    Route::put('/holdings/update-empresa-empresa/{empresa}', [EmpresaController::class, 'updateEmpresa'])->name('holdings.empresas.update');
    Route::delete('/holdings/destroy-empresa-empresa/{empresa}', [EmpresaController::class, 'destroyEmpresa'])->name('holdings.empresas.destroy');
    Route::get('/holdings/show-colaboradores-empresa/{empresa}', [EmpresaController::class, 'colaboradoresEmpresa'])->name('holdings.empresas.colaboradores');

    // Perfil
    Route::get('/holdings/show-profile', [ProfileController::class, 'showHolding'])->name('holdings.profile.show');
    Route::get('/holdings/edit-profile', [ProfileController::class, 'editHolding'])->name('holdings.profile.edit');
    Route::put('/holdings/update-profile', [ProfileController::class, 'updateHolding'])->name('holdings.profile.update');
    Route::get('/holdings/edit-profile-foto', [ProfileController::class, 'editFotoHolding'])->name('holdings.profile.edit-foto');
    Route::put('/holdings/update-profile-foto', [ProfileController::class, 'updateFotoHolding'])->name('holdings.profile.update-foto');
    Route::get('/holdings/edit-profile-password', [ProfileController::class, 'editPasswordHolding'])->name('holdings.profile.edit-password');
    Route::put('/holdings/update-profile-password', [ProfileController::class, 'updatePasswordHolding'])->name('holdings.profile.update-password');

    // Perfil Holding
    Route::get('/holdings/show-profile-holding', [EmpresaPerfilController::class, 'showHolding'])->name('holdings.holding_profile.show');
    Route::get('/holdings/edit-profile-holding', [EmpresaPerfilController::class, 'editHolding'])->name('holdings.holding_profile.edit');
    Route::put('/holdings/update-profile-holding', [EmpresaPerfilController::class, 'updateHolding'])->name('holdings.holding_profile.update');
    Route::get('/holdings/show-colaboradores-holding', [EmpresaPerfilController::class, 'colaboradoresHolding'])->name('holdings.holding_profile.colaboradores');



    // Rotas para as Empresas

    //Login admin
    Route::get('/empresas/admin-login', [LoginController::class, 'showAdminLogin'])->name('empresas.admin.login');
    Route::post('/empresas/admin-login', [LoginController::class, 'adminLogin'])->name('empresas.admin.loginProcess');
    Route::get('/empresas/admin-logout', [AdminController::class, 'adminLogout'])->name('empresas.admin.logout');

    // Rotas admin (Protegidas)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/empresas/index-admin', [AdminController::class, 'index'])->name('empresas.admin.dashboard');
    });

    // Dashboard
    Route::get('/empresas/dashboard', [DashboardController::class, 'empresaDashboard'])->name('empresas.dashboard.dashboard');

    // Usuário
    Route::get('/empresas/index-usuario', [UsuarioController::class, 'indexEmpresa'])->name('empresas.usuario.index');
    Route::get('/empresas/show-usuario/{usuario}', [UsuarioController::class, 'showEmpresa'])->name('empresas.usuario.show');
    Route::get('/empresas/create-usuario', [UsuarioController::class, 'createEmpresa'])->name('empresas.usuario.create');
    Route::post('/empresas/store-usuario', [UsuarioController::class, 'storeEmpresa'])->name('empresas.usuario.store');
    Route::get('/empresas/edit-usuario/{usuario}', [UsuarioController::class, 'editEmpresa'])->name('empresas.usuario.edit');
    Route::put('/empresas/update-usuario/{usuario}', [UsuarioController::class, 'updateEmpresa'])->name('empresas.usuario.update');
    Route::get('/empresas/edit-usuario-password/{usuario}', [UsuarioController::class, 'editPasswordEmpresa'])->name('empresas.usuario.edit-password');
    Route::put('/empresas/update-usuario-password/{usuario}', [UsuarioController::class, 'updatePasswordEmpresa'])->name('empresas.usuario.update-password');
    Route::delete('/empresas/destroy-usuario/{usuario}', [UsuarioController::class, 'destroyEmpresa'])->name('empresas.usuario.destroy');

    // Perfil
    Route::get('/empresas/show-profile', [ProfileController::class, 'showEmpresa'])->name('empresas.profile.show');
    Route::put('/empresas/update-profile', [ProfileController::class, 'updateEmpresa'])->name('empresas.profile.update');
    Route::put('/empresas/update-profile-foto', [ProfileController::class, 'updateFotoEmpresa'])->name('empresas.profile.update-foto');
    Route::put('/empresas/update-profile-password', [ProfileController::class, 'updatePasswordEmpresa'])->name('empresas.profile.update-password');

    // Perfil Empresa
    Route::get('/empresas/show-profile-empresa', [EmpresaPerfilController::class, 'showEmpresa'])->name('empresas.empresa_profile.show');
    Route::get('/empresas/edit-profile-empresa', [EmpresaPerfilController::class, 'editEmpresa'])->name('empresas.empresa_profile.edit');
    Route::put('/empresas/update-profile-empresa', [EmpresaPerfilController::class, 'updateEmpresa'])->name('empresas.empresa_profile.update');

    // Agenda
    Route::get('/empresas/agenda', [TarefaController::class, 'index'])->name('empresas.tarefa.index');
    Route::get('/empresas/agenda/create/{data}', [TarefaController::class, 'create'])->name('empresas.tarefa.create');
    Route::post('/empresas/agenda/store', [TarefaController::class, 'store'])->name('empresas.tarefa.store');
    Route::get('/empresas/agenda/edit/{tarefa}', [TarefaController::class, 'edit'])->name('empresas.tarefa.edit');
    Route::put('/empresas/agenda/update/{tarefa}', [TarefaController::class, 'update'])->name('empresas.tarefa.update');
    Route::delete('/empresas/agenda/destroy/{tarefa}', [TarefaController::class, 'destroy'])->name('empresas.tarefa.destroy');
    Route::get('/empresas/agenda/tarefas/{data}', [TarefaController::class, 'showTarefas'])->name('empresas.tarefa.show');

    // Tomador de serviço
    Route::get('/empresas/index-tomador-servico', [TomadorServicoController::class, 'index'])->name('empresas.tomador.index');
    Route::get('/empresas/show-tomador-servico/{tomadorservico}', [TomadorServicoController::class, 'show'])->name('empresas.tomador.show');
    Route::get('/empresas/create-tomador-servico', [TomadorServicoController::class, 'create'])->name('empresas.tomador.create');
    Route::post('/empresas/store-tomador-servico', [TomadorServicoController::class, 'store'])->name('empresas.tomador.store');
    Route::get('/empresas/edit-tomador-servico/{tomadorservico}', [TomadorServicoController::class, 'edit'])->name('empresas.tomador.edit');
    Route::put('/empresas/update-tomador-servico/{tomadorservico}', [TomadorServicoController::class, 'update'])->name('empresas.tomador.update');
    Route::delete('/empresas/destroy-tomador-servico/{tomadorservico}', [TomadorServicoController::class, 'destroy'])->name('empresas.tomador.destroy');
    Route::get('/empresas/tomador-documentos/{tomadorservico}', [TomadorServicoController::class, 'documentos'])->name('empresas.tomador.documentos');
    Route::post('/tomadores/store-documentos/{tomadorservico}', [TomadorServicoController::class, 'storeDocumentos'])->name('empresas.tomador.storeDocumentos');
    Route::delete('/empresas/excluir-documentos/{tomadorservico}', [TomadorServicoController::class, 'destroyDocumento'])->name('empresas.tomador.documentosDestroy');
    Route::get('/empresas/gerarPDF/{tomadorservico}', [TomadorServicoController::class, 'pdfDados'])->name('empresas.tomador.pdfDados');

    // Sócios
    Route::get('/empresas/tomadores/sociosShow/{tomadorservico}/{socio}', [SocioController::class, 'sociosShow'])->name('empresas.tomador.sociosShow');
    Route::get('/empresas/tomadores/sociosIndex/{tomadorservico}/{socio}/documentos', [SocioController::class, 'sociosDocumentos'])->name('empresas.tomador.sociosDocumentos');

    // Assinaturas
    Route::get('/empresas/configuracao-assinatura', [AssinaturaController::class, 'config'])->name('empresas.assinatura.configuracao');
    Route::post('/empresas/assinatura-update', [AssinaturaController::class, 'update'])->name('empresas.assinatura.update');
    Route::get('/empresas/cupons', [CupomController::class, 'indexCupom'])->name('empresas.assinatura.cupom');
    Route::post('/empresas/cupoms-store', [CupomController::class, 'storeCupom'])->name('empresas.assinatura.storeCupom');
    Route::delete('/empresas/cupons-delete/{cupom}', [CupomController::class, 'deleteCupom'])->name('empresas.assinatura.deleteCupom');

    // Guias e Impostos
    Route::get('/empresas/guias_impostos_create/{tomadorservico}', [GuiaImpostoController::class, 'create'])->name('empresas.impostos.create');

    // Contabilidade
    Route::get('/empresas/balancete/{tomadorservico}', [TomadorContabilidadeController::class, 'balancete'])->name('empresas.contabilidade.balancete');
    Route::post('/empresa/gerar-balancete/{tomadorservico}', [TomadorContabilidadeController::class, 'gerarBalancete'])->name('empresas.contabilidade.gerarBalancete');
    Route::get('/empresa/balancete/{tomadorservico}/pdf/{mes}/{ano}', [TomadorContabilidadeController::class, 'downloadPdf'])->name('empresas.contabilidade.balancetePdf');

    // Rotas para os Tomadores de Serviço

    // Dashboard
    Route::get('/tomadores/dashboard', [DashboardController::class, 'tomadorDashboard'])->name('tomadores.dashboard.dashboard');

    // Clientes
    Route::get('/tomadores/index-clientes', [ClienteController::class, 'indexCliente'])->name('tomadores.clientes.index');
    Route::get('/tomadores/show-clientes-cpf/{cliente}', [ClienteController::class, 'showClienteCpf'])->name('tomadores.clientes.showCpf');
    Route::get('/tomadores/show-clientes-cnpj/{cliente}', [ClienteController::class, 'showClienteCnpj'])->name('tomadores.clientes.showCnpj');
    Route::get('/tomadores/create-clientes-cfp', [ClienteController::class, 'createClienteCpf'])->name('tomadores.clientes.createCpf');
    Route::post('/tomadores/store-clientes-cpf', [ClienteController::class, 'storeClienteCpf'])->name('tomadores.clientes.storeCpf');
    Route::get('/tomadores/edit-clientes-cpf/{cliente}', [ClienteController::class, 'editClienteCpf'])->name('tomadores.clientes.editCpf');
    Route::put('/tomadores/update-clientes-cpf/{cliente}', [ClienteController::class, 'updateClienteCpf'])->name('tomadores.clientes.updateCpf');
    Route::get('/tomadores/create-clientes-cnpj', [ClienteController::class, 'createClienteCnpj'])->name('tomadores.clientes.createCnpj');
    Route::post('/tomadores/store-clientes-cnpj', [ClienteController::class, 'storeClienteCnpj'])->name('tomadores.clientes.storeCnpj');
    Route::get('/tomadores/edit-clientes-cnpj/{cliente}', [ClienteController::class, 'editClienteCnpj'])->name('tomadores.clientes.editCnpj');
    Route::put('/tomadores/update-clientes-cnpj/{cliente}', [ClienteController::class, 'updateClienteCnpj'])->name('tomadores.clientes.updateCnpj');
    Route::delete('/tomadores/destroy-clientes/{cliente}', [ClienteController::class, 'destroyCliente'])->name('tomadores.clientes.destroy');

    // Assinatura
    Route::get('/tomadores/minhaAssinatura', [AssinaturaController::class, 'showAssinatura'])->name('tomadores.assinatura.showAssinatura');

    // Planos
    Route::get('/tomadores/planos', [TomadorServicoController::class, 'planos'])->name('tomadores.planos.index');

    // Perfil
    Route::get('/tomadores/show-profile', [TomadorPerfilController::class, 'showTomador'])->name('tomadores.profile.show');
    Route::put('tomadores/update-password', [TomadorPerfilController::class, 'updatePassword'])->name('tomadores.profile.update-password');
    Route::get('/tomadores/adicionar-documentos', [TomadorPerfilController::class, 'addDocumentos'])->name('tomadores.profile.addDocumentos');
    Route::post('/tomadores/store-documentos', [TomadorPerfilController::class, 'storeDocumentos'])->name('tomadores.profile.storeDocumentos');
    Route::get('/tomadores/edit-profile', [TomadorPerfilController::class, 'editTomador'])->name('tomadores.profile.edit');
    Route::put('/tomadores/update-profile/{tomador}', [TomadorPerfilController::class, 'updateTomador'])->name('tomadores.profile.update');
    Route::get('tomadores/adicionar_socio', [TomadorPerfilController::class, 'addSocio'])->name('tomadores.profile.addSocios');
    Route::post('tomadores/store_socio', [TomadorPerfilController::class, 'storeSocio'])->name('tomadores.profile.storeSocios');

    // Guias e Impostos
    Route::get('tomadores/guias_impostos_index', [GuiaImpostoController::class, 'index'])->name('tomadores.impostos.index');

    // Agenda
    Route::get('/tomadores/agenda', [TarefaController::class, 'indexTomador'])->name('tomadores.tarefas.index');
    Route::get('tomadores/tarefa/show/{data}', [TarefaController::class, 'showTomador'])->name('tomadores.tarefa.show');

    // Contabilidade
    Route::get('tomadores/upload-csv', [TomadorContabilidadeController::class, 'uploadCsv'])->name('tomadores.contabilidade.uploadCsv');
    Route::post('tomadores/processar-csv', [TomadorContabilidadeController::class, 'processarCsv'])->name('tomadores.contabilidade.processarCsv');
});
