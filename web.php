<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('refresh-db', function() {
    ob_implicit_flush(true);
    echo 'Reseting migrate...<br>';
    ob_flush();
    flush();
    Artisan::call('migrate:reset');
    echo 'Reseted migrate!<br><br>';
    echo 'Refreshing migrate...<br>';
    ob_flush();
    flush();
    Artisan::call('migrate:refresh');
    echo 'Refreshed migrate!<br><br>';
    echo 'Seeding migrate...<br>';
    ob_flush();
    flush();
    Artisan::call('db:seed');
    echo 'Seeded migrate!<br>';
});*/

Route::group(
    [
        'namespace' => 'Frontend',
        'middleware' => 'support.render.template'
    ],
    function() {
        Route::get('/', 'IndexController@index')->name('frontend.index');

        Route::get('/cau-hoi-thuong-gap.html', 'IndexController@faq')->name('frontend.faq');

        Route::post('contact', 'ContactController')->name('frontend.sendContact');
        Route::get('contact', 'ContactController@getcontact');

        Route::get('article', 'ArticleController@detail')->name('frontend.viewArticle');
        Route::get('article/{id}', 'ArticleController@detail');
        Route::post('article/pagination', 'ArticleController@getArticlesPaginator')->name('frontend.getArticlesPaginator');
    }
);



Route::group(
    [
        'prefix' => 'admin',
        'namespace' => 'Backend'
    ],
    function() {

        Route::get('login', 'AuthController@showLoginForm')->name('login');
        Route::post('login', 'AuthController@login');
        Route::get('logout', 'AuthController@logout')->name('logout');

        Route::group(
            ['middleware' => 'auth'],
            function() {
                // Chỉ admin mới có thể truy cập vào các route trong group này
                Route::group(
                    // Lưu ý middleware check quyền admin
                    ['middleware' => 'check.admin.right'],
                    function() {
                        Route::get('user', 'UserController@index')->name('backend.user');
                        Route::get('user/create', 'UserController@showRegisterForm')->name('backend.showRegisterUserForm');
                        Route::post('user/create', 'UserController@register');
                        Route::get('user/update/{id}', 'UserController@showUpdateForm')->name('backend.showUpdateUserForm');
                        Route::post('user/update/{id}', 'UserController@update');
                        Route::post('user/delete', 'UserController@delete')->name('backend.deleteUser');
                    }
                );

                // Dashboard
                Route::get('/', 'DashboardController@index')->name('backend.dashboard');

                // Banner
                Route::get('banner', 'BannerController@index')->name('backend.banner');
                Route::get('banner/create/', 'BannerController@showCreateForm')->name('backend.showCreateBannerForm');
                Route::post('banner/create/', 'BannerController@create');
                Route::get('banner/update/{id}', 'BannerController@showUpdateForm')->name('backend.showUpdateBannerForm');
                Route::post('banner/update/{id}', 'BannerController@update');
                Route::post('banner/enable', 'BannerController@enable')->name('backend.enableBanner');
                Route::post('banner/delete', 'BannerController@delete')->name('backend.deleteBanner');

                // Menu liệu pháp
                Route::get('menu', 'TherapyMenuController@index')->name('backend.therapyMenu');
                Route::get('menu/update/{id}', 'TherapyMenuController@showUpdateForm')->name('backend.showUpdateTherapyMenuForm');
                Route::post('menu/update/{id}', 'TherapyMenuController@update');

                // Nguồn gốc liệu pháp
                Route::get('therapy-origin/update', 'TherapyOriginController@showUpdateForm')->name('backend.showUpdateTherapyOriginForm');
                Route::post('therapy-origin/update', 'TherapyOriginController@update');

                // Định nghĩa liệu pháp
                Route::get('therapy-definition/update', 'TherapyDefinitionController@showUpdateForm')->name('backend.showUpdateTherapyDefinitionForm');
                Route::post('therapy-definition/update', 'TherapyDefinitionController@update');

                // Tác dụng của liệu pháp
                Route::get('therapy-effect', 'TherapyEffectController@index')->name('backend.therapyEffect');
                Route::get('therapy-effect/update/{id}', 'TherapyEffectController@showUpdateForm')->name('backend.showUpdateTherapyEffectForm');
                Route::post('therapy-effect/update/{id}', 'TherapyEffectController@update');

                // Chỉ định về liệu pháp
                Route::get('therapy-indication', 'TherapyIndicationController@index')->name('backend.therapyIndication');
                Route::get('therapy-indication/update/{id}', 'TherapyIndicationController@showUpdateForm')->name('backend.showUpdateTherapyIndicationForm');
                Route::post('therapy-indication/update/{id}', 'TherapyIndicationController@update');

                // Người nổi tiếng
                Route::get('celebrity', 'CelebrityController@index')->name('backend.celebrity');
                Route::get('celebrity/update/{id}', 'CelebrityController@showUpdateForm')->name('backend.showUpdateCelebrityForm');
                Route::post('celebrity/update/{id}', 'CelebrityController@update');

                // Chương trình điều trị
                Route::get('treatment-program', 'TreatmentProgramController@index')->name('backend.treatmentProgram');
                Route::get('treatment-program/update/{id}', 'TreatmentProgramController@showUpdateForm')->name('backend.showUpdateTreatmentProgramForm');
                Route::post('treatment-program/update/{id}', 'TreatmentProgramController@update');

                // Tin tức
                Route::get('article', 'ArticleController@index')->name('backend.article');
                Route::get('article/create/', 'ArticleController@showCreateForm')->name('backend.showCreateArticleForm');
                Route::post('article/create/', 'ArticleController@create');
                Route::get('article/update/{id}', 'ArticleController@showUpdateForm')->name('backend.showUpdateArticleForm');
                Route::post('article/update/{id}', 'ArticleController@update');
                Route::post('article/delete', 'ArticleController@delete')->name('backend.deleteArticle');

                // Câu hỏi thường gặp
                Route::get('faq', 'FaqController@index')->name('backend.faq');
                Route::get('faq/create/', 'FaqController@showCreateForm')->name('backend.showCreateFaqForm');
                Route::post('faq/create/', 'FaqController@create');
                Route::get('faq/update/{id}', 'FaqController@showUpdateForm')->name('backend.showUpdateFaqForm');
                Route::post('faq/update/{id}', 'FaqController@update');
                Route::post('faq/delete', 'FaqController@delete')->name('backend.deleteFaq');

                // Liên hệ
                Route::get('contact', 'ContactController@index')->name('backend.contact');
                Route::get('contact/view/{id}', 'ContactController@view')->name('backend.viewContact');
                Route::post('contact/read/{id}', 'ContactController@read')->name('backend.readContact');
                Route::post('contact/unread/{id}', 'ContactController@unread')->name('backend.unreadContact');
                Route::post('contact/delete/', 'ContactController@delete')->name('backend.deleteContact');

                // Medical center
                Route::get('medical-center/update/', 'MedicalCenterController@showUpdateForm')->name('backend.showUpdateMedicalCenterForm');
                Route::post('medical-center/update/', 'MedicalCenterController@update');

                // Get social: url mạng xã hội
                Route::get('social-network', 'SocialNetworkController@index')->name('backend.socialNetwork');
                Route::get('social-network/update/{id}', 'SocialNetworkController@showUpdateForm')->name('backend.showUpdateSocialNetworkForm');
                Route::post('social-network/update/{id}', 'SocialNetworkController@update');
            }
        );
    }
);