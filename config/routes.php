<?php

$routes->get('/', function() {
    KayttajaController::etusivu();
});

$routes->get('/kirjaudu', function() {
    KayttajaController::etusivu();
});

$routes->post('/kirjaudu', function() {
    KayttajaController::kirjaudu();
});

$routes->get('/ulos', function() {
    KayttajaController::ulos();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/etusivu', function() {
    HelloWorldController::etusivu();
});

$routes->get('/esittelyOsa/:id', function($id) {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    OsaController::Osan_esittely($id);
});

$routes->get('/esittelyOsa/:id/poista', function($id) {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    OsaController::poistaOsa($id);
});

$routes->get('/esittelyTrilogia/:id/lisaaOsa', function($id) {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    OsaController::lisays($id);
});

$routes->post('/esittelyTrilogia/:id/lisaaOsa', function($id) {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    OsaController::lisaa($id);
});

$routes->get('/esittelyTrilogia/:id', function($id) {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    TrilogiaController::esittely($id);
});

$routes->get('/lisaa', function() {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    TrilogiaController::lisays();
});

$routes->post('/esittelyTrilogia', function() {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    TrilogiaController::lisaa();
});

$routes->get('/listaus', function() {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    TrilogiaController::listaaTrilogiat();
});

$routes->get('/muokkausOsa', function() {
    HelloWorldController::muokkausOsa();
});

$routes->get('/esittelyTrilogia/:id/muokkaa', function($id) {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    TrilogiaController::muokkaa($id);
});

$routes->post('/esittelyTrilogia/:id/muokkaa', function($id) {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    TrilogiaController::paivita($id);
});

$routes->get('/esittelyTrilogia/:id/poista', function($id) {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    TrilogiaController::poista($id);
});

$routes->get('/esittelyOsa/:id/muokkaa', function($id) {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    OsaController::muokkaa($id);
});

$routes->post('/esittelyOsa/:id/muokkaa', function ($id) {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    OsaController::paivita($id);
});

$routes->get('/haku', function() {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    TrilogiaController::haku();
});

$routes->post('/haku/tulokset', function() {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === NULL) {
        KayttajaController::ulos();
    }
    TrilogiaController::tulokset();
});
