@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add New Admin</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <form method="POST" action="">
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Name <span style="color: red;">*</span> </label>
                                        <input type="text" required class="form-control" value="{{ old('name') }}"
                                            name="name" placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Email address <span style="color: red;">*</span></label>
                                        <input type="email" value="{{ old('email') }}" required class="form-control"
                                            name="email" placeholder="Enter email">
                                        <p style="color: red;">{{ $errors->first('email') }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Password<span style="color: red;">*</span></label>
                                        <input type="password" required name="password" class="form-control"
                                            placeholder="Password">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
