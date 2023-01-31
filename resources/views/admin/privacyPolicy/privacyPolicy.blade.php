@extends('admin.masterAdmin')
@section('title','Privacy Policy')
@section('content')

<link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/editors/quill/katex.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/editors/quill/monokai-sublime.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/editors/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/editors/quill/quill.bubble.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/bootstrap-extended.css')}}">

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0">Privacy and Policy</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Pages</a>
                                </li>
                                <li class="breadcrumb-item active"> Privacy and policies </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section class="full-editor">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Privacy Policy</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body"> 
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="full-wrapper">
                                                <div id="full-container">

                                                    <fieldset class="form-group">
                                                        <label for="basicInput">Basic Input</label>
                                                        <input type="text" class="form-control" id="basicInput" placeholder="Enter email">
                                                    </fieldset>
                                                    <br>


                                                    <label>Privacy Policy</label>
                                                    <div class="editor">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <fieldset class="form-group">
                                                                    <textarea class="form-control" id="basicTextarea" rows="3" placeholder="Textarea"></textarea>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<script src="{{ URL::to('public/app-assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/vendors/js/editors/quill/highlight.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/editors/editor-quill.js') }}"></script>

@endsection