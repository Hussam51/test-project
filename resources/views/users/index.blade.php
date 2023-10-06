@extends('Layout.dashboard')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <table class="table">
                    <thead class="table table-info">

                        <tr>
                            <td>Id</td>
                            <td>Name</td>
                            <td>Phone</td>
                            <td>Email</td>
                            <td>Status</td>
                            <td colspan="2">Options</td>
                            <td></td>

                        </tr>

                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr id="{{$user->id}}">
                                @php
                                    $i = 1;
                                @endphp
                                <td>{{ $i++ }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->status }}</td>
                                <td>
                                    <div style="display:inline-block">

                                        <select name="status" class="status" data-id="{{ $user->id }}">
                                            <option value="">pendding</option>
                                            <option value="active">Approve</option>
                                        </select>
                                      
                                    </div>

                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="7">
                                    empty data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $users->links() }}
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->

                </div>
                <!-- ./col -->

                <!-- ./col -->

                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
        @push('scripts')
            <script>
                const csrf_token = "{{ csrf_token() }}";
            </script>
            <script src="{{ asset('cart.js') }}"></script>
        @endpush
    </section>
@endsection
