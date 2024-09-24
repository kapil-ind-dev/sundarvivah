<?php

use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\CasteController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\HappyStoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ManualPaymentMethodController;
use App\Http\Controllers\MemberBulkAddController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberLanguageController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\ReportedUserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SubCasteController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ProfessionController;

/*
  |--------------------------------------------------------------------------
  | Admin Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register admin routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::post('/update', 'UpdateController@step0')->name('update');
Route::get('/update/step1', 'UpdateController@step1')->name('update.step1');
Route::get('/update/step2', 'UpdateController@step2')->name('update.step2');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'HomeController@admin_login')->name('admin');
});

Route::get('/admin/login', 'HomeController@admin_login')->name('admin.login');
Route::get('/admin/login', 'HomeController@admin_login')->name('admin.login');
Route::post('/get-profession', 'ProfessionController@get_profession')->name('get-profession');
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/dashboard', 'HomeController@admin_dashboard')->name('admin.dashboard');
    Route::get('/total-members', 'MemberController@total_members')->name('admin.total-members');
    Route::get('/verified-members', 'MemberController@verified_members')->name('admin.verified-members');
    Route::get('/vip-members', 'MemberController@vip_members')->name('admin.vip-members');
    Route::get('/blocked-members', 'MemberController@blocked_members')->name('admin.blocked-members');

    Route::resource('profile', 'ProfileController');

    // Contact Us page
    Route::resource('/contact-us', 'ContactUsController');
    Route::get('/contact-us/destroy/{id}', 'ContactUsController@destroy')->name('contact-us.delete');

    // Member Manage
    Route::resource('members', MemberController::class);
    Route::controller(MemberController::class)->group(function () {
        
        Route::get('/members/member_list/{id}', 'index')->name('members.index');
        Route::post('/members/block', 'block')->name('members.block');
        Route::post('/members/blocking_reason', 'blocking_reason')->name('members.blocking_reason');
        Route::get('/members/login/{id}', 'login')->name('members.login');

        Route::get('/deleted_members', 'deleted_members')->name('deleted_members');
        Route::get('/members/destroy/{id}', 'destroy')->name('members.destroy');
        Route::get('/restore_deleted_member/{id}', 'restore_deleted_member')->name('restore_deleted_member');
        Route::get('/members/permanently_delete/{id}', 'member_permanemtly_delete')->name('members.permanently_delete');

        Route::get('/member/unapproved-profile-pictures', 'unapproved_profile_pictures')->name('unapproved_profile_pictures');
        Route::post('/member/approve_profile_image', 'approve_profile_image')->name('approve_profile_image');

        Route::get('/member/show-verification-info/{id}', 'show_verification_info')->name('member.show_verification_info');
        Route::get('/member/approve-verification/{id}', 'approve_verification')->name('member.approve_verification');
        Route::get('/member/reject-verification/{id}', 'reject_verification')->name('member.reject_verification');


        // member's package manage
        Route::post('/members/package_info', 'package_info')->name('members.package_info');
        Route::post('/members/get_package', 'get_package')->name('members.get_package');
        Route::post('/members/package_do_update/{id}', 'package_do_update')->name('members.package_do_update');
        Route::get('/package-payment-invoice/{id}', 'package_payment_invoice_admin')->name('package_payment.invoice_admin');
        Route::post('/members/wallet-balance-update', 'member_wallet_balance_update')->name('member.wallet_balance_update');
    });

    Route::controller(ReportedUserController::class)->group(function () {
        Route::get('/reported-members/{id}', 'reported_members')->name('reported_members');
        Route::get('/reported/destroy/{id}', 'destroy')->name('report_destrot.destroy');
    });

    // Bulk member
    Route::controller(MemberBulkAddController::class)->group(function () {
        Route::get('/member-bulk-add/index', 'index')->name('member_bulk_add.index');
        Route::get('/download/on-behalf', 'pdf_download_on_behalf')->name('pdf.on_behalf');
        Route::get('/download/package', 'pdf_download_package')->name('pdf.package');
        Route::post('/bulk-member-upload', 'bulk_upload')->name('bulk_member_upload');
    });

    // Premium Packages
    Route::resource('/packages', 'PackageController');
    Route::controller(PackageController::class)->group(function () {
        Route::post('/packages/update_status', 'update_status')->name('packages.update_status');
        Route::get('/packages/destroy/{id}', 'destroy')->name('packages.destroy');
    });

    // package Payments
    Route::resource('package-payments', 'PackagePaymentController');
    Route::get('/manual-payment-accept/{id}', 'PackagePaymentController@manual_payment_accept')->name('manual_payment_accept');

    // Wallet
    Route::controller(WalletController::class)->group(function () {
        Route::get('/wallet-transaction-history', 'wallet_transaction_history_admin')->name('wallet_transaction_history_admin');
        Route::get('/manual-wallet-recharge-requests', 'manual_wallet_recharge_requests')->name('manual_wallet_recharge_requests');
        Route::get('/wallet-payment-details/{id}', 'show')->name('wallet_payment_details');
        Route::get('/wallet-manual-payment-accept/{id}', 'wallet_manual_payment_accept')->name('wallet_manual_payment_accept');
    });

    Route::resource('/happy-story', HappyStoryController::class);
    Route::post('/happy-story/update-story-status',[HappyStoryController::class, 'approval_status'])->name('happy_story_approval.status');

    //Blog Section
    Route::resource('blog-category', 'BlogCategoryController');
    Route::get('/blog-category/destroy/{id}', 'BlogCategoryController@destroy')->name('blog-category.destroy');

    Route::resource('blog', 'BlogController');
    Route::controller(BlogController::class)->group(function () {
        Route::get('/blog/destroy/{id}', 'destroy')->name('blog.destroy');
        Route::post('/blog/change-status', 'change_status')->name('blog.change-status');
    });

    // Member profile attributes
    // religions
    Route::resource('/religions', ReligionController::class);
    Route::controller(ReligionController::class)->group(function () {
        Route::get('/religions/destroy/{id}', 'destroy')->name('religions.destroy');
        Route::post('/religion/bulk_destroy', 'religion_bulk_delete')->name('religion.bulk_delete');
    });

    // Caste
    Route::resource('/castes', CasteController::class);
    Route::controller(CasteController::class)->group(function () {
        Route::get('/castes/destroy/{id}', 'destroy')->name('castes.destroy');
        Route::post('/caste/bulk_destroy', 'caste_bulk_delete')->name('caste.bulk_delete');
    });

    // SubCaste
    Route::resource('/sub-castes', SubCasteController::class);
    Route::controller(SubCasteController::class)->group(function () {
        Route::get('/sub-castes/destroy/{id}', 'destroy')->name('sub-castes.destroy');
        Route::post('/sub-caste/bulk_destroy', 'sub_caste_bulk_delete')->name('sub-castes.bulk_delete');
    });

    // Member Language
    Route::resource('member-languages', MemberLanguageController::class);
    Route::get('/member-language/destroy/{id}', [MemberLanguageController::class, 'destroy'])->name('member-languages.destroy');

    // Country
    Route::resource('/countries', CountryController::class);
    Route::controller(CountryController::class)->group(function () {
        Route::post('/countries/status', 'updateStatus')->name('countries.status');
        Route::get('/countries/destroy/{id}', 'destroy')->name('countries.destroy');
    });
    
    // highest education
    Route::resource('/highest-education', HighestEducationController::class);
    Route::controller(HighestEducationController::class)->group(function () {
        Route::get('/highest-education/destroy/{id}', 'destroy')->name('highest-education.destroy');
        Route::post('/highest-education/bulk_destroy', 'religion_bulk_delete')->name('highest-education.bulk_delete');
    });

    // employed in
    Route::resource('/employed-in', EmployedInController::class);
    Route::controller(EmployedInController::class)->group(function () {
        Route::get('/employed-in/destroy/{id}', 'destroy')->name('employed-in.destroy');
        Route::post('/employed-in/bulk_destroy', 'religion_bulk_delete')->name('employed-in.bulk_delete');
    });
    // profile filter
    Route::controller(ProfileFilterController::class)->group(function () {
        Route::get('/profile-filter', 'index')->name('profile-filter');
        Route::post('/get-profession', 'get_profession')->name('get-profession');
        Route::post('/get-member-profile', 'get_member_profile')->name('get-member-profile');
        Route::post('/add-to-shortlist', 'add_to_shortlist')->name('add-to-shortlist');
        Route::post('/remove-from-shortlist', 'remove_from_shortlist')->name('remove-from-shortlist');
        // Route::post('/employed-in/bulk_destroy', 'religion_bulk_delete')->name('employed-in.bulk_delete');
    });
    
    // profession
    Route::resource('/profession', ProfessionController::class);
    Route::controller(ProfessionController::class)->group(function () {
        Route::get('/profession/destroy/{id}', 'destroy')->name('profession.destroy');
        Route::post('/profession/bulk_destroy', 'religion_bulk_delete')->name('profession.bulk_delete');
    });
    
    // State
    Route::resource('/states', StateController::class);
    Route::get('/states/destroy/{id}', [StateController::class,'destroy'])->name('states.destroy');

    // City
    Route::resource('/cities', 'CityController');
    Route::get('/cities/destroy/{id}', 'CityController@destroy')->name('cities.destroy');

    // Family Status
    Route::resource('/family-status', 'FamilyStatusController');
    Route::get('/family-status/destroy/{id}', 'FamilyStatusController@destroy')->name('family-status.destroy');

    // Family Value
    Route::resource('/family-values', 'FamilyValueController');
    Route::get('/family-values/destroy/{id}', 'FamilyValueController@destroy')->name('family-values.destroy');

    // On Behalf
    Route::resource('/on-behalf', 'OnBehalfController');
    Route::get('/on-behalf/destroy/{id}', 'OnBehalfController@destroy')->name('on-behalf.destroy');

    Route::resource('marital-statuses', 'MaritalStatusController');
    Route::get('/marital-statuses/destroy/{id}', 'MaritalStatusController@destroy')->name('marital-statuses.destroy');

    // Email Templates
    Route::resource('/email-templates', EmailTemplateController::class);
    Route::post('/email-templates/update', 'EmailTemplateController@update')->name('email-templates.update');

    // Marketing
    Route::controller(NewsletterController::class)->group(function () {
        Route::get('/newsletter', 'index')->name('newsletters.index');
        Route::post('/newsletter/send', 'send')->name('newsletters.send');
        Route::post('/newsletter/test/smtp', 'testEmail')->name('test.smtp');
    });

    // Language
    Route::resource('/languages', 'LanguageController');
    Route::controller(LanguageController::class)->group(function () {
        Route::post('/languages/update_rtl_status', 'update_rtl_status')->name('languages.update_rtl_status');
        Route::post('/languages/key_value_store', 'key_value_store')->name('languages.key_value_store');
        Route::get('/languages/destroy/{id}', 'destroy')->name('languages.destroy');
    });

    // Setting
    Route::resource('/settings', SettingController::class);
    Route::controller(SettingController::class)->group(function () {
        Route::post('/settings/update', 'update')->name('settings.update');
        Route::post('/settings/activation/update', 'updateActivationSettings')->name('settings.activation.update');

        // Firebase Push Notification Setting
        Route::get('/settings/firebase/fcm', 'fcm_settings')->name('settings.fcm');
        Route::post('/settings/firebase/fcm', 'fcm_settings_update')->name('settings.fcm.update');
    
        Route::get('/general-settings', 'general_settings')->name('general_settings');
        Route::get('/smtp-settings', 'smtp_settings')->name('smtp_settings');
    
        Route::get('/payment-methods-settings', 'payment_method_settings')->name('payment_method_settings');
        Route::post('/payment_method_update', 'payment_method_update')->name('payment_method.update');
    
        Route::get('/third-party-settings', 'third_party_settings')->name('third_party_settings');
        Route::post('/third-party-settings/update', 'third_party_settings_update')->name('third_party_settings.update');
    
        Route::get('/social-media-login-settings', 'social_media_login_settings')->name('social_media_login');
    
        Route::get('//member-profile-sections', 'member_profile_sections_configuration')->name('member_profile_sections_configuration');
    
        // env Update
        Route::post('/env_key_update', 'env_key_update')->name('env_key_update.update');

        Route::get('/verification/form', 'member_verification_form')->name('member_verification_form.index');
        Route::post('/verification/form/update', 'member_verification_form_update')->name('member_verification_form.update');

        Route::get('/system/update', 'system_update')->name('system_update');
        Route::get('/system/server-status', 'system_server')->name('system_server');
    });
   

    // Currency settings
    Route::resource('currencies', 'CurrencyController');
    Route::controller(CurrencyController::class)->group(function () {
        Route::post('/currency/update_currency_activation_status', 'update_currency_activation_status')->name('currency.update_currency_activation_status');
        Route::get('/currency/destroy/{id}', 'destroy')->name('currency.destroy');
    });

    // website setting
    Route::group(['prefix' => 'website'], function () {
        Route::controller(SettingController::class)->group(function () {
            Route::get('/header_settings', 'website_header_settings')->name('website.header_settings');
            Route::get('/footer_settings', 'website_footer_settings')->name('website.footer_settings');
            Route::get('/appearances', 'website_appearances')->name('website.appearances');
        });

        Route::resource('custom-pages', 'PageController');
        Route::controller(PageController::class)->group(function () {
            Route::get('/custom-pages/edit/{id}', 'edit')->name('custom-pages.edit');
            Route::get('/custom-pages/destroy/{id}', 'destroy')->name('custom-pages.destroy');
        });
    });

    Route::resource('staffs', 'StaffController');
    Route::get('/staffs/destroy/{id}', 'StaffController@destroy')->name('staffs.destroy');

    Route::resource('roles', 'RoleController');
    Route::get('/roles/destroy/{id}', 'RoleController@destroy')->name('roles.destroy');

    // permission add
    Route::post('/roles/add_permission', 'RoleController@add_permission')->name('roles.permission');

    Route::get('/notifications', 'NotificationController@index')->name('admin.notifications');

    Route::resource('addons', 'AddonController');
    Route::post('/addons/activation', 'AddonController@activation')->name('addons.activation');

    // uploaded files
    Route::resource('/uploaded-files', AizUploadController::class);
    Route::controller(AizUploadController::class)->group(function() {
        Route::any('/uploaded-files/file-info', 'file_info')->name('uploaded-files.info');
        Route::get('/uploaded-files/destroy/{id}', 'destroy')->name('uploaded-files.destroy');
        Route::post('/bulk-uploaded-files-delete', 'bulk_uploaded_files_delete')->name('bulk-uploaded-files-delete');
    });

    Route::get('/cache-cache', 'HomeController@clearCache')->name('cache.clear');

    // Manual Payment
    Route::resource('manual_payment_methods', ManualPaymentMethodController::class);
    Route::get('/manual_payment_methods/destroy/{id}', [ManualPaymentMethodController::class, 'destroy'])->name('manual_payment_methods.destroy');
});
