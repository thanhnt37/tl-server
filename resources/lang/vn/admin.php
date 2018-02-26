<?php

return [
    'menu'       => [
        'dashboard'                => 'Bảng Điều Khiển',
        'admin_users'              => 'Quản Trị Viên',
        'users'                    => 'Người Dùng',
        'admin_user_notifications' => 'AdminUserNotifications',
        'user_notifications'       => 'UserNotifications',
        'site_configuration'       => 'Site Configuration',
        'log_system'               => 'Logs System',
        'images'                   => 'Images',
        'articles'                 => 'Articles',
    ],
    'breadcrumb' => [
        'dashboard'                => 'Bảng Điều Khiển',
        'admin_users'              => 'Quản Trị Viên',
        'users'                    => 'Người Dùng',
        'admin_user_notifications' => 'AdminUserNotifications',
        'user_notifications'       => 'UserNotifications',
        'site_configuration'       => 'Site Configuration',
        'log_system'               => 'Logs',
        'images'                   => 'Images',
        'articles'                 => 'Articles',
        'create_new'               => 'Create New',
    ],
    'messages'   => [
        'general' => [
            'update_success' => 'Cập nhật thành công.',
            'create_success' => 'Tạo mới thành công.',
            'delete_success' => 'Xóa dữ liệu thành công.',
        ],
    ],
    'errors'     => [
        'general'  => [
            'save_failed' => 'Failed To Save. Please contact with developers',
        ],
        'requests' => [
            'me' => [
                'email'    => [
                    'required' => 'Email Required',
                    'email'    => 'Email is not valid',
                ],
                'password' => [
                    'min' => 'Password need at least 6 letters',
                ],
            ],
        ],
    ],
    'pages'      => [
        'common'                   => [
            'label'   => [
                'page'             => 'Trang',
                'actions'          => 'Actions',
                'is_enabled'       => 'Trạng thái',
                'is_enabled_true'  => 'Enabled',
                'is_enabled_false' => 'Disabled',
                'search_results'   => 'Tổng: :count kết qủa',
                'select_province'  => 'Chọn Tỉnh/Thành',
                'select_district'  => 'Chọn Quận/Huyện',
                'select_locale'    => 'Select a Locale',
                'select_category'  => 'Chọn Danh mục',
            ],
            'buttons' => [
                'create'          => 'Tạo mới',
                'edit'            => 'Sửa',
                'save'            => 'Lưu lại',
                'delete'          => 'Xóa',
                'cancel'          => 'Hủy',
                'back'            => 'Trở lại',
                'add'             => 'Thêm',
                'preview'         => 'Xem trước',
                'forgot_password' => 'Send Me Email!',
                'reset_password'  => 'Reset Password',
            ],
        ],
        'auth'                     => [
            'buttons'  => [
                'sign_in'         => 'Đăng Nhập',
                'forgot_password' => 'Send Me Email!',
                'reset_password'  => 'Reset Password',
            ],
            'messages' => [
                'remember_me'     => 'Remember Me',
                'please_sign_in'  => 'Sign in to start your session',
                'forgot_password' => 'I forgot my password',
                'reset_password'  => 'Please enter your e-mail address and new password',
            ],
        ],
        'site-configurations'      => [
            'columns' => [
                'locale'                => 'Locale',
                'name'                  => 'Name',
                'title'                 => 'Title',
                'keywords'              => 'Keywords',
                'description'           => 'Descriptions',
                'ogp_image_id'          => 'OGP Image',
                'twitter_card_image_id' => 'Twitter Card Image',
            ],
        ],
        'articles'                 => [
            'columns' => [
                'slug'               => 'Slug',
                'title'              => 'Title',
                'keywords'           => 'Keywords',
                'description'        => 'Description',
                'content'            => 'Content',
                'cover_image_id'     => 'Cover Image',
                'locale'             => 'Locale',
                'is_enabled'         => 'Active',
                'publish_started_at' => 'Publish Started At',
                'publish_ended_at'   => 'Publish Ended At',
                'is_enabled_true'    => 'Enabled',
                'is_enabled_false'   => 'Disabled',

            ],
        ],
        'user-notifications'       => [
            'columns' => [
                'user_id'       => 'User',
                'category_type' => 'Category',
                'type'          => 'Type',
                'data'          => 'Data',
                'locale'        => 'Locale',
                'content'       => 'Content',
                'read'          => 'Read',
                'read_true'     => 'Read',
                'read_false'    => 'Unread',
                'sent_at'       => 'Sent At',
            ],
        ],
        'admin-user-notifications' => [
            'columns' => [
                'user_id'       => 'User',
                'category_type' => 'Category',
                'type'          => 'Type',
                'data'          => 'Data',
                'locale'        => 'Locale',
                'content'       => 'Content',
                'read'          => 'Read',
                'read_true'     => 'Read',
                'read_false'    => 'Unread',
                'sent_at'       => 'Sent At',
            ],
        ],
        'images'                   => [
            'columns' => [
                'url'                    => 'URL',
                'title'                  => 'Title',
                'is_local'               => 'is Local',
                'entity_type'            => 'EntityType',
                'entity_id'              => 'ID',
                'file_category_type'     => 'Category',
                's3_key'                 => 'S3 Key',
                's3_bucket'              => 'S3 Bucket',
                's3_region'              => 'S3 Region',
                's3_extension'           => 'S3 Extension',
                'media_type'             => 'Media Type',
                'format'                 => 'Format',
                'file_size'              => 'File Size',
                'width'                  => 'Width',
                'height'                 => 'Height',
                'has_alternative'        => 'has Alternative',
                'alternative_media_type' => 'Alternative Media Type',
                'alternative_format'     => 'Alternative Format',
                'alternative_extension'  => 'Alternative Extension',
                'is_enabled'             => 'Status',
                'is_enabled_true'        => 'Enabled',
                'is_enabled_false'       => 'Disabled',
            ],
        ],
        'admin-users'              => [
            'columns' => [
                'name'             => 'Họ tên',
                'email'            => 'Email',
                'password'         => 'Mật khẩu',
                're_password'      => 'Xác nhận',
                'role'             => 'Vai trò',
                'locale'           => 'Locale',
                'profile_image_id' => 'Ảnh đại diện',
                'permissions'      => 'Phân quyền',
            ],
        ],
        'users'                    => [
            'columns' => [
                'name'                 => 'Name',
                'email'                => 'Email',
                'password'             => 'Password',
                'gender'               => 'Gender',
                'gender_male'          => 'Male',
                'gender_female'        => 'Female',
                'telephone'            => 'Telephone',
                'birthday'             => 'Birthday',
                'locale'               => 'Locale',
                'address'              => 'Address',
                'remember_token'       => 'Remember Token',
                'api_access_token'     => 'Api Access Token',
                'profile_image_id'     => 'Profile Image',
                'last_notification_id' => 'Last Notification Id',
                'is_activated'         => 'is Activated',
            ],
        ],
        'logs'                     => [
            'columns' => [
                'user_name' => 'User Name',
                'email'     => 'Email',
                'action'    => 'Action',
                'table'     => 'Table',
                'record_id' => 'Record ID',
                'query'     => 'Query',
            ],
        ],
        'boxes'                    => [
            'columns' => [
                'imei'            => 'IMEI',
                'serial'          => 'Serial',
                'box_version_id'  => 'Phiên bản Box',
                'os_version_id'   => 'Phiên bản OS',
                'sdk_version_id'  => 'Phiên bản SDK',
                'is_activated'    => 'Trạng thái',
                'activation_date' => 'Activation Date',
                'activate'        => 'Đã kích hoạt',
                'is_blocked'      => 'is Blocked',
                'deactivate'      => 'Chưa kích hoạt',
            ],
        ],
        'kara-versions'            => [
            'columns' => [
                'version'     => 'Phiên bản',
                'name'        => 'Tên',
                'description' => 'Mô tả',
                'apk_url'     => 'APK Url',
            ],
        ],
        'kara-ota'                 => [
            'columns' => [
                'os_version'     => 'Phiên bản OS',
                'sdk_version'    => 'Phiên bản SDK',
                'box_version_id' => 'Phiên bản Box',
                'app_version_id' => 'Phiên bản App',
            ],
        ],
        'os-versions'              => [
            'columns' => [
                'name' => 'Tên',
            ],
        ],
        'sdk-versions'             => [
            'columns' => [
                'name' => 'Tên',
            ],
        ],
        'box-versions'             => [
            'columns' => [
                'name' => 'Tên',
            ],
        ],
        'oauth-clients'            => [
            'columns' => [
                'user_id'                => 'User ID',
                'name'                   => 'Name',
                'secret'                 => 'Secret',
                'redirect'               => 'Redirect',
                'personal_access_client' => 'Personal Access Client',
                'password_client'        => 'Password Client',
                'revoked'                => 'Revoked',
            ],
        ],
        'songs'                    => [
            'columns' => [
                'code'        => 'Code',
                'wildcard'    => 'Wildcard',
                'name'        => 'Tên',
                'description' => 'Mô tả',
                'link'        => 'Link',
                'type'        => 'Thể loại',
                'sub_link'    => 'Sub Link',
                'image'       => 'Image',
                'view'        => 'Lượt xem',
                'play'        => 'Lượt hát',
                'vote'        => 'Bình chọn',
                'author_id'   => 'Tác giả',
                'publish_at'  => 'Ngày xuất bản',
            ],
        ],
        'albums'                   => [
            'columns' => [
                'name'        => 'Tên',
                'description' => 'Mô tả',
                'image'       => 'Ảnh đại diện',
                'vote'        => 'Bình chọn',
                'publish_at'  => 'Ngày xuất bản',
            ],
        ],
        'authors'                  => [
            'columns' => [
                'name'        => 'Tác giả',
                'description' => 'Mô tả',
                'image'       => 'Ảnh đại diện',
            ],
        ],
        'genres'                   => [
            'columns' => [
                'name'        => 'Tên',
                'description' => 'Mô tả',
                'image'       => 'Ảnh đại diện',
            ],
        ],
        'singers'                  => [
            'columns' => [
                'name'        => 'Tên',
                'description' => 'Mô tả',
                'image'       => 'Ảnh đại diện',
            ],
        ],
        'customers'                => [
            'columns' => [
                'name'      => 'Tên',
                'email'     => 'Email',
                'address'   => 'Địa chỉ',
                'telephone' => 'Điện thoại',
                'area'      => 'Khu vực',
                'agency'    => 'Đại lý',
            ],
        ],
        'sales'                    => [
            'columns' => [
                'customer_id' => 'Customer ID',
                'box_id'      => 'Serial',
            ],
        ],
        'applications'             => [
            'columns' => [
                'name'       => 'Name',
                'app_key'    => 'App Key',
                'is_blocked' => 'Is Blocked',
            ],
        ],
        'developers'               => [
            'columns' => [
                'name' => 'Name',
            ],
        ],
        'store-applications'       => [
            'columns' => [
                'name'                => 'Tên',
                'version_name'        => 'Tên phiên bản',
                'version_code'        => 'Mã phiên bản',
                'package_name'        => 'Tên package',
                'description'         => 'Mô tả',
                'icon_image_id'       => 'Ảnh đại diện',
                'background_image_id' => 'Hình nền',
                'hit'                 => 'Lượt tải',
                'apk_package_id'      => 'APK Package',
                'category_id'         => 'Danh mục',
                'developer_id'        => 'Nhà phát triển',
                'publish_started_at'  => 'Ngày xuất bản',
            ],
        ],
        'categories'               => [
            'columns' => [
                'name'           => 'Tên',
                'description'    => 'Mô tả',
                'type'           => 'Thể loại',
                'cover_image_id' => 'Ảnh đại diện',
            ],
        ],
        /* NEW PAGE STRINGS */
    ],
    'roles'      => [
        'super_user' => 'Super User',
        'admin'      => 'Administrator',
    ],
];
