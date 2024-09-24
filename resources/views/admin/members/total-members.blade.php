
@extends('admin.layouts.app')
@section('content')
@php
use App\Models\Address;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
@endphp
<style>
    .aiz-table thead th {
      white-space: nowrap;
    }
</style>
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Total Members')}}</h1>
        </div>
        @can('create_member')
            <div class="col-md-6 text-right">
                <a href="{{route('members.create')}}" class="btn btn-circle btn-primary">{{translate('Add New Member')}}</a>
            </div>
        @endcan
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header row gutters-5">
  				<div class="col text-center text-md-left">
  					<h5 class="mb-md-0 h6">{{ translate('All members') }}</h5>
  				</div>
  				<div class="col-md-3">
  					<form class="" id="sort_members" action="" method="GET">
  						<div class="input-group input-group-sm">
  					  		<input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type first name / last name / ID & Enter') }}">
  						</div>
  					</form>
  				</div>
		    </div>
            <div class="card-body">
                <table class="table aiz-table mb-0 table-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Image')}}</th>
                            <th>{{translate('Member Code')}}</th>
                            <th data-breakpoints="md">{{translate('Name')}}</th>
                            <th data-breakpoints="md">{{translate('Contact No.')}}</th>
                            <!--<th data-breakpoints="md">-{{translate('Email')}}<br>-{{translate('City')}}</th>-->
                            <th data-breakpoints="md">-{{translate('Email')}}<br>-{{ translate('address_id') }}</th>
                            <th data-breakpoints="md">{{translate('On Behalf')}}</th>
                            <th data-breakpoints="md">-{{translate('Gender')}}<br>-{{translate('Height')}}</th>
                            <th data-breakpoints="md">-{{translate('DOB')}}<br>-{{translate('Age')}}</th>
                            <th data-breakpoints="md">-{{translate('Education')}}<br>-{{translate('Profession')}}</th>
                            @if(get_setting('member_verification') == 1)
                                <th data-breakpoints="md">{{translate('Verification Status')}}</th>
                            @endif
                            <!--<th data-breakpoints="md">{{translate('Profile Reported')}}</th>-->
                            <th data-breakpoints="md">{{translate('M_Since')}}</th>
                            <th data-breakpoints="md">{{translate('M_ship')}}</th>
                            <th data-breakpoints="md">{{translate('M_Status')}}</th>
                            <th data-breakpoints="md">Marital Status</th>
                            <th class="text-right">{{translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $key => $member)
                            @php
                                $state_name = '';
                                $city_name = '';
                                $address =  Address::select('city_id','state_id','country_id')->where('user_id', $member->id)->get();
                            @endphp
                           
                            <tr>
                                <td>{{ ($key+1) + ($members->currentPage() - 1)*$members->perPage() }} </td>
                                <td>
                                    @if(uploaded_asset($member->photo) != null)
                                        <img class="img-md" src="{{ uploaded_asset($member->photo) }}" height="45px"  alt="{{translate('photo')}}">
                                    @elseif(!empty($member->photo))
                                        <img class="img-md" src="{{ static_asset('').'/'.$member->photo }}" height="45px"  alt="{{translate('photo')}}">
                                    @else
                                        <img class="img-md" src="{{ static_asset('assets/img/avatar-place.png') }}" height="45px"  alt="{{translate('photo')}}">
                                    @endif
                                </td>
                                <td>{{ $member->code.' - '. $member->member_id }}</td>
                                <td>{{ $member->first_name.' '.$member->last_name }}</td>
                               
                                <td>
                                    {{ str_replace('+91','',$member->phone) }}
                                    {{ str_replace('+91','',$member->whatsapp_number) }}
                                    {{ str_replace('+91','',$member->other_number) }}
                                
                                </td>
                                <td>
                                    -{{ $member->email }} <br>-
                                    <?php
                                        foreach($address as $addrs){
                                            $state_name = State::select('name')->where('id',$addrs->state_id)->first();
                                            $city_name = City::select('name')->where('id',$addrs->city_id)->first();
                                            echo $city_name->name.', '.$state_name->name.'<br>';
                                    } ?>
                                
                                </td>
                                <td>{{ $member->on_behalves_name }} </td>
                                <td>
                                    -@if ($member->member != null && $member->member->gender == 1)
                                        {{ translate('Male') }}
                                    @elseif ($member->member != null && $member->member->gender == 2)
                                        {{ translate('Female') }}
                                    @else
                                        {{ ' ' }}
                                    @endif
                                   <br>-{{ $member->member_height }}
                                </td>
                                 <td>-{{ date('F d, Y', strtotime($member->birthday)) }}<br>- {{ \Carbon\Carbon::parse($member->birthday)->age }}</td>
                                 <td>-{{ $member->h_education }}<br>-{{ $member->member_profession }}</td>
                                @if(get_setting('member_verification') == 1)
                                    <td>
                                        @if($member->approved == 1)
                                            <span class="badge badge-inline badge-success">{{translate('Approved')}}</span>
                                        @elseif($member->verification_info != null)
                                            <span class="badge badge-inline badge-info">{{translate('Pending')}}</span>
                                        @else
                                            <span class="badge badge-inline badge-warning">{{translate('No Request')}}</span>
                                        @endif
                                    </td>
                                @endif
                                <!--<td>-->
                                <!--  @if($member->reported_users->count() > 0)-->
                                <!--    <a href="@can('view_reported_profile'){{ route('reported_members', $member->id) }}@endcan" class="badge badge-inline badge-danger" title="{{ translate('View Reports') }}">{{ $member->reported_users->count() }}</a>-->
                                <!--  @else-->
                                <!--    0-->
                                <!--  @endif-->
                                <!--</td>-->
                                <td>{{ date('d-m-Y', strtotime($member->created_at)) }}</td>
                                 <td>
                                    @if($member->membership == 1)
                                        <span class="badge badge-inline badge-info">Free</span>
                                    @elseif($member->membership == 2)
                                        <span class="badge badge-inline badge-success">Premium</span>
                                    @elseif($member->membership == 3)
                                        <span class="badge badge-inline badge-info">Verified</span>
                                    @elseif($member->membership == 4)
                                        <span class="badge badge-inline badge-primary">VIP</span>
                                    @endif
                                </td>
                                <td>
                                    @if($member->deactivated == 0)
                                        <span class="badge badge-inline badge-success">{{translate('Active')}}</span>
                                    @else
                                        <span class="badge badge-inline badge-danger">{{translate('Deactivated')}}</span>
                                    @endif
                                </td>
                                <td>{{ $member->marital_status }}</td>
                                <td class="text-right">
                                    <div class="btn-group mb-2">
                                        <div class="btn-group">
                                            <button type="button" class="btn py-0" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="las la-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @can ('view_member_profile')
                                                    <a class="dropdown-item" href="{{ route('members.show', encrypt($member->id)) }}">{{translate('View')}}</a>
                                                @endcan
                                                @can('edit_member')
                                                    <a class="dropdown-item" href="{{ route('members.edit', encrypt($member->id)) }}">{{translate('Edit')}}</a>
                                                @endcan
                                                @can ('block_member')
                                                    @if($member->blocked == 0)
                                                        <a class="dropdown-item" onclick="block_member({{$member->id}})" href="javascript:void(0);">{{translate('Block')}}</a>
                                                    @elseif($member->blocked == 1)
                                                        <a class="dropdown-item" onclick="unblock_member({{$member->id}})" href="javascript:void(0);" >{{translate('Unblock')}}</a>
                                                    @endif
                                                @endcan
                                                @can ('approve_member')
                                                    @if(get_setting('member_verification') == 1 && $member->verification_info != null)
                                                        <a class="dropdown-item" href="{{ route('member.show_verification_info', encrypt($member->id)) }}" >{{translate('View Verification Info')}}</a>
                                                    @endif
                                                @endcan

                                                @can ('update_member_package')
                                                    <a class="dropdown-item" onclick="package_info({{$member->id}})" href="javascript:void(0);" >{{translate('Package')}}</a>
                                                @endcan
                                                    <a class="dropdown-item" onclick="wallet_balance_update({{$member->id}},{{$member->balance}})" href="javascript:void(0);" >{{translate('Wallet Balance')}}</a>
                                                @can ('login_as_member')
                                                    <a href="{{ route('members.login', encrypt($member->id)) }}" class="dropdown-item">{{translate('Log in as this Member')}}</a>
                                                @endcan
                                                @can ('delete_member')
                                                    <a class="dropdown-item confirm-delete" data-href="{{route('members.destroy', $member->id)}}">{{translate('Delete')}}</a>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $members->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')
    {{-- Member Approval Modal --}}
    {{-- <div class="modal fade member-approval-modal" id="modal-basic">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{translate('Member Approval !')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body text-center">
                    <form class="form-horizontal member-block" action="{{ route('members.approve') }}" method="POST">
                        @csrf
                        <input type="hidden" name="member_id" id="member_id" value="">
                        <p class="mt-1">{{translate('Are you sure to approve this member?')}}</p>
                        <button type="button" class="btn btn-light mt-2" data-dismiss="modal">{{translate('Cancel')}}</button>
                        <button type="submit" class="btn btn-primary mt-2">{{translate('Approve')}}</a>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- Member Block Modal--}}
    <div class="modal fade member-block-modal" id="modal-basic">
    	<div class="modal-dialog">
    		<div class="modal-content">
                <form class="form-horizontal member-block" action="{{ route('members.block') }}" method="POST">
                    @csrf
                    <input type="hidden" name="member_id" id="block_member_id" value="">
                    <input type="hidden" name="block_status" id="block_status" value="">
                    <div class="modal-header">
                        <h5 class="modal-title h6">{{translate('Member Block !')}}</h5>
                        <button type="button" class="close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{translate('Blocking Reason')}}</label>
                            <div class="col-md-9">
                                <textarea type="text" name="blocking_reason" class="form-control" placeholder="{{translate('Blocking Reason')}}" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{translate('Submit')}}</button>
                    </div>
                </form>
        	</div>
    	</div>
    </div>

    <!-- Member Unblock Modal -->
    <div class="modal fade member-unblock-modal" id="modal-basic">
    	<div class="modal-dialog">
    		<div class="modal-content">
            <form class="form-horizontal member-block" action="{{ route('members.block') }}" method="POST">
                @csrf
                <input type="hidden" name="member_id" id="unblock_member_id" value="">
                <input type="hidden" name="block_status" id="unblock_block_status" value="">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Member Unblock !')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>
                        <b>{{translate('Blocked Reason')}} : </b>
                        <span id="block_reason"></span>
                    </p>
                    <p class="mt-1">{{translate('Are you want to unblock this member?')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{translate('Unblock')}}</button>
                </div>
            </form>
      	</div>
    	</div>
    </div>

    <div class="modal fade member_wallet_balance_modal" id="modal-basic">
    	<div class="modal-dialog">
    		<div class="modal-content">
            <form class="form-horizontal member-block" action="{{ route('member.wallet_balance_update') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" id="user_id_wallet_balance" value="">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{translate('Wallet Balance Update')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                  <div class="row">
                      <div class="col-md-4">
                          <label>{{ translate('Current Banalce')}}</label>
                      </div>
                      <div class="col-md-8">
                          <input type="number" class="form-control mb-3" id="member_wallet_balance" value="" readonly>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <label>{{ translate('Update Type')}} <span class="text-danger">*</span></label>
                      </div>
                      <div class="col-md-8">
                          <div class="mb-3">
                              <select class="form-control selectpicker" data-minimum-results-for-search="Infinity" name="payment_option" data-live-search="true">
                                <option value="added_by_admin">{{ translate('Add')}}</option>
                                <option value="deducted_by_admin">{{ translate('Deduct')}}</option>
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <label>{{ translate('Amount')}} <span class="text-danger">*</span></label>
                      </div>
                      <div class="col-md-8">
                          <input type="number" lang="en" class="form-control mb-3" name="wallet_amount" placeholder="{{ translate('Amount')}}" required>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{translate('Submit')}}</button>
                </div>
            </form>
      	</div>
    	</div>
    </div>

    @include('modals.create_edit_modal')
    @include('modals.delete_modal')
@endsection

@section('script')
<script type="text/javascript">
    function sort_members(el){
        $('#sort_members').submit();
    }

    function package_info(id){
        $.post('{{ route('members.package_info') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
            $('.create_edit_modal_content').html(data);
            $('.create_edit_modal').modal('show');
        });
    }

    function get_package(id){
        $.post('{{ route('members.get_package') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
            $('.create_edit_modal_content').html(data);
            $('.create_edit_modal').modal('show');
        });
    }


    function approve_member(id){
        $('.member-approval-modal').modal('show');
        $('#member_id').val(id);
    }

    function block_member(id){
        $('.member-block-modal').modal('show');
        $('#block_member_id').val(id);
        $('#block_status').val(1);
    }

    function unblock_member(id){
        $('#unblock_member_id').val(id);
        $('#unblock_block_status').val(0);
        $.post('{{ route('members.blocking_reason') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
            $('.member-unblock-modal').modal('show');
            $('#block_reason').html(data);
        });
    }

    function wallet_balance_update(id, balance){
        $('.member_wallet_balance_modal').modal('show');
        $('#user_id_wallet_balance').val(id);
        $('#member_wallet_balance').val(balance);
    }

</script>
@endsection
