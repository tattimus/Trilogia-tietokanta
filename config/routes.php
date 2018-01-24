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
  
  $routes->get('/esittelyOsa', function() {
      HelloWorldController::esittelyOsa();  
  });
  
  $routes->get('/esittelyTrilogia', function() {
      HelloWorldController::esittelyTrilogia();  
  });
  
  $routes->get('/listaus', function() {
      HelloWorldController::listaus();  
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