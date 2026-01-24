# Livewire Root Tag Requirement

## Overview

Livewire components **must** have a single root HTML element in their Blade view files. This is a core requirement of Livewire's rendering system.

## The Problem

If a Livewire component's view file doesn't have a proper root HTML tag, you'll encounter:

```
Livewire\Exceptions\RootTagMissingFromViewException
Livewire encountered a missing root tag when trying to render a component.
When rendering a Blade view, make sure it contains a root HTML tag.
```

## Valid Examples

### ✅ Correct: Single root element

```blade
<div class="container">
    <h1>{{ $title }}</h1>
    <p>{{ $content }}</p>
</div>
```

### ✅ Correct: With Blade directives inside

```blade
<div>
    @if($showHeader)
        <header>...</header>
    @endif
    
    <main>{{ $content }}</main>
</div>
```

### ✅ Correct: With @script directive

```blade
<div class="chart-container">
    <canvas id="myChart"></canvas>
</div>

@script
// JavaScript code here
@endscript
```

## Invalid Examples

### ❌ Wrong: Multiple root elements

```blade
<div>First section</div>
<div>Second section</div>
```

### ❌ Wrong: No root element

```blade
{{ $content }}
```

### ❌ Wrong: Conditional at root level

```blade
@if($condition)
    <div>Content</div>
@endif
```

### ❌ Wrong: Loop at root level

```blade
@foreach($items as $item)
    <div>{{ $item }}</div>
@endforeach
```

## How to Fix

### Wrap conditional rendering

**Before:**
```blade
@if($condition)
    <div>Content</div>
@endif
```

**After:**
```blade
<div>
    @if($condition)
        <div>Content</div>
    @endif
</div>
```

### Wrap loops

**Before:**
```blade
@foreach($items as $item)
    <div>{{ $item }}</div>
@endforeach
```

**After:**
```blade
<div>
    @foreach($items as $item)
        <div>{{ $item }}</div>
    @endforeach
</div>
```

### Wrap multiple elements

**Before:**
```blade
<header>Header</header>
<main>Content</main>
<footer>Footer</footer>
```

**After:**
```blade
<div>
    <header>Header</header>
    <main>Content</main>
    <footer>Footer</footer>
</div>
```

## Validation

You can validate all Livewire views in your project by running:

```bash
php scripts/validate-livewire-views.php
```

This script will check all Blade files in `resources/views/livewire/` and report any missing root tags.

### Add to CI/CD

To prevent this issue in production, add the validation script to your CI/CD pipeline:

```yaml
# GitHub Actions example
- name: Validate Livewire Views
  run: php scripts/validate-livewire-views.php
```

```bash
# Pre-commit hook example
#!/bin/bash
php scripts/validate-livewire-views.php
if [ $? -ne 0 ]; then
    echo "Livewire view validation failed"
    exit 1
fi
```

## Best Practices

1. **Always use a root element**: Start with a `<div>` wrapper by default
2. **Use semantic HTML**: Choose appropriate root elements (`<article>`, `<section>`, etc.)
3. **Keep it simple**: Don't conditionally render the root element itself
4. **Validate early**: Run the validation script before committing
5. **Document exceptions**: If you have edge cases, document them clearly

## Common Scenarios

### Empty States

**Wrong:**
```blade
@if($items->count() > 0)
    <div>Items list</div>
@else
    <div>No items</div>
@endif
```

**Right:**
```blade
<div>
    @if($items->count() > 0)
        <!-- Items list -->
    @else
        <p>No items</p>
    @endif
</div>
```

### Modal Components

```blade
<div x-data="{ open: @entangle('showModal') }">
    <div x-show="open" class="modal">
        <!-- Modal content -->
    </div>
</div>
```

### Dynamic Components

```blade
<div>
    @if($componentType === 'table')
        <livewire:data-table :data="$data" />
    @else
        <livewire:data-grid :data="$data" />
    @endif
</div>
```

## Debugging Tips

If you encounter this error in production:

1. Check Laravel logs for the specific component class
2. Look for conditional rendering at the root level
3. Verify all Blade includes have root tags
4. Check for dynamic content that might be empty
5. Run the validation script locally

## Additional Resources

- [Livewire Documentation](https://livewire.laravel.com/)
- [Laravel Blade Documentation](https://laravel.com/docs/blade)
