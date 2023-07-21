@extends('admin.layouts.master')

@section('title', 'Admin List')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Admin List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('category#create') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add item
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span>
                            </h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('admin#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search..."
                                        value="{{ request('key') }}" />
                                    <button class="btn bg-dark text-white" type="submit">
                                        <i class="zmdi zmdi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-1 offset-10 bg-white shadow-sm p-2 text-center">
                            <h3><i class="fa-solid fa-database mr-2"></i> {{ $user->total() }}</h3>
                        </div>
                    </div>


                    @if (session('createSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-regular fa-check"></i> {{ session('createSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    @if (session('deletesuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('deletesuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $u)
                                    <tr class="tr-shadow">
                                        <td class="col-2">
                                            @if ($u->image == null)
                                                @if ($u->gender == 'male')
                                                    <img src="{{ asset('image/default.png') }}" alt="">
                                                @else
                                                    <img src="{{ asset('image/default-female.jpg') }}" alt="">
                                                @endif
                                            @else
                                                <img
                                                    src="{{ asset('storage/' . $u->image) }}"class="img-thumbnail shadow-sm">
                                            @endif
                                        </td>
                                        <input type="hidden" class="userId" value="{{ $u->id }}">
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->gender }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->phone }}</td>
                                        <td>{{ $u->address }}</td>
                                        <td>
                                            @if (Auth::user()->id == $u->id)
                                            @else
                                                <select id="changeStatus">
                                                    <option value="admin"@if ($u->role == 'admin') selected @endif>
                                                        Admin</option>
                                                    <option value="user"@if ($u->role == 'user') selected @endif>
                                                        User</option>
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            @if (Auth::user()->id == $u->id)
                                            @else
                                                <a href="{{ route('admin#delete', $u->id) }}">
                                                    <button class="item me-1" data-toggle="tooltip" data-palacement="top"
                                                        title="Delete"> <i class="fa-solid fa-trash-can"></i></button>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $user->links() }}
                        </div>
                    </div>

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('scriptSection')
    <script>
        $(document).ready(function() {
            $('#changeStatus').change(function() {
                $currentStatus = $(this).val()
                $parentNode = $(this).parents('tr')
                $userId = $parentNode.find('.userId').val()
                $.ajax({
                    type: 'get',
                    url: 'http://localhost/lara_auth/public/admin/changeRole',
                    data: {
                        'userId': $userId,
                        'role': $currentStatus
                    },
                    dataType: 'json',
                })
                location.reload();
            })
        })
    </script>
@endsection
