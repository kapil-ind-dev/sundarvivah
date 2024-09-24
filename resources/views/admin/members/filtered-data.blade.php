
        <div class="d-flex">
            <h1 class="h4 fw-600 mb-3 text-body">{{ translate('All Active Members') }}</h1>
            <div class="d-xl-none ml-auto mb-1 ml-xl-3 mr-0 align-self-end">
                <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle"
                    data-target=".aiz-filter-sidebar">
                    <i class="la la-list la-2x"></i>
                </button>
            </div>
        </div>
        <div class="mb-5">
            @foreach ($users as $key => $user)
                <div class="row no-gutters border border-gray-300 rounded hov-shadow-md mb-4 has-transition position-relative"
                    id="block_id_{{ $user->id }}">
                    <div class="col-md-auto">
                        <div class="text-center text-md-left pt-3 pt-md-0">
                            @php
                                $avatar_image = $user->member->gender == 1 ? 'assets/img/avatar-place.png' : 'assets/img/female-avatar-place.png';
                                $profile_picture_show = show_profile_picture($user);
                            @endphp
                            <!--<img @if ($profile_picture_show) src="{{ uploaded_asset($user->photo) }}"-->
                            <!--@else-->
                            <!--    src="{{ static_asset($avatar_image) }}" -->
                            <!--@endif-->
                            <!--    onerror="this.onerror=null;this.src='{{ static_asset($avatar_image) }}';"-->
                            <!--    class="img-fit mw-100 size-150px size-md-250px rounded-circle md-rounded-0">-->
                                @if(uploaded_asset($user->photo) != null)
                                    <img src="{{ uploaded_asset($user->photo) }}" class="img-fit mw-100 size-150px size-md-250px rounded-circle md-rounded-0"  alt="{{translate('photo')}}">
                                @elseif(!empty($user->photo))
                                    <img src="{{ static_asset('').'/'.$user->photo }}" class="img-fit mw-100 size-150px size-md-250px rounded-circle md-rounded-0"  alt="{{translate('photo')}}">
                                @else
                                    <img src="{{ static_asset($avatar_image) }}" class="img-fit mw-100 size-150px size-md-250px rounded-circle md-rounded-0"  alt="{{translate('photo')}}">
                                @endif
                        </div>
                    </div>
                    <div class="col-md position-static d-flex align-items-center">
                        <span class="absolute-top-right px-4 py-3">
                            @if ($user->membership == 1)
                                <span class="badge badge-inline badge-primary">{{ translate('Lite') }}</span>
                            @elseif($user->membership == 2)
                                <span class="badge badge-inline badge-success">{{ translate('Pro') }}</span>
                            @elseif($user->membership == 3)
                                <span class="badge badge-inline badge-info">{{ translate('Verified') }}</span>
                            @elseif($user->membership == 4)
                                <span class="badge badge-inline badge-warning">{{ translate('VIP') }}</span>
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
                                    <td class="py-1"><span>{{ translate('Mother tongue') }} </span>
                                    </td>
                                    <td class="py-1 fw-400">
                                        @if ($user->mothere_tongue != null)
                                            {{ \App\Models\MemberLanguage::where('id', $user->mothere_tongue)->first()->name }}
                                        @else
                                            {{ $user->member_language }}
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
                                    <td class="py-1"><span>{{ translate('Location') }}</span></td>
                                    <td class="py-1" colspan="3">
                                        @if(!empty($user->city_name))
                                            {{ $user->city_name }} ,
                                        @endif
                                        @if(!empty($user->states_name))
                                            {{ $user->states_name }} ,
                                        @endif
                                        @if(!empty($user->country_name))
                                            {{ $user->country_name }}
                                        @endif
                                        
                                        
                                        
                                        @php
                                            $present_address = \App\Models\Address::where('type', 'present')
                                                ->where('user_id', $user->id)
                                                ->first();
                                        @endphp
                                    </td>
                                    
                                </tr>
                                 <tr>
                                    <th class="py-1"><span>{{ translate('General Requirement') }}</span></th>
                                    <td class="py-1" colspan="3">
                                        {{ $user->general_requirement }}
                                    </td>
                                </tr>
                                 <tr>
                                    <th class="py-1"><span>{{ translate('Preferred Location') }}</span></th>
                                    <td class="py-1" colspan="3">
                                       {{ $user->prefer_city_name?$user->prefer_city_name:'NA' }}
                                       <!--, {{ $user->prefer_states_name?$user->prefer_states_name:'NA' }}, {{ $user->prefer_country_name?$user->prefer_country_name:'NA' }}-->
                                    </td>
                                </tr>
                            </table>
                            <div class="row gutters-5 text-center">
                                <div class="col">
                                    <a @if (get_setting('full_profile_show_according_to_membership') == 1 && $user->membership == 1) href="javascript:void(0);" onclick="package_update_alert()"
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
                                        $interest_class = 'text-primary';
                                        $do_expressed_interest = \App\Models\ExpressInterest::where('user_id', $user->id)
                                            ->where('interested_by', $user->id)
                                            ->first();
                                        $received_expressed_interest = \App\Models\ExpressInterest::where('user_id', $user->id)
                                            ->where('interested_by', $user->id)
                                            ->first();
                                        if (empty($do_expressed_interest) && empty($received_expressed_interest)) {
                                            $interest_onclick = 1;
                                            $interest_text = translate('Interest');
                                            $interest_class = 'text-dark';
                                        } elseif (!empty($received_expressed_interest)) {
                                            $interest_onclick = 'do_response';
                                            $interest_text = $received_expressed_interest->status == 0 ? translate('Response to Interest') : translate('You Accepted Interest');
                                        } else {
                                            $interest_onclick = 0;
                                            $interest_text = $do_expressed_interest->status == 0 ? translate('Interest Expressed') : translate('Interest Accepted');
                                        }
                                    @endphp

                                    <a id="interest_a_id_{{ $user->id }}"
                                        @if ($interest_onclick == 1) 
                                            onclick="express_interest({{ $user->id }})"
                                        @elseif($interest_onclick == 'do_response')
                                            href="{{ route('interest_requests') }}"
                                        @endif
                                        class="text-reset c-pointer">
                                        <i class="la la-heart-o fs-20 text-primary"></i>
                                        <span id="interest_id_{{ $user->id }}"
                                            class="d-block fs-10 opacity-60 {{ $interest_class }}">
                                            {{ $interest_text }}
                                        </span>
                                    </a>
                                </div>
                                <div class="col">
                                    <?php 
                                    $userid = '';
                                    if(isset($_REQUEST['member_id'])){
                                        $userid = $_REQUEST['member_id'];
                                    }
                                    ?>
                                    @php
                                    
                                        $shortlist = \App\Models\Shortlist::where('user_id', $user->id)
                                            ->where('shortlisted_by', $userid)
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
                                        @if ($shortlist_onclick == 1) 
                                            onclick="do_shortlist({{ $user->id }})"
                                        @else
                                            onclick="remove_shortlist({{ $user->id }})" 
                                        @endif
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
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="aiz-pagination">
            {{ $users->appends(request()->input())->links() }}
        </div>