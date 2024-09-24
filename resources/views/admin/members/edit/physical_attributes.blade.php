<div class="card-header bg-dark text-white">
    <h5 class="mb-0 h6">{{translate('Physical Appearance & Life Style')}}</h5>
</div>
<div class="card-body">
    <form action="{{ route('physical-attribute.update', $member->id) }}" method="POST">
        <input name="_method" type="hidden" value="PATCH">
        @csrf
        <div class="form-group row">
            <div class="col-md-6">
                <label for="height">{{translate('Height')}}</label>
                <input type="number" name="height" value="{{ $member->physical_attributes->height ?? "" }}" step="any" class="form-control" placeholder="{{translate('Height')}}" required>
                @error('height')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="weight">{{translate('Weight')}}</label>
                <input type="text" name="weight" value="{{ $member->physical_attributes->weight ?? "" }}" placeholder="{{ translate('Weight') }}" step="any" class="form-control" required>
                @error('weight')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!--<div class="form-group row">-->
        <!--    <div class="col-md-6">-->
        <!--        <label for="eye_color">{{translate('Eye color')}}</label>-->
        <!--        <input type="text" name="eye_color" value="{{ $member->physical_attributes->eye_color ?? "" }}" class="form-control" placeholder="{{translate('Eye Color')}}" required>-->
        <!--        @error('eye_color')-->
        <!--            <small class="form-text text-danger">{{ $message }}</small>-->
        <!--        @enderror-->
        <!--    </div>-->
        <!--    <div class="col-md-6">-->
        <!--        <label for="hair_color">{{translate('Hair Color')}}</label>-->
        <!--        <input type="text" name="hair_color" value="{{ $member->physical_attributes->hair_color ?? "" }}" placeholder="{{ translate('Hair Color') }}" class="form-control" required>-->
        <!--        @error('hair_color')-->
        <!--            <small class="form-text text-danger">{{ $message }}</small>-->
        <!--        @enderror-->
        <!--    </div>-->
        <!--</div>-->

        <!--<div class="form-group row">-->
        <!--    <div class="col-md-6">-->
        <!--        <label for="complexion">{{translate('Complexion')}}</label>-->
        <!--        <input type="text" name="complexion" value="{{ $member->physical_attributes->complexion ?? "" }}" class="form-control" placeholder="{{translate('Complexion')}}" required>-->
        <!--        @error('complexion')-->
        <!--            <small class="form-text text-danger">{{ $message }}</small>-->
        <!--        @enderror-->
        <!--    </div>-->
        <!--    <div class="col-md-6">-->
        <!--        <label for="blood_group">{{translate('Blood Group')}}</label>-->
        <!--        <input type="text" name="blood_group" value="{{ $member->physical_attributes->blood_group ?? "" }}" placeholder="{{ translate('Blood Group') }}" class="form-control" required>-->
        <!--        @error('blood_group')-->
        <!--            <small class="form-text text-danger">{{ $message }}</small>-->
        <!--        @enderror-->
        <!--    </div>-->
        <!--</div>-->
        
        <div class="form-group row">
              <div class="col-md-6">
                  <label for="complexion">{{translate('Complexion')}}</label>
                    @php $complexion_data = $member->physical_attributes->complexion ?? ""; @endphp
                    <select class="form-control aiz-selectpicker" name="complexion" >
                        <option value="">{{translate('Select One')}}</option>
                        <option value="1" @if($complexion_data ==  1) selected @endif >{{translate('Very Fair')}}</option>
                        <option value="2" @if($complexion_data ==  2) selected @endif >{{translate('Fair')}}</option>
                        <option value="3" @if($complexion_data ==  3) selected @endif >{{translate('Medium')}}</option>
                        <option value="4" @if($complexion_data ==  4) selected @endif >{{translate('Wheetish')}}</option>
                        <option value="5" @if($complexion_data ==  5) selected @endif >{{translate('Dark')}}</option>
                        <option value="6" @if($complexion_data ==  6) selected @endif >{{translate('Black')}}</option>
                        @error('complexion')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
              </div>
              <div class="col-md-6">
                  <label for="blood_group">{{translate('Blood Group')}}</label>
                    @php $blood_group_data = $member->physical_attributes->blood_group ?? ""; @endphp
                    <select class="form-control aiz-selectpicker" name="blood_group" >
                        <option value="">{{translate('Select One')}}</option>
                        <option value="1" @if($blood_group_data ==  1) selected @endif >{{translate('A+')}}</option>
                        <option value="2" @if($blood_group_data ==  2) selected @endif >{{translate('O+')}}</option>
                        <option value="3" @if($blood_group_data ==  3) selected @endif >{{translate('B+')}}</option>
                        <option value="4" @if($blood_group_data ==  4) selected @endif >{{translate('AB+')}}</option>
                        <option value="5" @if($blood_group_data ==  5) selected @endif >{{translate('A-')}}</option>
                        <option value="6" @if($blood_group_data ==  6) selected @endif >{{translate('O-')}}</option>
                        <option value="7" @if($blood_group_data ==  7) selected @endif >{{translate('B-')}}</option>
                        <option value="8" @if($blood_group_data ==  8) selected @endif >{{translate('AB-')}}</option>
                        @error('blood_group')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
              </div>
          </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="body_type">{{translate('Body Type')}}</label>
                <input type="text" name="body_type" value="{{ $member->physical_attributes->body_type ?? "" }}" class="form-control" placeholder="{{translate('Body Type')}}" required>
                @error('body_type')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="body_art">{{translate('Body Art')}}</label>
                <input type="text" name="body_art" value="{{ $member->physical_attributes->body_art ?? "" }}" placeholder="{{ translate('Body Art') }}" class="form-control" required>
                @error('body_art')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
                <div class="col-md-6">
                    <label for="diet">{{translate('Diet')}}</label>
                    @php $user_diet = !empty($member->lifestyles->diet) ? $member->lifestyles->diet : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="diet"  >
                        <option value="">{{translate('Choose one')}}</option>
                        <option value="1" @if($user_diet == 1) selected @endif >{{translate('Pure Vegetarian')}}</option>
                        <option value="2" @if($user_diet == 2) selected @endif >{{translate('Non Vegetarian')}}</option>
                        <option value="3" @if($user_diet == 3) selected @endif >{{translate('Eggetarian')}}</option>
                        <option value="4" @if($user_diet == 4) selected @endif >{{translate('Doesn\'t matter')}}</option>
                        @error('diet')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="drink">{{translate('Drink')}}</label>
                    @php $user_drink = !empty($member->lifestyles->drink) ? $member->lifestyles->drink : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="drink"  >
                        <option value="">{{translate('Choose one')}}</option>
                        <option value="1" @if($user_drink == 1) selected @endif >{{translate('Yes')}}</option>
                        <option value="2" @if($user_drink == 2) selected @endif >{{translate('No')}}</option>
                        <option value="3" @if($user_drink == 3) selected @endif >{{translate('Doesn\'t matter')}}</option>
                        @error('drink')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="smoke">{{translate('Smoke')}}</label>
                    @php $user_smoke = !empty($member->lifestyles->smoke) ? $member->lifestyles->smoke : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="smoke"  >
                        <option value="">{{translate('Choose one')}}</option>
                        <option value="1" @if($user_smoke == 1) selected @endif >{{translate('Yes')}}</option>
                        <option value="2" @if($user_smoke == 2) selected @endif >{{translate('No')}}</option>
                        <option value="3" @if($user_smoke == 3) selected @endif >{{translate('Doesn\'t matter')}}</option>
                        @error('smoke')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="living_with">{{translate('Living With')}}</label>
                    @php $living_with = !empty($member->lifestyles->living_with) ? $member->lifestyles->living_with : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="living_with"  >
                        <option value="">{{translate('Choose one')}}</option>
                        <option value="1" @if($living_with == 1) selected @endif >{{translate('Family')}}</option>
                        <option value="2" @if($living_with == 2) selected @endif >{{translate('Alone')}}</option>
                        <option value="3" @if($living_with == 3) selected @endif >{{translate('Friend')}}</option>
                        <option value="4" @if($living_with == 4) selected @endif >{{translate('Relationship')}}</option>
                        <option value="5" @if($living_with == 5) selected @endif >{{translate('Relative')}}</option>
                        @error('living_with')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="diet">{{translate('Mother Tongue')}}</label>
                    @php $mothere_tongue = $member->physical_attributes->mothere_tongue ?? ""; @endphp
                    <select class="form-control aiz-selectpicker" name="mothere_tongue" data-selected="{{ $mothere_tongue }}" data-live-search="true">
                        <option value="">{{translate('Select One')}}</option>
                        @foreach ($languages as $language)
                            <option value="{{$language->id}}"> {{ $language->name }} </option>
                        @endforeach
                    </select>
                    @error('mothere_tongue')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="disability">{{translate('Disability')}}</label>
                    @php $physical_attributes = $member->physical_attributes->disability ?? ""; @endphp
                    <select class="form-control aiz-selectpicker" name="disability" id="disability" >
                        <option value="">{{translate('Select')}}</option>
                        <option value="yes" @if($physical_attributes =='yes') selected @endif >{{ translate('Yes') }} </option>
                        <option value="no" @if($physical_attributes =='no') selected @endif >{{ translate('No') }} </option>
                    </select>
                    @error('disability')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
        </div>
    </form>
</div>
