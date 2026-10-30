<?php

namespace App\Models;

use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\DayOfWeek;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Core\Validation\ValidationResult;

/**
 * One opening time range of the site, e.g. "Monday - Friday, 08:00 - 12:00".
 * A lunch break is modelled as two ranges. A range without times means "closed" on those days.
 */
class OpeningHour extends DataObject
{
    private static $db = [
        'DayFrom' => 'Enum("Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday","Monday")',
        'DayTo' => 'Enum("Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday",null)',
        'Opens' => 'Time',
        'Closes' => 'Time',
        'Note' => 'Varchar',
        'Sort' => 'Int',
    ];

    private static $has_one = [
        'SiteConfig' => SiteConfig::class,
    ];

    private static $table_name = 'OpeningHour';

    private static $default_sort = 'Sort ASC';

    private static $summary_fields = [
        'DayLabel' => 'Days',
        'TimeLabel' => 'Hours',
        'Note' => 'Note',
    ];

    private static $schema_days = [
        'Monday' => DayOfWeek::Monday,
        'Tuesday' => DayOfWeek::Tuesday,
        'Wednesday' => DayOfWeek::Wednesday,
        'Thursday' => DayOfWeek::Thursday,
        'Friday' => DayOfWeek::Friday,
        'Saturday' => DayOfWeek::Saturday,
        'Sunday' => DayOfWeek::Sunday,
    ];

    public function singular_name()
    {
        return _t(self::class . '.SINGULARNAME', 'Opening hours');
    }

    public function plural_name()
    {
        return _t(self::class . '.PLURALNAME', 'Opening hours');
    }

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['DayFrom'] = _t(self::class . '.DAYFROM', 'From');
        $labels['DayTo'] = _t(self::class . '.DAYTO', 'To');
        $labels['Opens'] = _t(self::class . '.OPENS', 'Opens');
        $labels['Closes'] = _t(self::class . '.CLOSES', 'Closes');
        $labels['Note'] = _t(self::class . '.NOTE', 'Note');
        $labels['DayLabel'] = _t(self::class . '.DAYS', 'Days');
        $labels['TimeLabel'] = _t(self::class . '.HOURS', 'Hours');

        return $labels;
    }

    /**
     * @return array<string,string> Enum value => localised day name
     */
    public static function dayOptions(): array
    {
        return self::localisedDays('cccc');
    }

    /** The time input submits 00:00:00 when left untouched, which is treated like empty */
    protected function hasTime(?string $time): bool
    {
        return $time && substr($time, 0, 5) !== '00:00';
    }

    /**
     * @return array<string,string> Enum value => localised short day name
     */
    public static function shortDayOptions(): array
    {
        return self::localisedDays('ccc');
    }

    /**
     * Day names from ICU/CLDR via the framework's date formatting, using the current i18n locale.
     *
     * @return array<string,string>
     */
    protected static function localisedDays(string $pattern): array
    {
        $date = DBDate::create();
        $days = [];
        // 2024-01-01 is a Monday
        foreach (array_keys(self::config()->get('schema_days')) as $i => $day) {
            $date->setValue(sprintf('2024-01-%02d', $i + 1));
            $days[$day] = $date->Format($pattern);
        }

        return $days;
    }

    public function isClosed(): bool
    {
        return !$this->hasTime($this->Opens) && !$this->hasTime($this->Closes);
    }

    protected function onBeforeWrite()
    {
        parent::onBeforeWrite();

        if ($this->isClosed()) {
            $this->Opens = null;
            $this->Closes = null;
        }
    }

    /**
     * Enum values of all days this range covers, e.g. Monday..Friday.
     *
     * @return string[]
     */
    public function coveredDays(): array
    {
        $days = array_keys(self::dayOptions());
        $from = array_search($this->DayFrom, $days, true);
        $to = $this->DayTo ? array_search($this->DayTo, $days, true) : $from;
        if ($from === false || $to === false || $to < $from) {
            return $from === false ? [] : [$days[$from]];
        }

        return array_slice($days, $from, $to - $from + 1);
    }

    /**
     * @param bool|string $short true for short names, or an ICU weekday pattern (e.g. "ccc" Mo, "cccc" Montag, "ccccc" M, "cccccc" Mo)
     */
    public function getDayLabel(bool|string $short = false): string
    {
        $options = match (true) {
            is_string($short) => self::localisedDays($short),
            $short => self::shortDayOptions(),
            default => self::dayOptions(),
        };
        $label = $options[$this->DayFrom] ?? '';
        if ($this->DayTo && $this->DayTo !== $this->DayFrom) {
            $label .= ' - ' . ($options[$this->DayTo] ?? '');
        }

        return $label;
    }

    /** "08:00 – 12:00", or "Closed" */
    public function getTimeRangeLabel(): string
    {
        if ($this->isClosed()) {
            return _t(self::class . '.CLOSED', 'Closed');
        }

        return $this->formatTime($this->Opens) . ' – ' . $this->formatTime($this->Closes);
    }

    public function getTimeLabel(): string
    {
        $label = $this->getTimeRangeLabel();
        if ($this->Note && !$this->isClosed()) {
            $label .= ' (' . $this->Note . ')';
        }

        return $label;
    }

    /** "08:00:00" => "08:00" */
    public function formatTime(?string $time): string
    {
        return $time ? substr($time, 0, 5) : '';
    }

    /**
     * Schema.org OpeningHoursSpecification, null for "closed" ranges (days not listed count as closed).
     */
    public function toSchema(): ?\Spatie\SchemaOrg\OpeningHoursSpecification
    {
        if ($this->isClosed() || !$this->Opens || !$this->Closes) {
            return null;
        }

        $map = $this->config()->get('schema_days');
        $days = array_values(array_filter(array_map(fn ($day) => $map[$day] ?? null, $this->coveredDays())));
        if (!$days) {
            return null;
        }

        return Schema::openingHoursSpecification()
            ->dayOfWeek($days)
            ->opens($this->formatTime($this->Opens))
            ->closes($this->formatTime($this->Closes));
    }

    public function validate(): ValidationResult
    {
        $result = parent::validate();

        $days = array_keys(self::dayOptions());
        if ($this->DayTo && array_search($this->DayTo, $days, true) < array_search($this->DayFrom, $days, true)) {
            $result->addFieldError('DayTo', _t(self::class . '.DAYVALIDATION', 'The last day must not be before the first day.'));
        }

        if ($this->isClosed()) {
            return $result;
        }

        if (!$this->Opens || !$this->Closes) {
            $result->addError(_t(self::class . '.TIMEPAIRVALIDATION', 'Please set both opening and closing time, or leave both empty for "closed".'));
        } elseif ($this->Opens === $this->Closes) {
            // Closes < Opens is allowed: closing after midnight, as schema.org's OpeningHoursSpecification does
            $result->addFieldError('Closes', _t(self::class . '.TIMEVALIDATION', 'Closing time must differ from opening time.'));
        }

        return $result;
    }
}
