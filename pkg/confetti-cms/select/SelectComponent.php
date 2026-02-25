<?php /** @noinspection DuplicatedCode */

declare(strict_types=1);

namespace ConfettiCms\Select;

use ConfettiCms\Foundation\Helpers\ComponentStandard;

class SelectComponent extends ComponentStandard
{
    public function type(): string
    {
        return 'select';
    }

    public function get(bool $useDefault = false): ?string
    {
        // Get saved value
        $content = $this->contentStore->findOneData($this->parentContentId, $this->relativeContentId);
        if ($content !== null) {
            return (string)$content;
        }

        $component = $this->getComponent();
        $default = $component->getDecoration('default', 'default');
        if ($default !== null) {
            return $default;
        }

        $options = $component->getDecoration('options', 'options');
        if (empty($options)) {
            return null;
        }

        $required = $component->getDecoration('required', 'required');
        if ($required) {
            return $options[array_key_first($options)]['id'];
        }

        if (!$this->contentStore->canFake()) {
            return null;
        }

        // Get random value from all options
        $key = array_rand($options, 1);
        return $options[$key]['id'];
    }

    // Returns the full path from the root to a blade file.
    // This represents the input field in the admin panel.
    public function getViewAdminInput(): string
    {
        return  __DIR__ . '/input.blade.php';
    }

    // Returns the full path from the root to a preview file.
    // This represents the preview of the input field in the admin panel.
    public static function getViewAdminPreview(): string
    {
        return getPkgDir() . '/public/preview.mjs';
    }

    /**
     * Without saved value, this will be the default.
     */
    public function default(string $default): self
    {
        $this->setDecoration(__FUNCTION__, get_defined_vars());
        return $this;
    }

    /**
     * Label is used as a field title in the admin panel.
     */
    public function label(string $label): self
    {
        $this->setDecoration(__FUNCTION__, get_defined_vars());
        return $this;
    }

    /**
     * List of options. For now, only values are supported.
     */
    public function options(array $options): self
    {
        $this->setDecoration(__FUNCTION__, get_defined_vars());
        return $this;
    }

    /**
     * The user can't select the `Nothing selected` option.
     */
    public function required(): self
    {
        $this->setDecoration(__FUNCTION__, true);
        return $this;
    }
}



