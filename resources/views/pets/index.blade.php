@extends('home')

@section('content')
<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">#ID</th>
        <th scope="col">Name</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($pets as $pet)
        <tr>
            <th scope="row">{{$pet->id}}</th>
            <td>{{$pet->name}}</td>
            <td>
                <a class="text-decoration-none" href="{{route('api.edit',$pet->id)}}">
                    <button class="btn btn-info">
                       Edytuj
                    </button>
                </a>
                <button class="btn delete btn-danger" data-id="{{$pet->id}}">Usuń</button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
<script>
    const deleteUrl="{{url('api')}}/";
</script>

