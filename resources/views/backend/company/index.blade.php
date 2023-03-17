@extends('layouts.backend')
@section('title', 'All Companies')
@section('content')
  <div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-end">
      <div class="flex">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Company</li>
          </ol>
        </nav>
        <h1 class="m-0">Company</h1>
      </div>
    </div>
  </div>
  <div class="container-fluid">
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
                <h4 class=" text-center">Active Companies</h4>
              </div>
              <div class="card-body">
                <table class="table" id="table3">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Logo</th>
                      <th>Company Name</th>
                      <th>Email</th>
                      <th>Company Website</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($activeCompany as $company)
                      <tr>
                        <td>{{ $company->id }}</td>
                        <td>
                          <img src="{{ asset('storage/company/' . $company->logo) }}" width="60" alt="image">
                        </td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ Str::limit($company->website, 30, '...') }}</td>
                        <td>

                          <a href="{{ route('backend.company.edit', $company->id) }}"
                            class=" btn btn-sm btn-info">Edit</a>
                          <a href="{{ route('backend.company.status', $company->id) }}"
                            class=" btn {{ $company->status == 'publish' ? 'btn btn-warning' : 'btn btn-success' }}">{{ $company->status == 'publish' ? 'Draft' : 'Publish' }}</a>
                          <a href="{{ route('backend.company.trash', $company->id) }}"
                            class=" btn btn-sm btn-warning">Trash</a>
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
                <h4 class="text-center">Draft companys</h4>
              </div>
              <div class="card-body">
                <table class="table" id="table2">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Logo</th>
                      <th>Company Name</th>
                      <th>Email</th>
                      <th>Company Website</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($draftCompany as $company)
                      <tr>
                        <td>{{ $company->id }}</td>
                        <td>
                          <img src="{{ asset('storage/company/' . $company->logo) }}" width="60" alt="image">
                        </td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ Str::limit($company->website, 30, '...') }}</td>
                        <td>

                          <a href="{{ route('backend.company.edit', $company->id) }}"
                            class=" btn btn-sm btn-info">Edit</a>
                          <a href="{{ route('backend.company.status', $company->id) }}"
                            class=" btn {{ $company->status == 'publish' ? 'btn btn-warning' : 'btn btn-success' }}">{{ $company->status == 'publish' ? 'Draft' : 'Publish' }}</a>
                          <a href="{{ route('backend.company.trash', $company->id) }}"
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
                <h4 class="text-center">Trashed company</h4>
              </div>
              <div class="card-body">
                <table class=" table" id="table3">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Logo</th>
                      <th>Company Name</th>
                      <th>Email</th>
                      <th>Company Website</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($trashCompany as $company)
                      <tr>
                        <td>{{ $company->id }}</td>
                        <td>
                          <img src="{{ asset('storage/company/' . $company->logo) }}" width="60" alt="image">
                        </td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ Str::limit($company->website, 30, '...') }}</td>
                        <td>

                          <a href="{{ route('backend.company.reStore', $company->id) }}"
                            class=" btn btn-sm btn-success">Restore</a>
                          <form action="{{ route('backend.company.delete', $company->id) }}" class="d-inline"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                              onclick="return confirm('Are you Sure to Delete?')">Delete</button>
                          </form>

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
