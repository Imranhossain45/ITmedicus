@extends('layouts.backend')
@section('title', 'All employees')
@section('content')
  <div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-end">
      <div class="flex">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">employee</li>
          </ol>
        </nav>
        <h1 class="m-0">employee</h1>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row justify-content-center">
      <div class=" col-lg-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">

          <li class="nav-item" role="presentation">
            <button class="nav-link active" data-toggle="tab" data-target="#active"><b>Active</b></button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" data-toggle="tab" data-target="#draft"><b>Draft</b></button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" data-toggle="tab" data-target="#trash"><b>Trash</b></button>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="active">
            <div class="card">
              <div class="card-header">
                <h4 class=" text-center">Active Employees</h4>
              </div>
              <div class="card-body">
                <table class=" table" id="table1">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Company Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($activeEmployee as $employee)
                      <tr>
                        <td>{{ $employee->id }}</td>
                        <td>
                          <img src="{{ asset('storage/employee/' . $employee->photo) }}" width="60" alt="image">
                        </td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->company->name }}</td>
                        <td>

                          <a href="{{ route('backend.employee.edit', $employee->id) }}"
                            class=" btn btn-sm btn-info">Edit</a>
                          <a href="{{ route('backend.employee.status', $employee->id) }}"
                            class=" btn {{ $employee->status == 'publish' ? 'btn btn-warning' : 'btn btn-success' }}">{{ $employee->status == 'publish' ? 'Draft' : 'Publish' }}</a>
                          <a href="{{ route('backend.employee.trash', $employee->id) }}"
                            class=" btn btn-sm btn-warning">Trash</a>


                          </form>
                        </td>
                      </tr>
                    @endforeach

                  </tbody>

                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="draft">
            <div class="card">
              <div class="card-header">
                <h4 class=" text-center">Draft Employees</h4>
              </div>
              <div class="card-body">
                <table class="table" id="table2">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Company Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($draftEmployee as $employee)
                      <tr>
                        <td>{{ $employee->id }}</td>
                        <td>
                          <img src="{{ asset('storage/employee/' . $employee->photo) }}" width="60" alt="image">
                        </td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->company->name }}</td>
                        <td>

                          <a href="{{ route('backend.employee.edit', $employee->id) }}"
                            class=" btn btn-sm btn-info">Edit</a>
                          <a href="{{ route('backend.employee.status', $employee->id) }}"
                            class=" btn {{ $employee->status == 'publish' ? 'btn btn-warning' : 'btn btn-success' }}">{{ $employee->status == 'publish' ? 'Draft' : 'Publish' }}</a>
                          <a href="{{ route('backend.employee.trash', $employee->id) }}"
                            class=" btn btn-sm btn-warning">Trash</a>
                        </td>
                      </tr>
                    @endforeach

                  </tbody>

                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="trash">
            <div class="card">
              <div class="card-header">
                <h4 class=" text-center">Trashed employee</h4>
              </div>
              <div class="card-body">
                <table class=" table" id="table3">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Company Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($trashEmployee as $employee)
                      <tr>
                        <td>{{ $employee->id }}</td>
                        <td>
                          <img src="{{ asset('storage/employee/' . $employee->photo) }}" width="60" alt="image">
                        </td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->company->name }}</td>
                        <td>
                          <a href="{{ route('backend.employee.reStore', $employee->id) }}"
                            class=" btn btn-sm btn-success">Restore</a>
                          <a href="{{ route('backend.employee.delete', $employee->id) }}" class=" btn btn-sm btn-danger"
                            onclick="return confirm('Are you Sure to Delete?')"> Delete </a>
                        </td>
                      </tr>
                    @endforeach

                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
@section('script')
  <script>
    $(document).ready(function() {
      $('#table1').dataTable({

      });
      $('#table2').dataTable({

      });
      $('#table3').dataTable({

      });
    });
  </script>
@endsection
