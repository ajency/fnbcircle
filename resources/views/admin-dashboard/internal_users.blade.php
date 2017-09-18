@extends('layouts.admin-dashboard')

@section('css')
    <!-- Datatables -->
    <link href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-multiselect.min.css" rel="stylesheet">
    <!-- Main styles -->
    <link href="/css/dashboard.css" rel="stylesheet">
@endsection

@section('js')
  @parent
  <script type="text/javascript" src="/bower_components/bootstrap-confirmation2/bootstrap-confirmation.min.js"></script>
@endsection

@section('page-data')

@section