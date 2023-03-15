@extends('layouts.app')
@push('styles')
    <style>
        @keyframes rotate{
            from {
                transform :rotate(0deg);
            }
            to {
                transform :rotate(360deg);
            }
        }

        .refresh {
            animation : rotate 1.5s linear infinite;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Game</div>

                    <div class="card-body">
                        <div class="text-center">
                            <img id="circle" src="{{ asset("assets/images/vongquay.png") }}" class="img-fluid w-50 " alt="">
                            <p id="winner" class="display-1 d-none text-primary">win</p>
                        </div>
                        <hr>
                        <div class="text-center">
                            <label for="" class="font-weight-bold h5">Your bet</label>
                            <select id="bet" name="" class="custom-select col-auto form-select">
                                <option selected>Not in</option>
                                @foreach(range(1,12) as $number)
                                    <option>{{$number}}</option>
                                @endforeach
                            </select>
                            <hr>
                            <p class="font-weight-bold h5">Ramaining Time</p>
                            <p id="timer" class="text-danger h5">wating to start</p>
                            <hr>
                            <p id="result" class="h1"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        const circle = document.getElementById('circle');
        const times = document.getElementById('timer');
        const winnerElement = document.getElementById('winner');
        const betElemnet = document.getElementById('bet');
        const resultElement = document.getElementById('result');

        Echo.channel('game')
            .listen('RealTimeTranning',(e) => {
                times.innerText = e.time;

                circle.classList.add('refresh');
                winnerElement.classList.add('d-none')

                resultElement.innerText = '';
                resultElement.classList.remove('text-success');
                resultElement.classList.remove('text-danger');
            })
            .listen('WinnerNumberGenerted',(e) => {
                circle.classList.remove('refresh');

                let winner = e.number;
                winnerElement.innerText = winner ;
                winnerElement.classList.remove('d-none')

                // console.log(betElemnet);
                let bet = betElemnet[betElemnet.selectedIndex].innerText;
                if(bet == winner){
                    resultElement.innerText = "win";
                    resultElement.classList.add('text-success');
                }else  {
                    resultElement.innerText = "lose";
                    resultElement.classList.add('text-danger');
                }
            })
    </script>
@endpush
