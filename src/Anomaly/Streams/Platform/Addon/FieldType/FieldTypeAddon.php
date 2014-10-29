<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Contract\PresentableInterface;

class FieldTypeAddon extends Addon implements PresentableInterface
{
    protected $rules = [];

    protected $field = null;

    protected $value = null;

    protected $label = null;

    protected $locale = null;

    protected $readOnly = false;

    protected $placeholder = null;

    protected $instructions = null;

    protected $prefix = '';

    protected $suffix = '';

    protected $columnType = 'string';

    protected $view = 'html/partials/element';

    public function input()
    {
        $builder = app('form');

        $options = [
            'class'       => 'form-control',
            'placeholder' => $this->placeholder,
        ];

        return $builder->text($this->getFieldName(), $this->getValue(), $options);
    }

    public function filter()
    {
        return $this->input();
    }

    public function element()
    {
        $id = $this->getFieldName();

        $locale = $this->getLocale();

        $label        = trans($this->label);
        $instructions = trans($this->instructions);
        $language     = trans("language.{$locale}");

        $input = $this->input();

        $data = compact('id', 'label', 'language', 'instructions', 'input');

        return view($this->view, $data);
    }

    public function mutate($value)
    {
        return $value;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function setReadOnly($readOnly)
    {
        $this->readOnly = $readOnly;
        return $this;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    private function getLocale()
    {
        if (!$this->locale) {

            $this->locale = setting('module.settings::default_locale', 'en');

        }

        return $this->locale;
    }

    public function setPrefix($prefix = null)
    {
        if ($prefix) {

            $this->prefix = $prefix . ends_with($prefix, '-') ? : '-';

        }

        return $this;
    }

    public function setSuffix($suffix = null)
    {
        if ($suffix) {

            $this->suffix = $suffix . ends_with($suffix, '-') ? : '-';

        }

        return $this;
    }

    public function getFieldName()
    {
        return "{$this->prefix}{$this->field}{$this->suffix}";
    }

    public function getColumnName()
    {
        return $this->field;
    }

    public function getColumnType()
    {
        return $this->columnType;
    }

    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    public function decorate()
    {
        if ($presenter = app('streams.transformer')->toPresenter($this)) {

            return new $presenter($this);

        }

        return new FieldTypePresenter($this);
    }

    public function toFilter()
    {
        if ($filter = app('streams.transformer')->toFilter($this)) {

            return new $filter();

        }

        return new FieldTypeFilter($this);
    }

    protected function onAssignmentCreated(AssignmentModel $assignment)
    {
        // Run after an assignment is created.
    }

    protected function onAssignmentDeleted(AssignmentModel $assignment)
    {
        // Run after an assignment is deleted.
    }
}
