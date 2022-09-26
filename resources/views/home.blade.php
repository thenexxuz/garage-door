@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <canvas id="door" width="100" height="100" data-state="open"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const canvas = $("#door")[0];
    const ctx = canvas.getContext("2d");
    $('document').ready(function() {
        ctx.fillStyle = "rgb(42, 159, 214)";

        drawOpen();

        $('#door').click(function() {
            switch ($('#door').data('state')) {
                case 'open':
                    closeDoor();
                    break;
                case 'closed':
                    openDoor();
                    break;
                default: break;
            }
        });
    });

    function drawOpen() {
        ctx.clearRect(0, 0, 100, 100);
        ctx.beginPath();
        ctx.moveTo(50, 0);
        ctx.lineTo(0, 25);
        ctx.lineTo(100, 25);
        ctx.fill();
        ctx.fillRect(0, 25, 20, 75);
        ctx.fillRect(0, 25, 100, 10);
        ctx.fillRect(80, 25, 20, 75);
    }

    function drawClosed() {
        drawOpen();
        ctx.fillRect(25, 40, 50, 10);
        ctx.fillRect(25, 55, 50, 10);
        ctx.fillRect(25, 70, 50, 10);
        ctx.fillRect(25, 85, 50, 10);
    }

    function closeDoor() {
        console.log('closing');
        $('#door').data('state', 'closing');
        if (canvas.getContext) {
            for(let i = 0; i < 5; i++) {
                for (let j = 0; j < 5; j++) {
                    setTimeout(() => {
                        if (j < 4) {
                            ctx.fillRect(25, 40 + 15 * j, 50, 10);
                        } else {
                            if (i < 4) {
                                drawOpen();
                            } else {
                                console.log('closed');
                                $('#door').data('state', 'closed');
                            }
                        }
                    }, 1000*j + 5000*i);
                }
            }
        }
    }

    function openDoor() {
        console.log('opening');
        $('#door').data('state', 'opening');
        if (canvas.getContext) {
            for(let i = 0; i < 5; i++) {
                for (let j = 0; j < 5; j++) {
                    setTimeout(() => {
                        if (j < 4) {
                            ctx.clearRect(25, 85 - 15 * j, 50, 10);
                        } else {
                            if (i < 4) {
                                drawClosed();
                            } else {
                                console.log('opened');
                                $('#door').data('state', 'open');
                            }
                        }
                    }, 1000*j + 5000*i);
                }
            }
        }
    }
</script>
@endsection
