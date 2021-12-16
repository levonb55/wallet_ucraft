@extends('layouts.app')

@section('content')
    <div class="container">

        @include('blocks.messages')

        <div class="row mb-4">
            <div class="col-md-3">
                <p>Total Balance: {{format_number($totalBalance)}}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
               <h4>Available Cards</h4>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                    <i class="fas fa-plus"></i> Add Card
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                @if($cards->count() > 0)
                    <ul class="list-group">
                        @foreach($cards as $card)
                            <li class="list-group-item">
                                <img src="https://img.icons8.com/color/48/000000/{{$card['type']}}.png"/>
                                <ul class="list-group">
                                    <li class="list-group-item">Number: {{$card['number']}}</li>
                                    <li class="list-group-item">Balance: {{format_number($card['amount'])}}</li>
                                </ul>
                                <form action="{{route('cards.destroy', $card['id'])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mt-2 float-right">Remove</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <h6>No card is registered!</h6>
                @endif
            </div>
        </div>
    </div>

    <form action="{{route('cards.store')}}" method="POST">
        @csrf
        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add Card</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="card-type">Choose card type</label>
                            <select class="form-control" id="card-type" name="type">
                                <option value="{{\App\Models\Card::CARD_VISA}}">Visa</option>
                                <option value="{{\App\Models\Card::CARD_MASTERCARD}}">Master</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="card-number">Card Number</label>
                            <input type="text" class="form-control" id="card-number" name="number" value="{{old('number')}}" autocomplete="off">
                            @error('number')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cardholder-name">Cardholder Name</label>
                            <input type="text" class="form-control" id="cardholder-name" name="cardholder_name" value="{{old('cardholder_name')}}" autocomplete="off">
                            @error('cardholder_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="expiration-date">Expiration Date</label>
                            <input type="text" class="form-control" id="expiration-date" name="expiration_date" value="{{old('expiration_date')}}" autocomplete="off">
                            @error('expiration_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cvc">CVC</label>
                            <input type="text" class="form-control" id="cvc" name="cvc" value="{{old('cvc')}}" autocomplete="off">
                            @error('cvc')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Register</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection
