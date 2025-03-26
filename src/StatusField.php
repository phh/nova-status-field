<?php

namespace MarcoBax\StatusField;

use BackedEnum;
use Laravel\Nova\Fields\Field;

class StatusField extends Field
{
    public $showOnCreation = false;
    public $showOnUpdate = false;

    /**
     * The field's component.
     */
    public $component = 'nova-status-field';

    /**
     * Define the icons to use for each status.
     * Accepts an array of icon => status value pairs.
     *
     * @since 2.1.0
     */
    public function icons(array $icons = null): self
    {
        return $this->withMeta(['values' => $icons]);
    }

    /**
     * Add a tooltip to the field.
     */
    public function tooltip(string|array|BackedEnum $value = null): self
    {
        return $this->withMeta([
            'tooltip' => ($value instanceof BackedEnum) ? $value->value : $value,
        ]);
    }

    /**
     * Add some extra field information on the detail view.
     */
    public function info(string|array|BackedEnum $value = null, bool $displayTooltip = false): self
    {
        return $this->withMeta([
            'info' => ($value instanceof BackedEnum) ? $value->value : $value,
            'display_tooltip' => $displayTooltip
        ]);
    }

    /**
     * Add custom color(s) to icons.
     * Accepts a single color, or an array of icon => color value pairs.
     *
     * @since 2.1.0
     */
    public function color(string|array $color = 'current'): self
    {
        return $this->withMeta(['color' => $color]);
    }

    /**
     * Define whether the icon should be solid or not.
     */
    public function solid(bool $solid = false): self
    {
        return $this->withMeta(['solid_icon' => $solid]);
    }

    /**
     * Define the icon values to use for each status.
     *
     * @deprecated since version 2.1.0. Use icons() instead.
     */
    public function values(array $values = null): self
    {
        return $this->withMeta([
            'values' => $this->iconAliases($values),
            'color' => [
                'x-circle' => 'red-500',
                'check-circle' => 'green-500',
                'clock' => 'blue-500',
                'info-circle' => 'primary-500',
                'exclamation-circle' => 'blue-700',
                'question-mark-circle' => 'primary-500',
                'minus-circle' => 'grey-500',
            ],
        ]);
    }

    /**
     * Get the icon aliases. Used by the deprecated values() method,
     * to support backwards compatibility.
     */
    private function iconAliases(array $values): array
    {
        $aliases = [
            'inactive' => 'x-circle',
            'active' => 'check-circle',
            'pending' => 'clock',
            'info' => 'info-circle',
            'warning' => 'exclamation-circle',
            'help' => 'question-mark-circle',
            'disabled' => 'minus-circle'
        ];

        $newValues = [];
        array_walk($values, function (&$value, $key) use ($aliases, &$newValues) {
            // replace old keys with new keys
            $newValues[$aliases[$key] ?? $key] = $value;
        });

        return $newValues;
    }
}
