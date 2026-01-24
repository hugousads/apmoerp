# Development Scripts

This directory contains helpful scripts for maintaining code quality and preventing common issues.

## Livewire View Validator

**File:** `validate-livewire-views.php`

Validates that all Livewire Blade views have proper root HTML tags, which is a requirement for Livewire to function correctly.

### Usage

```bash
php scripts/validate-livewire-views.php
```

### Exit Codes

- `0`: All views are valid
- `1`: One or more views have missing or invalid root tags

### What it checks

- ✅ Each Livewire view has a single root HTML element
- ✅ The root element is not self-closing
- ✅ The root element has a proper closing tag
- ✅ Views are not empty

### Example Output

**Success:**
```
Validating Livewire views in: /path/to/resources/views/livewire

Found 230 Blade files to validate

✓ All 230 Livewire views have proper root tags!
```

**Failure:**
```
Validating Livewire views in: /path/to/resources/views/livewire

Found 230 Blade files to validate

✗ Found 2 files with missing or invalid root tags:

  File: resources/views/livewire/example/component.blade.php
  Issue: Does not start with HTML tag. Starts with: @if($condition)
```

## Pre-commit Hook

**File:** `pre-commit-hook`

Optional Git pre-commit hook that runs the Livewire view validator before each commit.

### Installation

```bash
# Make it executable (if not already)
chmod +x scripts/pre-commit-hook

# Link it to your Git hooks directory
ln -s ../../scripts/pre-commit-hook .git/hooks/pre-commit
```

### Usage

Once installed, the hook will automatically run before each commit. If validation fails, the commit will be blocked.

To bypass the check temporarily:
```bash
git commit --no-verify
```

## CI/CD Integration

The Livewire view validator is automatically run in CI/CD pipelines via GitHub Actions.

See `.github/workflows/validate-livewire.yml` for the workflow configuration.

## Related Documentation

- [Livewire Root Tag Requirements](../docs/LIVEWIRE_ROOT_TAG.md) - Detailed guide on Livewire root tag requirements
- [Livewire Documentation](https://livewire.laravel.com/) - Official Livewire documentation
