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

                    <canvas id="door" width="100" height="100"></canvas>
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
    $.ajaxSetup({
        headers: {
            'X-API-TOKEN': '{!! auth()->user()->api_token !!}',
        }
    });
    $('document').ready(function() {
        ctx.fillStyle = "rgb(42, 159, 214)";

        checkState();

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

    function checkState() {
        $.ajax({
            url: '/api/garage-door/1',
            success: function(data) {
                switch (data.state) {
                    case 'open':
                        drawOpen();
                        setTimeout(function () {
                            $('#door').data('state', 'open');
                        }, 200);
                        break;
                    case 'closed':
                        drawClosed();
                        setTimeout(function () {
                            $('#door').data('state', 'closed');
                        }, 200);
                        break;
                    default: break;
                }
            },
            failure: function(data) {
                console.dir('fail');
            }
        });
    }

    function triggerDoor() {
        $.ajax({
            url: '/api/garage-door/trigger/1',
            success: function(data) {
                console.dir('success');
            },
            failure: function(data) {
                console.dir('fail');
            }
        });
    }

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
        $('#door').data('state', 'closing');
        triggerDoor();
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
                                $('#door').data('state', 'closed');
                                checkState();
                            }
                        }
                    }, 1000*j + 5000*i);
                }
            }
        }
    }

    function openDoor() {
        $('#door').data('state', 'opening');
        triggerDoor();
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
                                $('#door').data('state', 'open');
                                checkState();
                            }
                        }
                    }, 1000*j + 5000*i);
                }
            }
        }
    }
</script>
@endsection
