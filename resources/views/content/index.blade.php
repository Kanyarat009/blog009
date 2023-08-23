@extends('master')

@section('title', 'Content CRUD')

@section('content')

    <body>
        <div class="container">
            <h1>First time to my block content.</h1>


            <div class="mb-2">
                <a href="{{ url('content/create') }}" role="button" class="btn btn-success">Create</a>
               <a href="{{ url('/') }}" role="button" class="btn btn-info">Main Menu</a>
               <a href="{{ url('/login') }}" role="button" class="btn btn-warning float-end">Logout</a>
            </div>



            <table class="table table-bordered" id="tbContent">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
                </script>
                <tr>
                    <th style="width:1cm ">ID</th>
                    <th>Topics</th>
                    <th>Tags</th>
                    <th>Link</th>
                    <th>Date_Create</th>
                    <th>Status</th>
                    <th style="width: 300px">Actions</th>

                </tr>

                @foreach ($contents as $content)
                    <tr>
                        <td style="text-align: center">{{ $content->id }}</td>
                        <td><a herf="{{ url('#') }}" class='detail-item' data-detail="{{ $content->description }}"
                                data-topic="{{ $content->topic }}">{{ $content->topic }}</a></td>
                        <td>{{ $content->tags }}</td>
                        <td><a href="{{ $content->links }}" target="_blank">{{ $content->links }}<a></td>
                        <td>{{ date('d/m/y h:i', strtotime($content->created_at)) }}</td>
                        @if ($content->status == 0)
                            <td>ไม่เเสดง</td>
                            <td><a href="{{ url('/content/EditStatus') }}" role="button"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <button type="button" class="btn btn-success delete-item" data-id="{{ $content->id }}"
                                    data-status="{{ $content->status }}">Enable</button>

                            </td>
                        @else
                            <td>เเสดง</td>
                            <td><a href="{{ url('/content/EditStatus') }}" role="button"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <button type="button" class="btn btn-danger delete-item" data-id="{{ $content->id }}"
                                    data-status="{{ $content->status }}">Disable</button>

                            </td>
                        @endif

                    </tr>
                @endforeach
            </table>
            {{ $contents->links() }}
        </div>


    </body>
@endsection

@push('script')
    <script>
        document.querySelector('#tbContent').addEventListener('click', (e) => {
            if (e.target.matches('.delete-item')) {
                console.log(e.target.dataset.id);
                console.log(e.target.dataset.status);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be edit status!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    //lab 6 edit line 78
                    if (result.isConfirmed) {
                        axios.put($url + '/content/' + e.target.dataset.id + "/" + e.target.dataset.status)
                            .then((response) => {
                                Swal.fire(
                                    'Success!',
                                    'Your status has been edited.',
                                    'success'
                                );
                                setTimeout(() => {
                                    window.location.href = $url + '/content';
                                }, 2000);
                            });
                    }
                });
            }
            //lab 6
            else if (e.target.matches('.detail-item')) {
                Swal.fire({
                    title: "[ " + e.target.dataset.topic + " ]",
                    text: e.target.dataset.detail,
                    icon: 'info',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Close'
                })
            }
        });
    </script>
@endpush
