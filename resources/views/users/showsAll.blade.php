@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User Shows</div>

                    <div class="card-body">
                        <ul id="users" class="list-group">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="module">
        window.axios.get('/api/users')
            .then((response) => {
                const usersElement = document.getElementById('users');

                let users = response.data;

                usersElement.innerHTML = users.map((values,index) => {
                return ` <li id="${values.id}" class="list-group-item">${values.name} </li>`
                }).join(' ');
            })
    </script>

    <script type="module" >
        Echo.channel('users')
            .listen('UserCreated',(e) => {
                const usersElement = document.getElementById('users');
                let element = document.createElement('li');
                element.setAttribute('data-id',e.user.id);
                element.classList.add('list-group-item');
                element.innerText = e.user.name;
                usersElement.appendChild(element);
            })
            .listen('UserUpdate',(e) => {
                const element = document.getElementById(e.user.id);
                element.innerText = e.user.name;
            })
            .listen('UserDelete',(e) => {
                const element = document.getElementById(e.user.id);
                element.parentNode.removeChild(element);
            })
    </script>
@endpush
