@extends('admin.layouts.master')

@section('title', 'User List')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-responsive table-responsive-data2">
                        <h3>Total - {{ $user->total() }}</h3>
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id='dataList'>
                                @foreach ($user as $u)
                                    <tr class="tr-shadow">
                                        <td class="col-1">
                                            @if ($u->image == null)
                                                @if ($u->gender == 'male')
                                                    <img src="{{ asset('image/default.png') }}"
                                                        class="img-thumbnail shadow-sm">
                                                @else
                                                    <img src="{{ asset('image/default-female.jpg') }}"
                                                        class="img-thumbnail shadow-sm">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $u->image) }}"
                                                    class="img-thumbnail shadow-sm">
                                            @endif
                                        </td>
                                        <input type="hidden" class="userId" value="{{ $u->id }}">
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->gender }}</td>
                                        <td>{{ $u->phone }}</td>
                                        <td>{{ $u->address }}</td>
                                        <td>
                                            <select class="form-control" id="changeStatus">
                                                <option value="admin" @if ($u->role == 'admin') selected @endif>
                                                    Admin</option>
                                                <option value="user" @if ($u->role == 'user') selected @endif>
                                                    User</option>
                                            </select>
                                        </td>
                                        <td>
                                            <a href="{{ route('user#deleteUser', $u->id) }}">
                                                <button class="item" data-toggle="tooltip" data-placement="top"
                                                    title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- END DATA TABLE -->
                        <div class="mt-3">
                            {{ $user->links() }}
                        </div>
                    </div>
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
                    url: '/user/changeRole',
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
