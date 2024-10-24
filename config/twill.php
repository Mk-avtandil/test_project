<?php

return [
    'dashboard' => [
        'auth_activity_log' => [
            'login' => true,
            'logout' => true
        ],
    ],
    'frontend' => [
        'views_path' => 'site',
    ],
    'enabled' => [
        'permissions-management' => true,
        'users-2fa' => true,
    ],
    'permissions' => [
        'level' => \A17\Twill\Enums\PermissionLevel::LEVEL_ROLE_GROUP_ITEM,
        'modules' => ['products', 'services', 'orders', 'comments'],
    ],
    'media_library' => [
        'disk' => 'twill_media_library',
        'endpoint_type' => env('MEDIA_LIBRARY_ENDPOINT_TYPE', 'local'),
        'cascade_delete' => env('MEDIA_LIBRARY_CASCADE_DELETE', false),
        'local_path' => env('MEDIA_LIBRARY_LOCAL_PATH', 'uploads'),
        'image_service' => env('MEDIA_LIBRARY_IMAGE_SERVICE', 'A17\Twill\Services\MediaLibrary\Glide'),
        'acl' => env('MEDIA_LIBRARY_ACL', 'private'),
        'filesize_limit' => env('MEDIA_LIBRARY_FILESIZE_LIMIT', 50),
        'allowed_extensions' => ['svg', 'jpg', 'gif', 'png', 'jpeg'],
        'init_alt_text_from_filename' => true,
        'prefix_uuid_with_local_path' => config('twill.file_library.prefix_uuid_with_local_path', false),
        'translated_form_fields' => false,
        'show_file_name' => false,
        'media_caption_use_wysiwyg' => false,
        'media_caption_wysiwyg_options' => [
            'modules' => [
                'toolbar' => [
                    'bold',
                    'italic',
                ],
            ],
        ],
    ],
];
