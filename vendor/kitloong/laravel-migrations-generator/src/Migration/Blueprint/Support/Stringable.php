<?php

namespace KitLoong\MigrationsGenerator\Migration\Blueprint\Support;

use Illuminate\Database\Query\Expression;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use KitLoong\MigrationsGenerator\Migration\Enum\Space;

trait Stringable
{
    /**
     * Implodes lines with tab.
     *
     * @param  string[]  $lines
     * @param  int  $numberOfPrefixTab  Number of tabs to prepend to each line.
     */
    public function flattenLines(array $lines, int $numberOfPrefixTab): string
    {
        $content = '';

        foreach ($lines as $i => $line) {
            // Skip tab if the line is first line or line break.
            if ($i === 0 || $line === Space::LINE_BREAK->value) {
                $content .= $line;
                continue;
            }

            $content .= Space::LINE_BREAK->value . str_repeat(Space::TAB->value, $numberOfPrefixTab) . $line;
        }

        return $content;
    }

    /**
     * Convert $value to printable string.
     */
    public function convertFromAnyTypeToString(mixed $value): string
    {
        switch (gettype($value)) {
            case 'string':
                return "'" . $this->escapeSingleQuote($value) . "'";

            case 'integer':
            case 'double':
                return (string) $value;

            case 'boolean':
                return $value ? 'true' : 'false';

            case 'NULL':
                return 'null';

            case 'array':
                return '[' . implode(', ', $this->mapArrayItemsToString($value)) . ']';

            default:
                // Wrap with DB::raw();
                if ($value instanceof Expression) {
                    return 'DB::raw("' . $this->escapeDoubleQuote((string) DB::getQueryGrammar()->getValue($value)) . '")';
                }

                if ($value instanceof Space) {
                    return $value->value;
                }

                return (string) $value;
        }
    }

    /**
     * Escapes single quotes by adding backslash.
     */
    public function escapeSingleQuote(string $string): string
    {
        return addcslashes($string, "'");
    }

    /**
     * Escapes double quotes by adding backslash.
     */
    public function escapeDoubleQuote(string $string): string
    {
        return addcslashes($string, '"');
    }

    /**
     * Convert $list items to printable string.
     *
     * @param  mixed[]  $list
     * @return string[]
     */
    public function mapArrayItemsToString(array $list): array
    {
        return (new Collection($list))->map(fn ($v) => $this->convertFromAnyTypeToString($v))->toArray();
    }
}
