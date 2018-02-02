<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/etusivu', function() {
      HelloWorldController::etusivu();  
  });
  
  $routes->get('/esittelyOsa/:id', function($id) {
      OsaController::Osan_esittely($id);  
  });
  
  $routes->get('/esittelyTrilogia/:id', function($id) {
      TrilogiaController::esittely($id);  
  });
  
  $routes->get('/lisaa', function() {
      TrilogiaController::lisays();
  });
  
  $routes->post('/esittelyTrilogia', function() {
      TrilogiaController::lisaa();
  });
  
  $routes->get('/listaus', function() {
      TrilogiaController::listaaTrilogiat();  
  });
  
  $routes->get('/muokkausOsa', function() {
      HelloWorldController::muokkausOsa();  
  });
  
  $routes->get('/muokkausTrilogia', function() {
      HelloWorldController::muokkausTrilogia();  
  });
  
  $routes->get('/haku', function() {
      HelloWorldController::haku();  
  });