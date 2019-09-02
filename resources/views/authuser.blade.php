@extends('layouts.master')

@section('breadcrumb')
                            <h4 class="page-title">Dashboard</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">Welcome to POS Sample Dashboard</li>
                            </ol>
@endsection

@section('content')
            <div class="container-fluid">
                <div class="col-xl-20">
                    <div class="card m-b-12">
                        <div class="card-body">
                            <div class="row text-center m-t-20">
                                <div class="col-12">
<!-- Button trigger modal -->
  <hr>


  <!--Table-->
  <div>
    <table class="table table-hover table-borderless table-striped">
      <thead class="thead-dark">
      <tr>
        <th>Nama User</th>
        <th>Email</th>
        <th>Action</th>
      </tr>
    </thead>
      @foreach($user as $u)
      <tr>
        <td>{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>
            @if ($u->level == 1)
            <a href="#" class="badge badge-light">Verified</a>
            @else
            <a href="/verify/{{$u->id}}" class="badge badge-warning">Verify</a>
            @endif
        </td>
 
        </td>
      </tr>
      @endforeach
    </table>
  </div>
            </div>
          </div>
        </div>
      </div>
    </div>   
  </div> <!-- end container -->
<!-- end wrapper -->
@endsection