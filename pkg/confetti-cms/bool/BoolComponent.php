<?php /** @noinspection DuplicatedCode */

declare(strict_types=1);

namespace ConfettiCms\Bool;

use ConfettiCms\Foundation\Helpers\ComponentStandard;

class BoolComponent extends ComponentStandard
{
    public function type(): string
    {
        return 'bool';
    }

    public function get(bool $useDefault = false): ?bool
    {
        // Get saved value
        $value = $this->contentStore->findOneData($this->parentContentId, $this->relativeContentId);
        if ($value !== null) {
            // From sqlite, the value is an int. So we want to cast it to a bool.
            // Value can be other types than an int, like a string from a previous/other type.
            // So that is the reason for the strict comparison.
            return $value === 1;
        }

        $default = $this->getComponent()->getDecoration('default', 'default');
        if ($default !== null) {
            return $default;
        }

        if ($this->contentStore->canFake()) {
            return $this->random();
        }

        return null;
    }

    // Returns the full path from the root to a blade file.
    // This represents the input field in the admin panel.
    public function getViewAdminInput(): string
    {
        return  __DIR__ . '/admin/input.blade.php';
    }

    // Returns the full path from the root to a preview file.
    // This represents the preview of the input field in the admin panel.
    public static function getViewAdminPreview(): string
    {
        return __DIR__ . '/admin/preview.mjs';
    }

    // Label is used as a title for the admin panel
    public function label(string $label): self
    {
        $this->setDecoration(__FUNCTION__, get_defined_vars());
        return $this;
    }

    // Labels on/off are used for a boolean field
    public function labelsOnOff(string $on, string $off): self
    {
        $this->setDecoration(__FUNCTION__, get_defined_vars());
        return $this;
    }

    // Help is used as a description for the admin panel
    public function help(string $help): self
    {
        $this->setDecoration(__FUNCTION__, get_defined_vars());
        return $this;
    }

    // Default value is used when the user hasn't saved any value
    public function default(bool $default): self
    {
        $this->setDecoration(__FUNCTION__, get_defined_vars());
        return $this;
    }

    private function random(): bool
    {
        return (bool)random_int(0, 1);
    }
}
