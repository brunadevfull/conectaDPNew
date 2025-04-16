<?php
/**
 * Input Component
 * 
 * Usage:
 * require_once __DIR__ . '/../components/input.php';
 * renderInput([
 *     'name' => 'username',
 *     'type' => 'text',
 *     'placeholder' => 'Username',
 *     'icon' => 'fas fa-user',
 *     'required' => true,
 *     'additionalClasses' => ''
 * ]);
 */

function renderInput($options = []) {
    $name = $options['name'] ?? '';
    $type = $options['type'] ?? 'text';
    $placeholder = $options['placeholder'] ?? '';
    $icon = $options['icon'] ?? '';
    $required = isset($options['required']) && $options['required'] ? 'required' : '';
    $additionalClasses = $options['additionalClasses'] ?? '';
    
    echo <<<HTML
    <div class="input-group $additionalClasses">
        {$icon ? "<i class=\"$icon absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500\"></i>" : ""}
        <input 
            type="$type" 
            name="$name" 
            id="$name" 
            placeholder="$placeholder" 
            class="form-input {$icon ? 'pl-10' : ''}" 
            $required
        >
    </div>
    HTML;
}