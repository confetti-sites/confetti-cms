<?php /** @noinspection DuplicatedCode */

declare(strict_types=1);

namespace App\Components;

use Confetti\Foundation\Helpers\ComponentStandard;

class TallyComponent extends ComponentStandard
{
    public function type(): string
    {
        return 'tally';
    }

    public function get(bool $useDefault = false): ?array
    {
        // Get saved value
        $value = $this->contentStore->findOneData($this->parentContentId, $this->relativeContentId);
        if ($value !== null) {
            return json_decode($value, true);
        }

        return null;
    }

    public function getTitle(): ?string
    {
        return $this->get()['title'] ?? null;
    }

    public function embed(): ?string
    {
        $sharedLink = $this->get()['share_link'] ?? null;
        if (!$sharedLink) {
            return null;
        }

        // Convert shared URL (https://tally.so/r/wQ8LDZ) to embed URL (https://tally.so/embed/wQ8LDZ)
        $embedUrl = str_replace('/r/', '/embed/', $sharedLink);

        $embedUrl.='?dynamicHeight=1';
        if (!$this->getComponent()->getDecoration('withTitle')) {
            $embedUrl.='&hideTitle=1';
        }
        if (!$this->getComponent()->getDecoration('withPadding')) {
            $embedUrl.='&alignLeft=1';
        }
        if (!$this->getComponent()->getDecoration('withBackground')) {
            $embedUrl.='&transparentBackground=1';
        }

        return '
        <iframe data-tally-src="' . $embedUrl . '" loading="lazy" width="100%" height="177" frameborder="0" marginheight="0" marginwidth="0"></iframe>
        <script>let d=document,w="https://tally.so/widgets/embed.js",v=function(){"undefined"!=typeof Tally?Tally.loadEmbeds():d.querySelectorAll("iframe[data-tally-src]:not([src])").forEach((function(e){e.src=e.dataset.tallySrc}))};if("undefined"!=typeof Tally)v();else if(d.querySelector(\'script[src="\'+w+\'"]\')==null){var s=d.createElement("script");s.src=w,s.onload=v,s.onerror=v,d.body.appendChild(s);}</script>';
    }

    /**
     * The return value is a full path from the root to a blade file.
     */
    public function getViewAdminInput(): string
    {
        return 'admin.components.tally.input';
    }

    /**
     * The return value is a full path from the root to a mjs file.
     */
    public static function getViewAdminPreview(): string
    {
        return '/admin/components/tally/preview.mjs';
    }

    // Label is used as a title for the admin panel
    public function label(string $label): self
    {
        $this->setDecoration(__FUNCTION__, get_defined_vars());
        return $this;
    }

    // Required this field
    public function required(): self
    {
        $this->setDecoration(__FUNCTION__, [__FUNCTION__ => true]);
        return $this;
    }

    // Hide form title
    public function withTitle(): self
    {
        $this->setDecoration(__FUNCTION__, [__FUNCTION__ => true]);
        return $this;
    }

    // Give the form extra padding. In Tally's admin panel known as "Align content to the left"
    public function withPadding(): self
    {
        $this->setDecoration(__FUNCTION__, [__FUNCTION__ => true]);
        return $this;
    }

    // With background. In Tally's admin panel known as "Transparent background"
    public function withBackground(): self
    {
        $this->setDecoration(__FUNCTION__, [__FUNCTION__ => true]);
        return $this;
    }
}



