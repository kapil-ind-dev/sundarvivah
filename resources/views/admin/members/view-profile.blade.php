
        <!-- Introduction -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 h6">{{translate('Introduction')}}</h5>
            </div>
            <div class="card-body">
                <p>{{ $member->member->introduction }}</p>
            </div>
        </div>

        <!-- Basic Information -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 h6">{{translate('Basic Information')}}</h5>
            </div>
            <div class="card-body">
                <table class="table">
                <tr>
                    <th>{{translate('First Name')}}</th>
                    <td>{{ $member->first_name }}</td>

                    <th>{{translate('Last Name')}}</th>
                    <td>{{ $member->last_name }}</td>

                </tr>
                <tr>
                    <th>{{translate('Gender')}}</th>
                    <td>
                        @if($member->member->gender == 1)
                            {{translate('Male')}}
                        @elseif($member->member->gender == 2)
                            {{translate('Female')}}
                        @endif
                    </td>

                    <th>{{translate('Date Of Birth')}}</th>
                    <td>{{ !empty($member->member->birthday) ? date('Y-m-d', strtotime($member->member->birthday)) : ''}}</td>
                </tr>
                <tr>
                    <th>{{translate('Email')}}</th>
                    <td>{{ $member->email }}</td>
                    @if(addon_activation('otp_system'))
                        <th>{{translate('Phone Number')}}</th>
                    	<td>{{ $member->phone }}</td>
                    @endif
                </tr>
                <tr>
                    <th>{{translate('Marital Status')}}</th>
                    <td>{{ $member->member->marital_status->name ?? ""  }}</td>

                    <th>{{translate('Number Of Children')}}</th>
                    <td>{{ $member->member->children }}</td>
                </tr>
                <tr>
                    <th>{{translate('On Behalf')}}</th>
                    <td>{{ $member->member->on_behalves->name ?? ''}}</td>
                </tr>
                </table>
            </div>
        </div>

        <!-- Present Address -->
        @if(get_setting('member_present_address_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Present Address')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
                      @php $present_address = \App\Models\Address::where('user_id',$member->id)->where('type','present')->first(); @endphp
                			<tr>
                				<th>{{translate('City')}}</th>
                				<td>{{ $present_address->city->name ?? "" }}</td>

                				<th>{{translate('State')}}</th>
                              <td>{{ $present_address->state->name ?? "" }}</td>
                			</tr>
                          <tr>
      		                <th>{{translate('Country')}}</th>
                              <td>{{ $present_address->country->name ?? "" }}</td>

                              <th>{{translate('Postal Code')}}</th>
                              <td>{{ $present_address->postal_code ?? "" }}</td>
                          </tr>
                  </table>
              </div>
          </div>
        @endif

        <!-- Education -->
        @if(get_setting('member_education_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Education')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
                      <tr>
                          <th>{{translate('Degree')}}</th>
                          <th>{{translate('Institution')}}</th>
                          <th>{{translate('Start')}}</th>
                          <th>{{translate('End')}}</th>
                          <th>{{translate('Status')}}</th>
                      </tr>

                      @php $educations = \App\Models\Education::where('user_id',$member->id)->get(); @endphp
                      @foreach ($educations as $key => $education)
                      <tr>
                          <td>{{ $education->degree }}</td>
                          <td>{{ $education->institution }}</td>
                          <td>{{ $education->start }}</td>
                          <td>{{ $education->end }}</td>
                          <td>
                              @if($education->present == 1)
                                  <span class="badge badge-inline badge-success">{{translate('Active')}}</span>
                              @else
                                  <span class="badge badge-inline badge-danger">{{translate('Deactive')}}</span>
                              @endif
                          </td>
                      </tr>
                      @endforeach

                  </table>
              </div>
          </div>
        @endif

        <!-- Career -->
        @if(get_setting('member_career_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Career')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
                      <tr>
                          <th>{{translate('designation')}}</th>
                          <th>{{translate('company')}}</th>
                          <th>{{translate('Start')}}</th>
                          <th>{{translate('End')}}</th>
                          <th>{{translate('Status')}}</th>
                      </tr>

                      @php $careers = \App\Models\Career::where('user_id',$member->id)->get(); @endphp
                      @foreach ($careers as $key => $career)
                      <tr>
                          <td>{{ $career->designation }}</td>
                          <td>{{ $career->company }}</td>
                          <td>{{ $career->start }}</td>
                          <td>{{ $career->end }}</td>
                          <td>
                              @if($career->present == 1)
                                  <span class="badge badge-inline badge-success">{{translate('Active')}}</span>
                              @else
                                  <span class="badge badge-inline badge-danger">{{translate('Deactive')}}</span>
                              @endif
                          </td>
                      </tr>
                      @endforeach

                  </table>

              </div>
          </div>
        @endif

        <!-- Physical Attributes -->
        @if(get_setting('member_physical_attributes_section') == 'on')
          <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 h6">{{translate('Physical Attributes')}}</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>{{translate('Height')}}</th>
                        <td>{{ $member->physical_attributes->height ?? "" }}</td>

                        <th>{{translate('Weight')}}</th>
                        <td>{{ $member->physical_attributes->weight ?? "" }}</td>
                    </tr>
                    <tr>
                        <th>{{translate('Eye Color')}}</th>
                        <td>{{ $member->physical_attributes->eye_color ?? "" }}</td>

                        <th>{{translate('Hair Color')}}</th>
                        <td>{{ $member->physical_attributes->hair_color ?? "" }}</td>
                    </tr>
                    <tr>
                        <th>{{translate('Complexion')}}</th>
                        <td>{{ $member->physical_attributes->complexion ?? "" }}</td>

                        <th>{{translate('Blood Group')}}</th>
                        <td>{{ $member->physical_attributes->blood_group ?? "" }}</td>
                    </tr>
                    <tr>
                        <th>{{translate('Body Type')}}</th>
                        <td>{{ $member->physical_attributes->body_type ?? "" }}</td>

                        <th>{{translate('Body Art')}}</th>
                        <td>{{ $member->physical_attributes->body_art ?? "" }}</td>
                    </tr>
                    <tr>
                        <th>{{translate('Disability')}}</th>
                        <td>{{ $member->physical_attributes->disability ?? "" }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endif

        <!-- Language -->
        @if(get_setting('member_language_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Language')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
                      <tr>
                          <th>{{ translate('Mother Tangue') }}</th>
                          <td>
                              @if(!empty($member->member->mothere_tongue) && $member->member->mothereTongue != null)
                                  {{ $member->member->mothereTongue->name }}
                              @endif
                          </td>

                          <th>{{translate('Known Languages')}}</th>
                          <td>
                            @if(!empty($member->member->known_languages))
                              @foreach (json_decode($member->member->known_languages) as $key => $value)
                                @php $known_language = \App\Models\MemberLanguage::where('id',$value)->first(); @endphp
                                @if($known_language != null)
                                    <span class="badge badge-inline badge-info">
                                        {{ $known_language->name }}
                                    </span>
                                @endif
                              @endforeach
                            @endif
                          </td>
                      </tr>
                  </table>
              </div>
          </div>
        @endif

        <!-- Hobbies  -->
        @if(get_setting('member_hobbies_and_interests_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Hobbies & Interest')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
            				<tr>
            					<th>{{translate('Hobbies')}}</th>
                              <td>{{ $member->hobbies->hobbies ?? "" }}</td>

            					<th>{{translate('Interests')}}</th>
                              <td>{{ $member->hobbies->interests ?? "" }}</td>
            				</tr>
                          <tr>
            					<th>{{translate('Music')}}</th>
                              <td>{{ $member->hobbies->music ?? "" }}</td>

            					<th>{{translate('Books')}}</th>
                              <td>{{ $member->hobbies->books ?? "" }}</td>
            				</tr>
                          <tr>
            					<th>{{translate('Movies')}}</th>
                              <td>{{ $member->hobbies->movies ?? "" }}</td>

            					<th>{{translate('TV Shows')}}</th>
                              <td>{{ $member->hobbies->tv_shows ?? "" }}</td>
            				</tr>
                          <tr>
      						<th>{{translate('Sports')}}</th>
                              <td>{{ $member->hobbies->sports ?? "" }}</td>

      						<th>{{translate('Fitness Activities')}}</th>
                              <td>{{ $member->hobbies->fitness_activities ?? "" }}</td>
      					</tr>
                          <tr>
      						<th>{{translate('Cuisines')}}</th>
                              <td>{{ $member->hobbies->cuisines ?? "" }}</td>

      						<th>{{translate('Dress Styles')}}</th>
                              <td>{{ $member->hobbies->dress_styles ?? "" }}</td>
      					</tr>
                  </table>
              </div>
          </div>
        @endif

        <!-- Personal Attitude & Behavior -->
        @if(get_setting('member_personal_attitude_and_behavior_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Personal Attitude & Behavior')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
  			             <tr>
        						<th>{{translate('Affection')}}</th>
                              <td>{{ $member->attitude->affection ?? "" }}</td>

                              <th>{{translate('Humor')}}</th>
                              <td>{{ $member->attitude->humor ?? "" }}</td>
      					 </tr>
                           <tr>
                              <th>{{translate('Political Views')}}</th>
                              <td>{{ $member->attitude->political_views ?? "" }}</td>

                              <th>{{translate('Religious Service')}}</th>
                              <td>{{ $member->attitude->religious_service ?? "" }}</td>
                          </tr>
                  </table>
              </div>
          </div>
        @endif

        <!-- Residency Information -->
        @if(get_setting('member_residency_information_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Residency Information')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
                      <tr>
                            <th>{{translate('Birth Country')}}</th>
                            <td>
                                @if(!empty($member->recidency->birth_country_id))
                                {{ App\Models\Country::where('id',$member->recidency->birth_country_id)->first()->name }}
                                @endif
                            </td>

                            <th>{{translate('Residency Country')}}</th>
                            <td>
                                @if(!empty($member->recidency->recidency_country_id))
                                {{ App\Models\Country::where('id',$member->recidency->recidency_country_id)->first()->name }}
                                @endif
                            </td>
                      </tr>
                      <tr>
                            <th>{{translate('Grow Up Country')}}</th>
                            <td>
                                @if(!empty($member->recidency->growup_country_id))
                                    {{ App\Models\Country::where('id',$member->recidency->growup_country_id)->first()->name }}
                                @endif
                            </td>

                            <th>{{translate('Immigration Status')}}</th>
                            <td>{{ $member->recidency->immigration_status ?? "" }}</td>
                      </tr>
                  </table>
              </div>
          </div>
        @endif

        <!-- Spiritual & Social Background -->
        @if(get_setting('member_spiritual_and_social_background_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Spiritual & Social Background')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
                      <tr>
                          <th>{{translate('Religion')}}</th>
                          <td>{{ $member->spiritual_backgrounds->religion->name ?? "" }}</td>

                          <th>{{translate('Caste')}}</th>
                          <td>{{ $member->spiritual_backgrounds->caste->name ?? "" }}</td>
                      </tr>
                      <tr>
                          <th>{{translate('Sub Caste')}}</th>
                          <td>{{ $member->spiritual_backgrounds->sub_caste->name ?? "" }}</td>

                          <th>{{translate('Ethnicity')}}</th>
                          <td>{{ $member->spiritual_backgrounds->ethnicity ?? "" }}</td>
                      </tr>
                      <tr>
                          <th>{{translate('Personal Value')}}</th>
                          <td>{{ $member->spiritual_backgrounds->personal_value ?? "" }}</td>

                          <th>{{translate('Family Value')}}</th>
                          <td>{{ $member->spiritual_backgrounds->family_value->name ?? "" }}</td>
                      </tr>
                      <tr>
                          <th>{{translate('Community Value')}}</th>
                          <td>{{ $member->spiritual_backgrounds->community_value ?? "" }}</td>
                      </tr>
                  </table>
              </div>
          </div>
        @endif

        <!-- Life Style -->
        @if(get_setting('member_life_style_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Life Style')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
  	                 <tr>
                          <th>{{translate('Diet')}}</th>
                          <td>{{ $member->lifestyles->diet ?? "" }}</td>

                          <th>{{translate('Drink')}}</th>
                          <td>{{ $member->lifestyles->drink ?? "" }}</td>
                      </tr>
                      <tr>
                          <th>{{translate('Smoke')}}</th>
                          <td>{{ $member->lifestyles->smoke ?? "" }}</td>

                          <th>{{translate('Living With')}}</th>
                          <td>{{ $member->lifestyles->living_with ?? "" }}</td>
                      </tr>
                  </table>
              </div>
          </div>
        @endif

        <!-- Astronomic Information  -->
        @if(get_setting('member_astronomic_information_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Astronomic Information')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
                      <tr>
                          <th>{{translate('Sun Sign')}}</th>
                          <td>{{ $member->astrologies->sun_sign ?? "" }}</td>

                          <th>{{translate('Moon Sign')}}</th>
                          <td>{{ $member->astrologies->moon_sign ?? "" }}</td>
                      </tr>
                      <tr>
                          <th>{{translate('Time Of Birth')}}</th>
                          <td>{{ $member->astrologies->time_of_birth ?? "" }}</td>

                          <th>{{translate('City Of Birth')}}</th>
                          <td>{{ $member->astrologies->city_of_birth ?? "" }}</td>
                      </tr>
                  </table>
              </div>
          </div>
        @endif

        <!-- Permanent Address -->
        @if(get_setting('member_permanent_address_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Permanent Address')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
                      @php $permanent_address = \App\Models\Address::where('user_id',$member->id)->where('type','permanent')->first(); @endphp
                      <tr>
                          <th>{{translate('City')}}</th>
                          <td>{{ $permanent_address->city->name ?? "" }}</td>

                          <th>{{translate('State')}}</th>
                          <td>{{ $permanent_address->state->name ?? "" }}</td>
                      </tr>
                      <tr>
                          <th>{{translate('Country')}}</th>
                          <td>{{ $permanent_address->country->name ?? "" }}</td>

                          <th>{{translate('Postal Code')}}</th>
                          <td>{{ $permanent_address->postal_code ?? "" }}</td>
                      </tr>
                  </table>
              </div>
          </div>
        @endif

        <!-- Family Information -->
        @if(get_setting('member_family_information_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Family Information')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
  		                <tr>
                          <th>{{translate('Father')}}</th>
                          <td>{{ $member->families->father ?? "" }}</td>

                          <th>{{translate('Mother')}}</th>
                          <td>{{ $member->families->mother ?? "" }}</td>
                      </tr>
                      <tr>
                          <th>{{translate('Sibling')}}</th>
                          <td>{{ $member->families->sibling ?? "" }}</td>
                      </tr>
                  </table>
              </div>
          </div>
        @endif

        <!-- Partner Expectation -->
        @if(get_setting('member_partner_expectation_section') == 'on')
          <div class="card">
              <div class="card-header bg-dark text-white">
                  <h5 class="mb-0 h6">{{translate('Partner Expectation')}}</h5>
              </div>
              <div class="card-body">
                  <table class="table">
                      <tr>
                          <th>{{translate('General')}}</th>
                          <td>{{ $member->partner_expectations->general ?? "" }}</td>

                          <th>{{translate('Residence Country')}}</th>
                          <td>
                              @php
                              $residence_country =  $member->partner_expectations->residence_country_id ?? "";
                              if(!empty($residence_country)){
                                echo \App\Models\Country::where('id',$residence_country)->first()->name;
                              }
                              @endphp
                          </td>
                      </tr>
                      <tr>
                          <th>{{translate('Height')}}</th>
                          <td>{{ $member->partner_expectations->height ?? "" }}</td>

                          <th>{{translate('weight')}}</th>
                          <td>{{ $member->partner_expectations->weight ?? "" }}</td>
                      </tr>

                      <tr>
                          <th>{{translate('Marital Status')}}</th>
                          <td>{{ $member->partner_expectations->marital_status->name ?? "" }}</td>

                          <th>{{translate('Children Acceptable')}}</th>
                          <td>{{ !empty($member->partner_expectations->children_acceptable) ? attribute_text_format($member->partner_expectations->children_acceptable) : "" }}</td>
                      </tr>

                      <tr>
                          <th>{{translate('Religion')}}</th>
                          <td>{{ $member->partner_expectations->religion->name ?? "" }}</td>

                          <th>{{translate('Caste')}}</th>
                          <td>{{ $member->partner_expectations->caste->name ?? "" }}</td>
                      </tr>

                      <tr>
                          <th>{{translate('Sub Caste')}}</th>
                          <td>{{ $member->partner_expectations->sub_caste->name ?? "" }}</td>

                          <th>{{translate('Language')}}</th>
                          <td>{{ $member->partner_expectations->member_language->name ?? "" }}</td>
                      </tr>

                      <tr>
                          <th>{{translate('Education')}}</th>
                          <td>{{ $member->partner_expectations->education ?? "" }}</td>

                          <th>{{translate('Profession')}}</th>
                          <td>{{ $member->partner_expectations->profession ?? "" }}</td>
                      </tr>

                      <tr>
                          <th>{{translate('Smoking Acceptable')}}</th>
                          <td>{{ !empty($member->partner_expectations->smoking_acceptable) ? attribute_text_format($member->partner_expectations->smoking_acceptable) : "" }}</td>

                          <th>{{translate('Drinking Acceptable')}}</th>
                          <td>{{ !empty($member->partner_expectations->drinking_acceptable) ? attribute_text_format($member->partner_expectations->drinking_acceptable) : "" }}</td>
                      </tr>
                      <tr>
                          <th>{{translate('Diet')}}</th>
                          <td>{{ !empty($member->partner_expectations->diet) ? attribute_text_format($member->partner_expectations->diet) : "" }}</td>

                          <th>{{translate('Body Type')}}</th>
                          <td>{{ $member->partner_expectations->body_type ?? "" }}</td>
                      </tr>
                      <tr>
                          <th>{{translate('Personal Value')}}</th>
                          <td>{{ $member->partner_expectations->personal_value ?? "" }}</td>

                          <th>{{translate('Manglik')}}</th>
                          <td>{{ !empty($member->partner_expectations->manglik) ? attribute_text_format($member->partner_expectations->manglik) : "" }}</td>
                      </tr>
                      <tr>
                          <th>{{translate('Preferred Country')}}</th>
                          <td>
                              @php
                                  $preferred_country = $member->partner_expectations->preferred_country_id ?? "";
                                  if(!empty($preferred_country)){
                                      echo \App\Models\Country::where('id',$preferred_country)->first()->name;
                                  }
                              @endphp
                          </td>

                          <th>{{translate('preferred_state_id')}}</th>
                          <td>
                              @php
                                  $preferred_state = $member->partner_expectations->preferred_state_id ?? "";
                                  if(!empty($preferred_state)){
                                      echo \App\Models\State::where('id',$preferred_state)->first()->name;
                                  }
                              @endphp
                          </td>
                      </tr>
                      <tr>
                          <th>{{translate('Family Value')}}</th>
                          <td>{{ $member->partner_expectations->family_value->name ?? "" }}</td>

                          <th>{{translate('complexion')}}</th>
                          <td>{{ $member->partner_expectations->complexion ?? "" }}</td>
                      </tr>
                  </table>
              </div>
          </div>
        @endif