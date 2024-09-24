<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Family Information')}}</h5>
        <div class="text-right">
            <a onclick="family_information_add_modal('{{$member->id}}');"  href="javascript:void(0);" class="btn btn-sm btn-primary ">
              <i class="las mr-1 la-plus"></i>
              {{translate('Add New')}}
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table aiz-table mt-3">
            <tr>
                <th>{{translate('Family member')}}</th>
                <th>{{translate('Member name')}}</th>
                <th data-breakpoints="md">{{translate('Profession Status')}}</th>
                <th data-breakpoints="md">{{translate('Details')}}</th>
                <th data-breakpoints="md">{{translate('Status')}}</th>
                <th class="text-right">{{translate('Options')}}</th>
            </tr>

            @php $families = \App\Models\Family::where('user_id',$member->id)->get(); @endphp
            @foreach ($families as $key => $family)
            <tr>
                <td>{{ $family->family_member }}</td>
                <td>{{ $family->member_name }}</td>
                <td>{{ $family->profession_status }}</td>
                <td>{{ $family->member_details }}</td>
                <td>
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" id="status.{{ $key }}" onchange="update_family_information_status(this)" value="{{ $family->id }}" @if($family->status == 1) checked @endif data-switch="success"/>
                        <span></span>
                    </label>
                </td>
                <td class="text-right">
                    <a href="javascript:void(0);" class="btn btn-soft-info btn-icon btn-circle btn-sm" onclick="family_information_edit_modal('{{$family->id}}');" title="{{ translate('Edit') }}">
                        <i class="las la-edit"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('family_information.destroy', $family->id)}}" title="{{ translate('Delete') }}">
                        <i class="las la-trash"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
