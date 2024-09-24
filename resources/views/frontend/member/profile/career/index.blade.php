<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Career')}}</h5>
    </div>
    <div class="card-body">
        @php $member_data = \App\Models\Member::where('user_id',$member->id)->first(); @endphp
        <form action="{{ route('member.emplyeed_profession.update', $member->id) }}" method="POST">
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="employed_in" >{{translate('Employed In')}}</label>
                     <select class="form-control" name="employed_in" id="employed_in" required onchange="getProfession(this.value)">
                      <option value="" selected disabled>Select</option>
                      @foreach($employed_in as $row)
                        <option value="{{ $row->id }}" <?php if($row->id == $member_data->employed_in){ echo 'selected';} ?>>{{ $row->title }}</option>
                      @endforeach
                    </select>
                    <!--<input type="text" name="employed_in" value="{{ $member_data ? $member_data->employed_in : '' }}" class="form-control" placeholder="{{translate('Employed In')}}" required>-->
                    @error('employed_in')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="profession" >{{translate('Profession')}}</label>
                     <select class="form-control" name="profession" id="profession" required>
                      <option value="" selected disabled>Select</option>
                      @foreach($profession as $row)
                        <option value="{{ $row->id }}" <?php if($row->id == $member_data->profession){ echo 'selected';} ?>>{{ $row->title }}</option>
                      @endforeach
                    </select>
                    <!--<input type="text" name="profession" value="{{ $member_data ? $member_data->profession : '' }}" class="form-control" placeholder="{{translate('Profession')}}" >-->
                    @error('profession')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
            </div>
        </form>
        <table class="table aiz-table mt-3">
          <tr>
              <th>{{translate('designation')}}</th>
              <th>{{translate('company')}}</th>
              <th data-breakpoints="md">{{translate('Job Location')}}</th>
              <th data-breakpoints="md">{{translate('Income')}}</th>
              <th data-breakpoints="md">{{translate('Status')}}</th>
              <th data-breakpoints="md" class="text-right">{{translate('Options')}}</th>
          </tr>

          @php $careers = \App\Models\Career::where('user_id',$member->id)->get(); @endphp
          @foreach ($careers as $key => $career)
          <tr>
              <td>{{ $career->designation }}</td>
              <td>{{ $career->company }}</td>
              <td>{{ $career->job_location }}</td>
              <td>{{ $career->income }}</td>
              <td>
                  <label class="aiz-switch aiz-switch-success mb-0">
                      <input type="checkbox" id="status.{{ $key }}" onchange="update_career_present_status(this)" value="{{ $career->id }}" @if($career->present == 1) checked @endif data-switch="success"/>
                      <span></span>
                  </label>
              </td>
              <td class="text-right">
                  <a href="javascript:void(0);" class="btn btn-soft-info btn-icon btn-circle btn-sm" onclick="career_edit_modal('{{$career->id}}');" title="{{ translate('Edit') }}">
                      <i class="las la-edit"></i>
                  </a>
                  <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('career.destroy', $career->id)}}" title="{{ translate('Delete') }}">
                      <i class="las la-trash"></i>
                  </a>
              </td>
          </tr>
          @endforeach

        </table>
        <div class="text-right">
            <a onclick="career_add_modal('{{$member->id}}');"  href="javascript:void(0);" class="btn btn-sm btn-primary ">
              <i class="las mr-1 la-plus"></i>
              {{translate('Add New')}}
            </a>
        </div>
    </div>
</div>
