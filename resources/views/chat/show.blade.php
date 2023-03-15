@extends('layouts.app')
@push('styles')
    <style>
        #chat1 .form-outline .form-control~.form-notch div {
            pointer-events: none;
            border: 1px solid;
            border-color: #eee;
            box-sizing: border-box;
            background: transparent;
        }

        #chat1 .form-outline .form-control~.form-notch .form-notch-leading {
            left: 0;
            top: 0;
            height: 100%;
            border-right: none;
            border-radius: .65rem 0 0 .65rem;
        }

        #chat1 .form-outline .form-control~.form-notch .form-notch-middle {
            flex: 0 0 auto;
            max-width: calc(100% - 1rem);
            height: 100%;
            border-right: none;
            border-left: none;
        }

        #chat1 .form-outline .form-control~.form-notch .form-notch-trailing {
            flex-grow: 1;
            height: 100%;
            border-left: none;
            border-radius: 0 .65rem .65rem 0;
        }

        #chat1 .form-outline .form-control:focus~.form-notch .form-notch-leading {
            border-top: 0.125rem solid #39c0ed;
            border-bottom: 0.125rem solid #39c0ed;
            border-left: 0.125rem solid #39c0ed;
        }

        #chat1 .form-outline .form-control:focus~.form-notch .form-notch-leading,
        #chat1 .form-outline .form-control.active~.form-notch .form-notch-leading {
            border-right: none;
            transition: all 0.2s linear;
        }

        #chat1 .form-outline .form-control:focus~.form-notch .form-notch-middle {
            border-bottom: 0.125rem solid;
            border-color: #39c0ed;
        }

        #chat1 .form-outline .form-control:focus~.form-notch .form-notch-middle,
        #chat1 .form-outline .form-control.active~.form-notch .form-notch-middle {
            border-top: none;
            border-right: none;
            border-left: none;
            transition: all 0.2s linear;
        }

        #chat1 .form-outline .form-control:focus~.form-notch .form-notch-trailing {
            border-top: 0.125rem solid #39c0ed;
            border-bottom: 0.125rem solid #39c0ed;
            border-right: 0.125rem solid #39c0ed;
        }

        #chat1 .form-outline .form-control:focus~.form-notch .form-notch-trailing,
        #chat1 .form-outline .form-control.active~.form-notch .form-notch-trailing {
            border-left: none;
            transition: all 0.2s linear;
        }

        #chat1 .form-outline .form-control:focus~.form-label {
            color: #39c0ed;
        }

        #chat1 .form-outline .form-control~.form-label {
            color: #bfbfbf;
        }
    </style>
@endpush
@section('content')
        <div class="container">

            <div class="row d-flex justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-10">

                    <div class="card" id="chat1" style="border-radius: 15px;">
                        <div
                            class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
                            style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                            <i class="fas fa-angle-left"></i>
                            <p class="mb-0 fw-bold">Live chat</p>
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="card-body" id="messages">

{{--                            <div class="d-flex flex-row justify-content-start mb-4">--}}
{{--                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"--}}
{{--                                     alt="avatar 1" style="width: 45px; height: 100%;">--}}
{{--                                <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">--}}
{{--                                    <p class="small mb-0">Hello and thank you for visiting MDBootstrap. Please click the video--}}
{{--                                        below.</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="d-flex flex-row justify-content-end mb-4">--}}
{{--                                <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">--}}
{{--                                    <p class="small mb-0">Thank you, I really like your product.</p>--}}
{{--                                </div>--}}
{{--                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp"--}}
{{--                                     alt="avatar 1" style="width: 45px; height: 100%;">--}}
{{--                            </div>--}}




                        </div>
                        <div class="p-2">
                            <form action="">
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="message">Type your message</label>
                                    <textarea class="form-control" id="message" rows="4"></textarea>
                                </div>
                                <div class="flex-ipn" style="width:100%; height: 30px; position: relative">
                                    <button style="float: right" type="submit" id="send" class="btn btn-primary ">Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
                <div class="col-md-4 col-lg-6 col-xl-2">
                    <p><strong>Online now</strong></p>
                    <ul
                        id="users"
                        class="list-group text-info w-50"
                    >
                    </ul>
                </div>
            </div>

        </div>
@endsection
@push('scripts')
    <script type="module">
        const userElement = document.getElementById('users');
        const userMessage = document.getElementById('messages');

        Echo.join('chat')
            .here((users) => {
                userElement.innerHTML = users.map((values,index) => {
                    return ` <li id="${values.id}" onclick="greetUser(${values.id})" class="list-group-item position-relative">${values.name}
                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                          </span>
                        </li>`
                }).join(' ');
            }).joining((user) => {
                let element = document.createElement('li');
                let elementSpan = document.createElement('span');
                let elementSpanChirld = document.createElement('span');
                elementSpanChirld.classList.add('visually-hidden')
                elementSpan.classList.add('position-absolute','top-0','start-100','translate-middle','p-2','bg-success','border','border-light','rounded-circle')
                element.setAttribute('id', user.id);
                element.setAttribute('onclick', 'greetUser('+ user.id+')');
                element.classList.add('list-group-item','position-relative')
                element.innerText = user.name;
                elementSpan.appendChild(elementSpanChirld);
                element.appendChild(elementSpan);
                userElement.appendChild(element);
        })
            .leaving((user) => {
                const element = document.getElementById(user.id);
                element.parentNode.removeChild(element);
            })
            .listen('SentMessege',(e)=>{
                const elementDiv = document.createElement('div');
                const elementDivChirld = document.createElement('div');
                const elementP = document.createElement('p');
                const elementImg = document.createElement('img');
                elementDiv.classList.add("d-flex","justify-content-end","mb-4","flex-row","mb-4");
                elementDiv.style.borderRadius = "15px";
                elementDiv.style.background  = "rgba(57, 192, 237,.2)";

                elementDivChirld.classList.add('p-3','me-3','border')
                elementP.classList.add('small','mb-0')
                elementP.innerText = e.user.name + ' : ' + e.message;
                elementImg.src = "https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp";
                elementImg.style.width = "45px";
                elementImg.style.height = "100%";

                elementDivChirld.appendChild(elementP);
                elementDiv.appendChild(elementDivChirld);
                elementDiv.appendChild(elementImg);
                userMessage.appendChild(elementDiv);
            })
    </script>

    <script >
        const messageElement = document.getElementById('message');
        const sendMessage = document.getElementById('send');

        sendMessage.addEventListener('click',(e) => {
            e.preventDefault();

            window.axios.post('/chat/message',{
                message : messageElement.value,
            })
            messageElement.value = '';
        })
    </script>

    <script>
        function greetUser(id){
            window.axios.post('/chat/greet/' + id);
        }
    </script>

    <script type="module">
        const userMessage = document.getElementById('messages');
        Echo.private('chat.greet.{{auth()->user()->id}}')
            .listen('GettingSent',(e) => {
                const elementDiv = document.createElement('div');
                const elementDivChirld = document.createElement('div');
                const elementP = document.createElement('p');
                const elementImg = document.createElement('img');
                elementDiv.classList.add("d-flex","justify-content-end","mb-4","flex-row","mb-4");
                elementDiv.style.borderRadius = "15px";
                elementDiv.style.background  = "rgba(57, 192, 237,.2)";

                elementDivChirld.classList.add('p-3','me-3','border')
                elementP.classList.add('small','mb-0')
                elementP.innerText =  e.message;
                elementImg.src = "https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp";
                elementImg.style.width = "45px";
                elementImg.style.height = "100%";

                elementDivChirld.appendChild(elementP);
                elementDiv.appendChild(elementDivChirld);
                elementDiv.appendChild(elementImg);
                userMessage.appendChild(elementDiv);
            })
    </script>
@endpush
