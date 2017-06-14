<?php
defined('SYSPATH') OR die('No direct script access.');

return array(
    'admintags' => array(
        'general_settings' => array (
            'tag' => 'general settings|themes',
            'title' => 'General Settings',
            'description' => 'General Settings',
            'edit' => App::helper('url')->getUrl('admin/settings/general'),
            'task' => 'admin/settings/general'
        ),
        'logo' => array(
            'tag' => 'logo',
            'title' => 'General Settings',
            'description' => 'General Settings',
            'edit' => App::helper('url')->getUrl('admin/settings/general')."#ADMIN_LOGO",
            'task' => 'admin/settings/general'
        ),
        'email_settings' => array (
            'tag' => 'smtp|email configuration|ssl security',
            'title' => 'Email Settings',
            'description' => 'Email SMTP Settings',
            'edit' => App::helper('url')->getUrl('admin/settings/email'),'task' => 'admin/settings/email'
        ),
        'email_template' => array (
            'tag' => 'template|email template|template settings',
            'title' => 'Email Template',
            'description' => 'Email Template Settings',
            'edit' => App::helper('url')->getUrl('admin/template/email'),'task' => 'admin/template/email'
        ),
        'currency_settings' => array (
            'tag' => 'currency|currency settings',
            'title' => 'Settings',
            'description' => 'Currency Settings',
            'edit' => App::helper('url')->getUrl('admin/settings/currency_settings'),'task' => 'admin/settings/currency_settings'
        ),
        'default_currency' => array (
            'tag' => 'currency|default currency',
            'title' => 'Default Currency Settings',
            'description' => 'Default Currency Settings',
            'edit' => App::helper('url')->getUrl('admin/settings/general')."#DEFAULT_CURRENCY",'task' => 'admin/settings/general'
        ),
        'user_notification_settings' => array (
            'tag' => 'user notification | notification |notification settings',
            'title' => 'User Notification Settings',
            'description' => 'User Notification Settings',
            'edit' => App::helper('url')->getUrl('admin/settings/general')."#SYSTEM_NOTIFICATION",'task' => 'admin/settings/general'
        ),
        'attribute_settings' => array (
            'tag' => 'attributes|custom field',
            'title' => 'Settings',
            'description' => 'Attributes',
            'edit' => App::helper('url')->getUrl('admin/settings_attributes/index'),'task' => 'admin/settings_attributes/index'
        ),
        'directory_country' => array (
            'tag' => 'directory|country',
            'title' => 'Directory',
            'description' => 'Manage Country',
            'edit' => App::helper('url')->getUrl('admin/directory_country/index'),'task' => 'admin/directory_country/index'
        ),
        'directory_state' => array (
            'tag' => 'directory|state|state edit',
            'title' => 'State Edit',
            'description' => 'Manage State',
            'edit' => App::helper('url')->getUrl('admin/directory_state/index'),'task' => 'admin/directory_state/index'
        ),
        'directory_city' => array (
            'tag' => 'directory|city|city edit',
            'title' => 'City Edit',
            'description' => 'Manage City',
            'edit' => App::helper('url')->getUrl('admin/directory_city/index'),'task' => 'admin/directory_city/index'
        ),
        'email_template' => array (
            'tag' => 'email template|template|email',
            'title' => 'Email Template',
            'description' => 'Email Template Management',
            'edit' => App::helper('url')->getUrl('admin/template/email'),
            'task' => 'admin/template/email'
        ), 
        'roles' => array (
            'tag' => 'roles|permission|role|tasks',
            'title' => 'Roles',
            'description' => 'Roles Management',
            'edit' => App::helper('url')->getUrl('admin/system_permission_roles/index'),
            'task' => 'admin/system_permission_roles/index'
        ),
        'roles_users' => array (
            'tag' => 'roles|permission|role|tasks|users',
            'title' => 'Roles Users',
            'description' => 'Roles Users Management',
            'edit' => App::helper('url')->getUrl('admin/system_permission_users/index'),
            'task' => 'admin/system_permission_users/index'
        ),
        'place_category' => array (
            'tag' => 'category|place category|place sub category',
            'title' => 'Place  Category',
            'description' => 'Place  Category Management',
            'edit' => App::helper('url')->getUrl('admin/category/categories'),
            'task' => 'admin/category/categories'
        ), 
        'groups' => array (
            'tag' => 'group |groups |user groups',
            'title' => 'Users',
            'description' => 'User Groups',
            'edit' => App::helper('url')->getUrl('admin/groups/index'),
            'task' => 'admin/groups/index'
        ),
        'profession' => array (
            'tag' => 'profession|user profession',
            'title' => 'User Profession',
            'description' => 'User Profession',
            'edit' => App::helper('url')->getUrl('admin/profession/index'),
            'task' => 'admin/profession/index'
        ),
        'subjects' => array (
            'tag' => 'places subjects|subjects',
            'title' => 'Places',
            'description' => 'Subjects',
            'edit' => App::helper('url')->getUrl('admin/subjects/index'),
            'task' => 'admin/subjects/index'
        ),
        'community' => array (
            'tag' => 'user community|community',
            'title' => 'Users',
            'description' => 'Community',
            'edit' => App::helper('url')->getUrl('admin/religious_community/index'),
            'task' => 'admin/religious_community/index'
        ),
        'store_roles' => array (
            'tag' => 'roles|store roles|sub store roles',
            'title' => 'Store Roles',
            'description' => 'Store Roles',
            'edit' => App::helper('url')->getUrl('admin/system_permission_roles/storeroles'),
            'task' => 'admin/system_permission_roles/storeroles'
        ),
        'store_roles_users' => array (
            'tag' => 'roles users|store roles users|sub store roles users',
            'title' => 'Store Role users',
            'description' => 'Store Role users',
            'edit' => App::helper('url')->getUrl('admin/system_permission_users/storeroleusers'),
            'task' => 'admin/system_permission_users/storeroleusers'
        ),
        'create_product_directory' => array (
            'tag' => 'product directory',
            'title' => 'Product Directory',
            'description' => 'Create a new product directory',
            'edit' => App::helper('url')->getUrl('admin/products/index'),
            'task' => 'admin/products/index'
        ),
         'tax' => array (
            'tag' => 'tax',
            'title' => 'Tax',
            'description' => 'add tax settings',
            'edit' => App::helper('url')->getUrl('admin/products_tax/index'),
            'task' => 'admin/products_tax/index'
        ),
        'tax_rule' => array (
            'tag' => 'tax rule',
            'title' => 'Tax Rule',
            'description' => 'Tax Rules',
            'edit' => App::helper('url')->getUrl('admin/products_taxrule/index'),
            'task' => 'admin/products_taxrule/index'
        ),
        'adverts' => array (
            'tag' => 'adverts|advertisement|add adverts',
            'title' => 'Advertisement',
            'description' => 'Advertisement',
            'edit' => App::helper('url')->getUrl('admin/adverts/advert'),
            'task' => 'admin/adverts/advert'
        ),
        'domain_managemant' => array (
            'tag' => 'domain|domain managemant|website domain',
            'title' => 'Domain Managemant',
            'description' => 'Domain Managemant',
            'edit' => App::helper('url')->getUrl('domain/list/website'),
            'task' => 'domain/list/website'
        ),
        'url_rewrite_managemant' => array (
            'tag' => 'url|url rewrite|url rewrite management',
            'title' => 'Url Rewrite Managemant',
            'description' => 'Url Rewrite Managemant',
            'edit' => App::helper('url')->getUrl('domain/list/urlrewrite'),
            'task' => 'domain/list/urlrewrite'
        ),
        'product_settings' => array (
            'tag' => 'settings|product settings',
            'title' => 'Settings',
            'description' => 'Product settings',
            'edit' => App::helper('url')->getUrl('admin/settings/product'),
            'task' => 'admin/settings/product'
        ),
        'question_ratings_settings' => array (
            'tag' => 'settings|question ratings settings',
            'title' => 'Question Ratings settings',
            'description' => 'Question Ratings settings',
            'edit' => App::helper('url')->getUrl('admin/question_ratings/index'),
            'task' => 'admin/question_ratings/ratings'
        ),
        'question_reference_settings' => array (
            'tag' => 'settings|question reference settings',
            'title' => 'Question Reference settings',
            'description' => 'Question Reference settings',
            'edit' => App::helper('url')->getUrl('admin/question_reference/index'),
            'task' => 'admin/question_reference/ratings'
        ),
        'product_ratings_reviews_settings' => array (
            'tag' => 'settings|product ratings & reviews settings',
            'title' => 'Product Ratings & Reviews settings',
            'description' => 'Product Ratings & Reviews settings',
            'edit' => App::helper('url')->getUrl('admin/rating_product/index'),
            'task' => 'admin/rating_product/ratings'
        ),
        'service_ratings_reviews_settings' => array (
            'tag' => 'settings|service ratings & reviews settings',
            'title' => 'Service Ratings & Reviews settings',
            'description' => 'Service Ratings & Reviews settings',
            'edit' => App::helper('url')->getUrl('admin/rating_service/index'),
            'task' => 'admin/rating_service/ratings'
        ),
        'place_ratings_reviews_settings' => array (
            'tag' => 'settings|place ratings & reviews settings',
            'title' => 'Place Ratings & Reviews settings',
            'description' => 'Place Ratings & Reviews settings',
            'edit' => App::helper('url')->getUrl('admin/rating_place/index'),
            'task' => 'admin/rating_place/ratings'
        ),
        'people_ratings_reviews_settings' => array (
            'tag' => 'settings|people ratings & reviews settings',
            'title' => 'People Ratings & Reviews settings',
            'description' => 'People Ratings & Reviews settings',
            'edit' => App::helper('url')->getUrl('admin/rating_people/index'),
            'task' => 'admin/rating_people/ratings'
        ),
        'places_company' => array (
            'tag' => 'company|places company',
            'title' => 'Places',
            'description' => 'Company',
            'edit' => App::helper('url')->getUrl('admin/company/index'),
            'task' => 'admin/company/index'
        ),
        'places_store' => array (
            'tag' => 'store|places store',
            'title' => 'Places',
            'description' => 'Store',
            'edit' => App::helper('url')->getUrl('admin/store/index'),
            'task' => 'admin/store/index'
        ),
        'places_education' => array (
            'tag' => 'education|places education',
            'title' => 'Places',
            'description' => 'Education',
            'edit' => App::helper('url')->getUrl('admin/education/index'),
            'task' => 'admin/education/index'
        ),
        'places_religious' => array (
            'tag' => 'religious|places religious',
            'title' => 'Places',
            'description' => 'Religious',
            'edit' => App::helper('url')->getUrl('admin/religious_religious/index'),
            'task' => 'admin/religious_religious/index'
        ),
        'places_healthcare' => array (
            'tag' => 'healthcare|places healthcare',
            'title' => 'Places',
            'description' => 'Healthcare',
            'edit' => App::helper('url')->getUrl('admin/healthcare/index'),
            'task' => 'admin/healthcare/index'
        ),
        'places_garden' => array (
            'tag' => 'garden|places garden',
            'title' => 'Places',
            'description' => 'Garden',
            'edit' => App::helper('url')->getUrl('admin/garden_garden/index'),
            'task' => 'admin/garden_garden/index'
        ),
        'places_parking' => array (
            'tag' => 'parking|places parking',
            'title' => 'Places',
            'description' => 'Parking',
            'edit' => App::helper('url')->getUrl('admin/parking/index'),
            'task' => 'admin/parking/index'
        ),
        /*'places_add_place_factsheet' => array (
            'tag' => 'add place factsheet|factsheet',
            'title' => 'Places',
            'description' => 'Add Place Factsheet',
            'edit' => App::helper('url')->getUrl('admin/factsheet/index'),
            'task' => 'admin/factsheet/index'
        ),*/
        'users_manage_user' => array (
            'tag' => 'users manage user|manage user',
            'title' => 'Users',
            'description' => 'Manage User',
            'edit' => App::helper('url')->getUrl('admin/users/index'),
            'task' => 'admin/users/index'
        ),
        'users_requirements' => array (
            'tag' => 'users requirements|requirements',
            'title' => 'Users',
            'description' => 'Requirements',
            'edit' => App::helper('url')->getUrl('admin/requirements/index'),
            'task' => 'admin/requirements/index'
        ),
        'settings_user_email_template' => array (
            'tag' => 'user email templates|settings user email',
            'title' => 'Settings',
            'description' => 'User Email Templates',
            'edit' => App::helper('url')->getUrl('admin/settings/users_templates'),
            'task' => 'admin/settings/users_templates'
        ),
        'settings_user_settings' => array (
            'tag' => 'user settings|settings',
            'title' => 'Settings',
            'description' => 'User Settings',
            'edit' => App::helper('url')->getUrl('admin/settings/users_settings'),
            'task' => 'admin/settings/users_settings'
        ),
        'settings_email' => array (
            'tag' => 'email|settings email',
            'title' => 'Settings',
            'description' => 'Email',
            'edit' => App::helper('url')->getUrl('admin/settings/email'),
            'task' => 'admin/settings/email'
        ),
        'settings_notification_subject' => array (
            'tag' => 'notification subject|settings notification subject',
            'title' => 'Settings',
            'description' => 'Notification Subject',
            'edit' => App::helper('url')->getUrl('admin/settings/email_subject'),
            'task' => 'admin/settings/email_subject'
        ),
        'settings_notification_template' => array (
            'tag' => 'notification template|settings notification template',
            'title' => 'Settings',
            'description' => 'Notification Template',
            'edit' => App::helper('url')->getUrl('admin/template/email'),
            'task' => 'admin/template/email'
        ),
        'settings_social_media' => array (
            'tag' => 'social media|settings social media',
            'title' => 'Settings',
            'description' => 'Social Media',
            'edit' => App::helper('url')->getUrl('admin/settings/social_media'),
            'task' => 'admin/settings/social_media'
        ),
        'settings_language_settings' => array (
            'tag' => 'language settings',
            'title' => 'Settings',
            'description' => 'Language Settings',
            'edit' => App::helper('url')->getUrl('admin/settings/language_settings'),
            'task' => 'admin/settings/language_settings'
        ),
        'settings_banner_settings' => array (
            'tag' => 'banner settings|images',
            'title' => 'Settings',
            'description' => 'Banner Settings',
            'edit' => App::helper('url')->getUrl('admin/settings/banner_settings'),
            'task' => 'admin/settings/banner_settings'
        ),
        'product_services_product_directory' => array (
            'tag' => 'product directory|add product|edit product',
            'title' => 'Product & Services',
            'description' => 'Product Directory',
            'edit' => App::helper('url')->getUrl('admin/products/index'),
            'task' => 'admin/products/index'
        ),
        'product_services_services_directory' => array (
            'tag' => 'services directory|add services|edit services',
            'title' => 'Product & Services',
            'description' => 'Services Directory',
            'edit' => App::helper('url')->getUrl('admin/services/index'),
            'task' => 'admin/services/index'
        ),
        'product_services_place_products' => array (
            'tag' => 'place products',
            'title' => 'Product & Services',
            'description' => 'Place Products',
            'edit' => App::helper('url')->getUrl('admin/products/priceindex'),
            'task' => 'admin/products/priceindex'
        ),
        'product_services_category' => array (
            'tag' => 'category|product category',
            'title' => 'Product & Services',
            'description' => 'Category',
            'edit' => App::helper('url')->getUrl('admin/products_category/categories'),
            'task' => 'admin/products_category/categories'
        ),
        'product_services_filter' => array (
            'tag' => 'filter by|product filter',
            'title' => 'Product & Services',
            'description' => 'Filter',
            'edit' => App::helper('url')->getUrl('admin/products_filters/index'),
            'task' => 'admin/products_filters/index'
        ),
        'product_services_brand' => array (
            'tag' => 'brand|product brand',
            'title' => 'Product & Services',
            'description' => 'Brand',
            'edit' => App::helper('url')->getUrl('admin/products_brand/index'),
            'task' => 'admin/products_brand/index'
        ),
        'product_services_attributes' => array (
            'tag' => 'attributes|product attributes',
            'title' => 'Product & Services',
            'description' => 'Attributes',
            'edit' => App::helper('url')->getUrl('admin/products_attributes/index'),
            'task' => 'admin/products_attributes/index'
        ),
        'product_services_search' => array (
            'tag' => 'search|product search',
            'title' => 'Product & Services',
            'description' => 'Search',
            'edit' => App::helper('url')->getUrl('admin/products_search/index'),
            'task' => 'admin/products_search/index'
        ),
        'property_property' => array (
            'tag' => 'property',
            'title' => 'Property',
            'description' => 'Property',
            'edit' => App::helper('url')->getUrl('admin/property_property/index'),
            'task' => 'admin/property_property/index'
        ),
        'property_property_category' => array (
            'tag' => 'property category|category',
            'title' => 'Property',
            'description' => 'Property Category',
            'edit' => App::helper('url')->getUrl('admin/property_category/index'),
            'task' => 'admin/property_category/index'
        ),
        'property_property_subcategory' => array (
            'tag' => 'property sub category|sub category',
            'title' => 'Property',
            'description' => 'Property Sub Category',
            'edit' => App::helper('url')->getUrl('admin/property_subcategory/index'),
            'task' => 'admin/property_subcategory/index'
        ),
        'property_floor_type' => array (
            'tag' => 'floor type|type',
            'title' => 'Property',
            'description' => 'Floor Type',
            'edit' => App::helper('url')->getUrl('admin/property_floor/index'),
            'task' => 'admin/property_floor/index'
        ),
        'property_floor_usage' => array (
            'tag' => 'floor usage|usage',
            'title' => 'Property',
            'description' => 'Floor Usage',
            'edit' => App::helper('url')->getUrl('admin/property_usage/index'),
            'task' => 'admin/property_usage/index'
        ),
        'feature' => array (
            'tag' => 'feature|add feature',
            'title' => 'Property',
            'description' => 'Feature',
            'edit' => App::helper('url')->getUrl('admin/property_feature/index'),
            'task' => 'admin/property_feature/index'
        ),
        'sent_messages' => array (
            'tag' => 'messages|sent messages',
            'title' => 'Messages',
            'description' => 'Sent Messages',
            'edit' => App::helper('url')->getUrl('admin/system/sendmessages'),
            'task' => 'admin/system/sendmessages'
        ),
        'cms_page' => array (
            'tag' => 'pages|cms pages',
            'title' => 'CMS',
            'description' => 'Pages',
            'edit' => App::helper('url')->getUrl('admin/cms_cms/load'),
            'task' => 'admin/cms_cms/load'
        ),
        'cms_block' => array (
            'tag' => 'blocks|cms blocks',
            'title' => 'CMS',
            'description' => 'Blocks',
            'edit' => App::helper('url')->getUrl('admin/cms_block/load'),
            'task' => 'admin/cms_block/load'
        ),
        'peoples_manage' => array (
            'tag' => 'peoples|add peoples',
            'title' => 'Products & Services',
            'description' => 'Peoples',
            'edit' => App::helper('url')->getUrl('admin/peoples/index'),
            'task' => 'admin/peoples/index'
        ),
        'webservices_api' => array (
            'tag' => 'webservices|web services|api',
            'title' => 'Webservice',
            'description' => 'Api',
            'edit' => App::helper('url')->getUrl('admin/system_webservice/index'),
            'task' => 'admin/system_webservice/index'
        ),
    ), 
);
