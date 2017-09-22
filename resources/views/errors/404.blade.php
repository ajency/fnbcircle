@extends('layouts.fnbtemplate')
@section('title', '404' )
@section('css')
    <!-- Magnify css -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
    <!-- Font awesome cdn -->
    <link rel="stylesheet" type="text/css" href="/css/font-awesome/css/font-awesome.min.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <!-- Main styles -->
    <link rel="stylesheet" href="/css/main.css">
@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="nf-wrapper text-center flex-row justify-center col-direction">
                    <h1 class="nf-wrapper__title text-primary bolder">404</h1>
                    <h3 class="main-heading text-uppercase nf-wrapper__sub-title">Page not found</h3>
                    <p class="m-b-0 sub-title heavier text-color nf-wrapper__caption">It looks like you're lost...</p>
                    <img src="/img/404.png" class="img-reponsive center-block img-nf">
                    <a href="/"><button class="btn fnb-btn primary-btn full border-btn">Take me out of here</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection