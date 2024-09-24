@extends('frontend.layouts.member_panel')
@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('My Interests') }}</h5>
            <a href="{{ route('interest_requests') }}"
                class="mb-0 h6 btn btn-primary">{{ translate('Interest Requests') }}</a>
        </div>
        <div class="card-body">
            <div class="mb-5">
                @foreach ($interests as $key => $user)
                    <div class="row no-gutters border border-gray-300 rounded hov-shadow-md mb-4 has-transition position-relative" id="block_id_{{ $user->id }}">
                        <div class="col-md-auto">
                            <div class="text-center text-md-left pt-3 pt-md-0">
                                @php
                                    $avatar_image =
                                        $user->member->gender == 1
                                            ? 'assets/img/avatar-place.png'
                                            : 'assets/img/female-avatar-place.png';
                                    $profile_picture_show = show_profile_picture($user);
                                @endphp
                                <img @if ($profile_picture_show) src="{{ uploaded_asset($user->photo) }}"
                                @else
                                src="{{ static_asset($avatar_image) }}" @endif
                                    onerror="this.onerror=null;this.src='{{ static_asset($avatar_image) }}';"
                                    class="img-fit mw-100 size-150px size-md-250px rounded-circle md-rounded-0">
                            </div>
                        </div>
                        <div class="col-md position-static d-flex align-items-center">
                            <span class="absolute-top-right px-4 py-3">
                                @if ($user->membership == 1)
                                    <span
                                        class="badge badge-inline badge-info">{{ translate('Lite') }}</span>
                                @elseif($user->membership == 2)
                                    <span
                                        class="badge badge-inline badge-success">{{ translate('Pro') }}</span>
                                @endif
                            </span>
                            <div class="px-md-4 p-3 flex-grow-1">

                                <h2 class="h6 fw-600 fs-18 text-truncate mb-1">
                                    {{ $user->first_name . ' ' . $user->last_name }}</h2>
                                <div class="mb-2 fs-12">
                                    <span class="opacity-60">{{ translate('Member ID: ') }}</span>
                                    <span class="ml-4 text-primary">{{ $user->code }}</span>
                                </div>
                                <table class="w-100 opacity-70 mb-2 fs-12">
                                    <tr>
                                        @php
                                            if (!empty($user->member->employed_in)){
                                                $employed_in_data = \App\Models\EmployedInModel::where('id', $user->member->employed_in)->first();
                                            }
                                        @endphp
                                        
                                        @if (!empty($employed_in_data))
                                            {{ $employed_in_data->title }} - 
                                        @endif
                                        
                                        @php
                                            if (!empty($user->member->profession)){
                                                $profession_data = \App\Models\ProfessionModel::where('id', $user->member->profession)->first();
                                            }
                                        @endphp
                                        
                                        @if (!empty($profession_data))
                                            {{ $profession_data->title }}
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="py-1 w-25">
                                            <span>{{ translate('Age') }}</span>
                                        </td>
                                        <td class="py-1 w-25 fw-400">
                                            {{ \Carbon\Carbon::parse($user->member->birthday)->age }}</td>
                                        <td class="py-1 w-25"><span>{{ translate('Height') }}</span></td>
                                        <td class="py-1 w-25 fw-400">
                                            @if (!empty($user->physical_attributes->height))
                                                {{ $user->physical_attributes->height }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-1"><span>{{ translate('Religion') }}</span></td>
                                        <td class="py-1 fw-400">
                                            @if (!empty($user->spiritual_backgrounds->religion_id))
                                                {{ $user->spiritual_backgrounds->religion->name }}
                                            @endif
                                        </td>
                                        <td class="py-1"><span>{{ translate('Caste') }}</span></td>
                                        <td class="py-1 fw-400">
                                            @if (!empty($user->spiritual_backgrounds->caste_id))
                                                {{ $user->spiritual_backgrounds->caste->name }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-1 w-25"><span>{{ translate('Education') }}</span></td>
                                        @php 
                                            if(!empty($user->member->heighest_education)){
                                                $education = \App\Models\HighestEducation::where('id', $user->member->heighest_education)->first();
                                            }
                                        @endphp
                                         
                                        <td class="py-1 w-25 fw-400">
                                            @if(!empty($education))
                                                {{ $education->title }}
                                            @endif
                                        </td>
                                        
                                        @php
                                            $career = \App\Models\Career::where('user_id', $user->id)->first();
                                        @endphp
                                        
                                        <td class="py-1 w-25"><span>{{ translate('Income') }}</span></td>
                                        
                                        <td class="py-1 w-25 fw-400">
                                            @if(!empty($career))
                                                {{ $career->income }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-1"><span>{{ translate('Mother tongue') }}</span>
                                        </td>
                                        <td class="py-1 fw-400">
                                            @if ($user->member->mothere_tongue != null)
                                                {{ \App\Models\MemberLanguage::where('id', $user->member->mothere_tongue)->first()->name }}
                                            @endif
                                        </td>
                                        <td class="py-1"><span>{{ translate('Marital Status') }}</span>
                                        </td>
                                        <td class="py-1 fw-400">
                                            @if ($user->member->marital_status_id != null)
                                                {{ $user->member->marital_status->name }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-1">
                                            <span>{{ translate('Location') }}</span>
                                        </td>
                                        <td class="py-1 fw-400">           
                                            @php
                                                $present_address = \App\Models\Address::where(
                                                    'type',
                                                    'present',
                                                )
                                                    ->where('user_id', $user->id)
                                                    ->first();
                                            @endphp
                                            
                                            @if (!empty($present_address->city_id))
                                                {{ $present_address->city->name }} ,
                                            @endif
                                            
                                            @if (!empty($present_address->state_id))
                                                {{ $present_address->state->name }}, 
                                            @endif
                                            
                                            @if (!empty($present_address->country_id))
                                                {{ $present_address->country->name }}
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                <div class="row gutters-5 text-center">
                                    <div class="col">
                                        <a @if (get_setting('full_profile_show_according_to_membership') == 1 && Auth::user()->membership == 1) href="javascript:void(0);" onclick="package_update_alert()"
                                    @else
                                        href="{{ route('member_profile', $user->id) }}" @endif
                                            class="text-reset c-pointer">
                                            <i class="las la-user fs-20 text-primary"></i>
                                            <span
                                                class="d-block fs-10 opacity-60">{{ translate('Full Profile') }}</span>
                                        </a>
                                    </div>
                                    
                                    <div class="col">
                                        @php
                                            $shortlist = \App\Models\Shortlist::where(
                                                'user_id',
                                                $user->id,
                                            )
                                                ->where('shortlisted_by', Auth::user()->id)
                                                ->first();
                                            if (empty($shortlist)) {
                                                $shortlist_onclick = 1;
                                                $shortlist_text = translate('Shortlist');
                                                $shortlist_class = 'text-dark';
                                            } else {
                                                $shortlist_onclick = 0;
                                                $shortlist_text = translate('Shortlisted');
                                                $shortlist_class = 'text-primary';
                                            }
                                        @endphp
                                        <a id="shortlist_a_id_{{ $user->id }}"
                                            @if ($shortlist_onclick == 1) onclick="do_shortlist({{ $user->id }})"
                                    @else
                                        onclick="remove_shortlist({{ $user->id }})" @endif
                                            class="text-reset c-pointer">
                                            <i class="las la-list fs-20 text-primary"></i>
                                            <span id="shortlist_id_{{ $user->id }}"
                                                class="d-block fs-10 opacity-60 {{ $shortlist_class }}">
                                                {{ $shortlist_text }}
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a onclick="ignore_member({{ $user->id }})"
                                            class="text-reset c-pointer">
                                            <span class="text-dark">
                                                <i class="las la-ban fs-20 text-primary"></i>
                                                <span
                                                    class="d-block fs-10 opacity-60">{{ translate('Ignore') }}</span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        @php
                                            $profile_reported = \App\Models\ReportedUser::where(
                                                'user_id',
                                                $user->id,
                                            )
                                                ->where('reported_by', Auth::user()->id)
                                                ->first();
                                            if (empty($profile_reported)) {
                                                $report_onclick = 1;
                                                $report_text = translate('Report');
                                                $report_class = 'text-dark';
                                            } else {
                                                $report_onclick = 0;
                                                $report_text = translate('Reported');
                                                $report_class = 'text-primary';
                                            }
                                        @endphp
                                        <a id="report_a_id_{{ $user->id }}"
                                            @if ($report_onclick == 1) onclick="report_member({{ $user->id }})" @endif
                                            class="text-reset c-pointer">
                                            <span id="report_id_{{ $user->id }}"
                                                class="{{ $report_class }}">
                                                <i class="las la-info-circle fs-20 text-primary"></i>
                                                <span
                                                    class="d-block fs-10 opacity-60">{{ $report_text }}</span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="javascript:void(0);" onclick="reject_interest({{ $user->interest_id }})" class="text-reset c-pointer">
                                            <i class="las la-trash fs-20 text-primary"></i>
                                            <span
                                                class="d-block fs-10 opacity-60">{{ translate('Delete') }}</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        @if ($user->interest_status == 1)
                                            <span class="badge badge-inline badge-success">{{ translate('Approved') }}</span>
                                        @else
                                            <span class="badge badge-inline badge-info">{{ translate('Pending') }}</span>
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="aiz-pagination">
                {{ $interests->links() }}
            </div>
        </div>
    </div>
@endsection

  {{-- Interest Reject Modal --}}
  <div class="modal fade interest_reject_modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{translate('Interest Reject !')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <form class="form-horizontal member-block" action="{{ route('reject_interest') }}" method="POST">
                    @csrf
                    <input type="hidden" name="interest_id" id="interest_reject_id" value="">
                    <p class="mt-1">{{translate('Are you sure you want to rejet his interest?')}}</p>
                    <button type="button" class="btn btn-danger mt-2" data-dismiss="modal">{{translate('Cancel')}}</button>
                    <button type="submit" class="btn btn-info mt-2 action-btn">{{translate('Confirm')}}</a>
                </form>
            </div>
        </div>
    </div>
</div>

@section('modal')
    @include('modals.package_update_alert_modal')
    @include('modals.confirm_modal')

    <!-- Ignore Modal -->
    <div class="modal fade ignore_member_modal" id="modal-zoom">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Ignore Member!') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ translate('Are you sure that you want to ignore this member?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ translate('Close') }}</button>
                    <button type="submit" class="btn btn-primary" id="ignore_button">{{ translate('Ignore') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Profile -->
    <div class="modal fade report_modal" id="modal-zoom">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Report Member!') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('reportusers.store') }}" id="report-modal-form" method="POST">
                        @csrf
                        <input type="hidden" name="member_id" id="member_id" value="">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Report Reason') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <textarea name="reason" rows="4" class="form-control" placeholder="{{ translate('Report Reason') }}"
                                    required></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <button type="button" class="btn btn-primary"
                        onclick="submitReport()">{{ translate('Report') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.package_update_alert_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function package_update_alert() {
            $('.package_update_alert_modal').modal('show');
        }

        function reject_interest(id) {
            $('.interest_reject_modal').modal('show');
            $('#interest_reject_id').val(id);
        }
        // Prevent submitting multiple button
        $('form').bind('submit', function(e) {
            if ($(".action-btn").attr('attempted') == 'true') {
                //stop submitting the form and disable the submit button.
                e.preventDefault();
                $(".action-btn").attr("disable", true);
            } else {
                $(".action-btn").attr("attempted", 'true');
            }
        });


        // Full Profile view
        function package_update_alert() {
            $('.package_update_alert_modal').modal('show');
        }

        // Express Interest
        var package_validity = false;
        @if (package_validity(Auth::user()->id))
            package_validity = true;
        @endif

        function express_interest(id) {
            var user_id = {{ Auth::user()->id }}
            $.post('{{ route('user.remaining_package_value') }}', {
                _token: '{{ csrf_token() }}',
                id: user_id,
                colmn_name: 'remaining_interest'
            }, function(data) {

                var remaining_interest = data;
                if (!package_validity || remaining_interest < 1) {
                    $('.package_update_alert_modal').modal('show');
                } else {
                    $('.confirm_modal').modal('show');
                    $("#confirm_modal_title").html("{{ translate('Confirm Express Interest!') }}");
                    $("#confirm_modal_content").html(
                        "<p class='fs-14'>{{ translate('Remaining Express Interest') }}: " +
                        remaining_interest +
                        " {{ translate('Times') }}</p><small class='text-danger fs-12' >{{ translate('**N.B. Expressing An Interest Will Cost 1 From Your Remaining Interests**') }}</small>"
                    );
                    $("#confirm_button").attr("onclick", "do_express_interest(" + id + ")");

                }
            });
        }

        function do_express_interest(id) {
            $('.confirm_modal').modal('hide');
            $("#interest_a_id_" + id).removeAttr("onclick");
            $("#interest_id_" + id).html("{{ translate('Processing') }}..");
            $.post('{{ route('express-interest.store') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                function(data) {
                    // console.log(data);
                    if (data) {
                        $("#interest_id_" + id).html("{{ translate('Interest Expressed') }}");
                        $("#interest_id_" + id).attr("class", "d-block fs-10 opacity-60 text-primary");
                        AIZ.plugins.notify('success', '{{ translate('Interest Expressed Sucessfully') }}');
                    } else {
                        $("#interest_id_" + id).html("{{ translate('Interest') }}");
                        AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    }
                }
            );
        }

        // Shortlist
        function do_shortlist(id) {
            $("#shortlist_a_id_" + id).removeAttr("onclick");
            $("#shortlist_id_" + id).html("{{ translate('Shortlisting') }}..");
            $.post('{{ route('member.add_to_shortlist') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                function(data) {
                    if (data == 1) {
                        $("#shortlist_id_" + id).html("{{ translate('Shortlisted') }}");
                        $("#shortlist_id_" + id).attr("class", "d-block fs-10 opacity-60 text-primary");
                        $("#shortlist_a_id_" + id).attr("onclick", "remove_shortlist(" + id + ")");
                        AIZ.plugins.notify('success', '{{ translate('You Have Shortlisted This Member.') }}');
                    } else {
                        $("#shortlist_id_" + id).html("{{ translate('Shortlist') }}");
                        AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    }
                }
            );
        }

        function remove_shortlist(id) {
            $("#shortlist_a_id_" + id).removeAttr("onclick");
            $("#shortlist_id_" + id).html("{{ translate('Removing') }}..");
            $.post('{{ route('member.remove_from_shortlist') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                function(data) {
                    if (data == 1) {
                        $("#shortlist_id_" + id).html("{{ translate('Shortlist') }}");
                        $("#shortlist_id_" + id).attr("class", "d-block fs-10 opacity-60 text-dark");
                        $("#shortlist_a_id_" + id).attr("onclick", "do_shortlist(" + id + ")");
                        AIZ.plugins.notify('success',
                            '{{ translate('You Have Removed This Member From Your Shortlist.') }}');
                    } else {
                        AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    }
                }
            );
        }

        // Ignore
        function ignore_member(id) {
            $('.ignore_member_modal').modal('show');
            $("#ignore_button").attr("onclick", "do_ignore(" + id + ")");
        }

        function do_ignore(id) {
            // Prevent multiple request sending
            $("#ignore_button").removeAttr("onclick");
            $('.ignore_member_modal').modal('hide');

            $.post('{{ route('member.add_to_ignore_list') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                function(data) {
                    if (data == 1) {
                        $("#block_id_" + id).hide();
                        AIZ.plugins.notify('success', '{{ translate('You Have Ignored This Member.') }}');
                    } else {
                        AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                    }
                }
            );

        }

        function report_member(id) {
            $('.report_modal').modal('show');
            $('#member_id').val(id);
        }

        function submitReport() {
            $('#report-modal-form').submit();
        }
    
    </script>
@endsection
