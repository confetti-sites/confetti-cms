<?php /** @noinspection DuplicatedCode */

declare(strict_types=1);

namespace ConfettiCms\Hidden;

use ConfettiCms\Foundation\Helpers\ComponentStandard;

class HiddenComponent extends ComponentStandard
{
    public function type(): string
    {
        return 'hidden';
    }

    public function get(bool $useDefault = false): ?string
    {
        if ($this->contentStore === null) {
            throw new \RuntimeException('This component is only used as a reference. Therefore, you can\'t call __toString() or get().');
        }
        // Get saved value
        $content = $this->contentStore->findOneData($this->parentContentId, $this->relativeContentId);
        if ($content == null) {
            return null;
        }
        return (string) $content;
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
        return __DIR__ . '/public/preview.mjs';
    }

    /**
     * The Label is used as a title for the admin panel
     */
    public function label(string $label): self
    {
        $this->setDecoration(__FUNCTION__, get_defined_vars());
        return $this;
    }

    /**
     * The default value will be used if no value is saved
     */
    public function default(string $default): self
    {
        $this->setDecoration(__FUNCTION__, get_defined_vars());
        return $this;
    }
}





