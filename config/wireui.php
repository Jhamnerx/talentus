<?php

use WireUi\View\Components;

return [
    /*
        |--------------------------------------------------------------------------
        | Icons
        |--------------------------------------------------------------------------
        |
        | The icons config will be used in icon component as default
        | https://heroicons.com
        |
    */
    'icons' => [
        'style' => env('WIREUI_ICONS_STYLE', 'outline'),
    ],

    /*
        |--------------------------------------------------------------------------
        | Modal
        |--------------------------------------------------------------------------
        |
        | The default modal preferences
        |
    */
    'modal' => [
        'zIndex'   => env('WIREUI_MODAL_Z_INDEX', 'z-50'),
        'maxWidth' => env('WIREUI_MODAL_MAX_WIDTH', '2xl'),
        'spacing'  => env('WIREUI_MODAL_SPACING', 'p-4'),
        'align'    => env('WIREUI_MODAL_ALIGN', 'start'),
        'blur'     => env('WIREUI_MODAL_BLUR', false),
    ],

    /*
        |--------------------------------------------------------------------------
        | Card
        |--------------------------------------------------------------------------
        |
        | The default card preferences
        |
    */
    'card' => [
        'padding' => env('WIREUI_CARD_PADDING', 'px-2 py-5 md:px-4'),
        'shadow'  => env('WIREUI_CARD_SHADOW', 'shadow-md'),
        'rounded' => env('WIREUI_CARD_ROUNDED', 'rounded-lg'),
        'color'   => env('WIREUI_CARD_COLOR', 'bg-white dark:bg-secondary-800'),
    ],

    /*
        |--------------------------------------------------------------------------
        | Components
        |--------------------------------------------------------------------------
        |
        | List with WireUI components.
        | Change the alias to call the component with a different name.
        | Extend the component and replace your changes in this file.
        | Remove the component from this file if you don't want to use.
        |
     */
    'components' => [
        'avatar' => [
            'class' => Components\Avatar::class,
            'alias' => 'form.avatar',
        ],
        'icon' => [
            'class' => Components\Icon::class,
            'alias' => 'form.icon',
        ],
        'icon.spinner' => [
            'class' => Components\Icons\Spinner::class,
            'alias' => 'form.icon.spinner',
        ],
        'color-picker' => [
            'class' => Components\ColorPicker::class,
            'alias' => 'form.color-picker',
        ],
        'input' => [
            'class' => Components\Input::class,
            'alias' => 'form.input',
        ],
        'textarea' => [
            'class' => Components\Textarea::class,
            'alias' => 'form.textarea',
        ],
        'label' => [
            'class' => Components\Label::class,
            'alias' => 'form.label',
        ],
        'error' => [
            'class' => Components\Error::class,
            'alias' => 'form.error',
        ],
        'errors' => [
            'class' => Components\Errors::class,
            'alias' => 'form.errors',
        ],
        'inputs.maskable' => [
            'class' => Components\Inputs\MaskableInput::class,
            'alias' => 'form.inputs.maskable',
        ],
        'inputs.phone' => [
            'class' => Components\Inputs\PhoneInput::class,
            'alias' => 'form.inputs.phone',
        ],
        'inputs.currency' => [
            'class' => Components\Inputs\CurrencyInput::class,
            'alias' => 'form.inputs.currency',
        ],
        'inputs.number' => [
            'class' => Components\Inputs\NumberInput::class,
            'alias' => 'form.inputs.number',
        ],
        'inputs.password' => [
            'class' => Components\Inputs\PasswordInput::class,
            'alias' => 'form.inputs.password',
        ],
        'badge' => [
            'class' => Components\Badge::class,
            'alias' => 'form.badge',
        ],
        'badge.circle' => [
            'class' => Components\CircleBadge::class,
            'alias' => 'form.badge.circle',
        ],
        'button' => [
            'class' => Components\Button::class,
            'alias' => 'form.button',
        ],
        'button.circle' => [
            'class' => Components\CircleButton::class,
            'alias' => 'form.button.circle',
        ],
        'dropdown' => [
            'class' => Components\Dropdown::class,
            'alias' => 'form.dropdown',
        ],
        'dropdown.item' => [
            'class' => Components\Dropdown\DropdownItem::class,
            'alias' => 'form.dropdown.item',
        ],
        'dropdown.header' => [
            'class' => Components\Dropdown\DropdownHeader::class,
            'alias' => 'form.dropdown.header',
        ],
        'notifications' => [
            'class' => Components\Notifications::class,
            'alias' => 'form.notifications',
        ],
        'datetime-picker' => [
            'class' => Components\DatetimePicker::class,
            'alias' => 'form.datetime-picker',
        ],
        'time-picker' => [
            'class' => Components\TimePicker::class,
            'alias' => 'form.time-picker',
        ],
        'card' => [
            'class' => Components\Card::class,
            'alias' => 'form.card',
        ],
        'native-select' => [
            'class' => Components\NativeSelect::class,
            'alias' => 'form.native-select',
        ],
        'select' => [
            'class' => Components\Select::class,
            'alias' => 'form.select',
        ],
        'select.option' => [
            'class' => Components\Select\Option::class,
            'alias' => 'form.select.option',
        ],
        'select.user-option' => [
            'class' => Components\Select\UserOption::class,
            'alias' => 'form.select.user-option',
        ],
        'toggle' => [
            'class' => Components\Toggle::class,
            'alias' => 'form.toggle',
        ],
        'checkbox' => [
            'class' => Components\Checkbox::class,
            'alias' => 'form.checkbox',
        ],
        'radio' => [
            'class' => Components\Radio::class,
            'alias' => 'form.radio',
        ],
        'modal' => [
            'class' => Components\Modal::class,
            'alias' => 'form.modal',
        ],
        'modal.card' => [
            'class' => Components\ModalCard::class,
            'alias' => 'form.modal.card',
        ],
        'dialog' => [
            'class' => Components\Dialog::class,
            'alias' => 'form.dialog',
        ],
    ],
];
