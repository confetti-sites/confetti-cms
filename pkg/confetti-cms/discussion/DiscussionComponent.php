<?php /** @noinspection DuplicatedCode */

declare(strict_types=1);

namespace ConfettiCms\Discussion;

use ConfettiCms\Foundation\Helpers\ComponentStandard;

class DiscussionComponent extends ComponentStandard
{
    public function type(): string
    {
        return 'discussion';
    }

    public function get(bool $useDefault = false): ?array
    {
        // Get saved value
        $value = $this->contentStore->findOneData($this->parentContentId, $this->relativeContentId);
        if ($value !== null) {
            try {
                return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                throw new \RuntimeException('Invalid JSON in content. JSON: ' . $content);
            }
        }

        if (!$this->contentStore->canFake()) {
            return null;
        }

        // Generate random GitHub discussion with HTML body
        return [
            'url' => 'https://github.com/confetti-cms/community/discussions/1',
            'discussion' => [
                'body' => '<p>Discussion body</p>',
                'title' => 'Discussion title',
            ],
        ];
    }

    public function getHtml(): string
    {
        $value = $this->get();
        if (empty($value['discussion']) || empty($value['discussion']['body'])) {
            return '';
        }
        $content = $value['discussion']['body'];
        $content = preg_replace('/<hr\>.*/s', '', $content);
        return '<discussion>' . $content . '</discussion>';
    }

    /**
     * Get the title of the GitHub discussion.
     */
    public function getTitle(): ?string
    {
        $value = $this->get();
        if (empty($value['discussion']) || empty($value['discussion']['title'])) {
            return null;
        }
        return $value['discussion']['title'];
    }

    public function getUrl(): string
    {
        $value = $this->get();
        if (empty($value['url'])) {
            return 'Url missing';
        }
        return $value['url'];
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

    // Help is used as a description for the admin panel
    public function help(string $help): self
    {
        $this->setDecoration(__FUNCTION__, get_defined_vars());
        return $this;
    }

    // Label is used as a title for the admin panel
    public function label(string $label): self
    {
        $this->setDecoration(__FUNCTION__, get_defined_vars());
        return $this;
    }
}



