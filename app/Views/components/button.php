<?php
/**
 * Button Component
 * 
 * Usage:
 * require_once __DIR__ . '/../components/button.php';
 * renderButton([
 *     'text' => 'Click Me',
 *     'type' => 'button',
 *     'onClick' => 'myFunction()',
 *     'additionalClasses' => 'w-full mt-4'
 * ]);
 */

function renderButton($options = []) {
    $text = $options['text'] ?? 'Button';
    $type = $options['type'] ?? 'button';
    $onClick = $options['onClick'] ?? '';
    $additionalClasses = $options['additionalClasses'] ?? '';
    
    $onClickAttribute = $onClick ? "onclick=\"$onClick\"" : '';
    
    echo <<<HTML
    <button 
        type="$type" 
        class="inline-block py-2.5 px-5 border border-blue-500 rounded-md bg-blue-500 text-white text-center cursor-pointer shadow-sm transition-all hover:bg-blue-600 hover:border-blue-600 $additionalClasses"
        $onClickAttribute
    >
        $text
    </button>
    HTML;
}