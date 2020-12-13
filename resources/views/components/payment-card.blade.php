<div class="card">
    <div class="card-header">
        <strong>Credit Card</strong>
        <small>enter your card details</small>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="owner">Name</label>
                    <input class="form-control @error('ccnumber') is-invalid @enderror" value="{{ old('owner') }}" name="owner" id="owner" type="text" placeholder="Enter your name">
                    @error('owner')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="type">Year</label>
                    <select class="form-control" id="type" name="type">
                        <option @if(old('type')=='Visa') selected @endif>Visa</option>
                        <option @if(old('type')=='Discover Card') selected @endif>Discover Card</option>
                        <option @if(old('type')=='MasterCard') selected @endif>MasterCard</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="ccnumber">Credit Card Number</label>
                    <div class="input-group">
                        <input id="ccnumber" class="form-control ccnumber @error('number') is-invalid @enderror"  value="{{ old('number') }}" name="number" type="text" placeholder="0000 0000 0000 0000" autocomplete="email">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="mdi mdi-credit-card"></i>
                            </span>
                        </div>
                    </div>
                    @error('number')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="expiration_date">Valid Until</label>
                    <div class="input-group">
                        <input id="expiration_date" class="form-control expiration_date @error('expiration_date') is-invalid @enderror" value="{{ old('expiration_date') }}" name="expiration_date" type="text" placeholder="01/20">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="mdi mdi-credit-card"></i>
                            </span>
                        </div>
                    </div>
                    @error('expiration_date')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="cvv">CVV/CVC</label>
                    <input class="form-control @error('ccv') is-invalid @enderror" value="{{ old('ccv') }}" id="cvv" type="number" placeholder="123" name="ccv">
                     @error('ccv')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-sm btn-success float-right" type="submit">Continue</button>
    </div>
</div>
