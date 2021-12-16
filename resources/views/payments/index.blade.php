@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="amount" class="form-control" placeholder="Enter amount" id="amount">
                    </div>

                    <div class="form-group">
                        <label for="card">Select a card</label>
                        <select class="form-control" id="card">
                            @foreach($cards as $card)
                                <option value="{{$card['id']}}">{{format_number($card['amount'])}} ({{$card['number']}} - {{$card['type']}})</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button" class="btn btn-primary">Pay</button>
                </form>
            </div>
        </div>
    </div>
@endsection
