<style>
    .file-preview img {
        max-width: 60px;
        height: 80px;
        display: block;
        margin-top: 10px;
    }
</style>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Basic Information')}}</h5>
    </div>
    <div class="card-body">

        <form action="{{ route('member.basic_info_update', $member->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="first_name" >{{translate("Bride's/Groom's Name")}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="first_name" value="{{ $member->first_name }}" class="form-control" placeholder="{{translate('Bride\'s/Groom\'s Name')}}" required>
                    @error('first_name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="first_name" >{{translate('Surname')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="last_name" value="{{ $member->last_name }}" class="form-control" placeholder="{{translate('Surname')}}" required>
                    @error('last_name')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="first_name" >{{translate('Gender')}}
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control aiz-selectpicker" name="gender" required>
                        <option value="1" @if($member->member->gender ==  1) selected @endif >{{translate('Male')}}</option>
                        <option value="2" @if($member->member->gender ==  2) selected @endif >{{translate('Female')}}</option>
                        @error('gender')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="first_name" >{{translate('Date Of Birth')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="aiz-date-range form-control" name="date_of_birth"  value="@if(!empty($member->member->birthday)) {{date('Y-m-d', strtotime($member->member->birthday))}} @endif" placeholder="Select Date" data-single="true" data-show-dropdown="true" data-max-date="{{ get_max_date() }}" autocomplete="off" required>
                    @error('date_of_birth')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="first_name" >{{translate('Contact Number')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="phone" value="{{ $member->phone }}" class="form-control" placeholder="{{translate('Contact Number')}}" required>
                    @error('phone')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="first_name" >{{translate('WhatsApp Number')}}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="whatsapp_number" value="{{ $member->whatsapp_number }}" class="form-control" placeholder="{{translate('WhatsApp Number')}}">
                    @error('whatsapp_number')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="other_number" >{{translate('Alt. Mobile No.')}}</label>
                    <input type="text" name="other_number" value="{{ $member->other_number }}" class="form-control" placeholder="{{translate('Alt. Mobile No.')}}" >
                    @error('other_number')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="first_name" >{{translate('On Behalf')}}
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control aiz-selectpicker" name="on_behalf" data-live-search="true" required>
                        @foreach ($on_behalves as $on_behalf)
                            <option value="{{$on_behalf->id}}" @if($member->member->on_behalves_id == $on_behalf->id) selected @endif>{{$on_behalf->name}}</option>
                        @endforeach
                    </select>
                    @error('on_behalf')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="first_name" >{{translate('Marital  Status')}}
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control aiz-selectpicker" id="marital_status" name="marital_status" data-selected="{{ $member->member->marital_status_id }}" data-live-search="true" required>
                        @foreach ($marital_statuses as $marital_status)
                            <option value="{{$marital_status->id}}">{{$marital_status->name}}</option>
                        @endforeach
                    </select>
                    @error('marital_status')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6" id="number_of_children">
                    <label for="first_name" >{{translate('Number Of Children')}}</label>
                    <input type="text" name="children" value="{{ $member->member->children }}" class="form-control" placeholder="{{translate('Number Of Children')}}" >
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="special_case" >{{translate('Special Case')}}</label>
                    <input type="text" name="special_case" value="{{ $member->member->special_case }}" class="form-control" placeholder="{{translate('Special Case')}}" >
                </div>
                <div class="col-md-6">
                    <label for="smoke">{{translate('Mangalik Status')}}</label>
                    @php $manglik_status = !empty($member->member->manglik_status) ? $member->member->manglik_status : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="manglik_status" >
                        <option value="">{{translate('Select One')}}</option>
                        <option value="1" @if($manglik_status ==  '1') selected @endif >{{translate('Non Mangalik')}}</option>
                        <option value="2" @if($manglik_status ==  '2') selected @endif >{{translate('Mangalik')}}</option>
                        <option value="3" @if($manglik_status ==  '3') selected @endif >{{translate('Anshik (Partial) Mangalik')}}</option>
                        <option value="4" @if($manglik_status ==  '4') selected @endif >{{translate('Doesn\'t matter')}}</option>
                        @error('manglik_status')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="photo" >{{translate('Photo')}} <small>(800x800)</small>
                        @if(auth()->user()->photo != null && auth()->user()->photo_approved == 0)
                        <small class="text-danger">({{ translate('Pending for Admin Approval.') }})</small>
                        @elseif(auth()->user()->photo != null && auth()->user()->photo_approved == 1)
                            <small class="text-danger">({{ translate('Approved.') }})</small>
                        @endif</label>
                    <!-- <div class="input-group" data-toggle="aizuploader" data-type="image">
                        <div class="input-group-prepend">
                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                        </div>
                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                        <input type="hidden" name="photo" class="selected-files" value="{{ $member->photo }}">
                    </div> -->
                    <div class="custom-file">
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        <input type="file" name="photo" class="custom-file-input" id="validatedCustomFile">
                        <input type="hidden" name="old_photo" value="{{ $member->photo }}">
                    </div>
                    <div class="file-preview box sm">
                    </div> 
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
            </div>
        </form>
    </div>
</div>
<script>
        // Function to preview the selected file
        document.getElementById('validatedCustomFile').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Get the selected file

            if (file) {
                const reader = new FileReader(); // Create a new FileReader object

                reader.onload = function(e) {
                    const preview = document.querySelector('.file-preview'); // Select the preview container
                    preview.innerHTML = ''; // Clear any previous previews

                    const img = document.createElement('img'); // Create an img element
                    img.src = e.target.result; // Set the src of the img element to the file's data URL

                    preview.appendChild(img); // Append the img element to the preview container
                };

                reader.readAsDataURL(file); // Read the file as a data URL
            }
        });
    </script>
