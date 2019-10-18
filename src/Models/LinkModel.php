<?php


namespace Juanparati\RDAPLib\Models;


class LinkModel
{
    public $value;
    public $rel;
    public $href;
    public $hreflang = [];
    public $title;
    public $media;
    public $type;


    /**
     * Return as link format.
     *
     * @param string|null $label
     * @param string $title
     * @return string
     */
    public function asLink()
    {
        $label = $this->title ?: $this->value;
        return '<a href="' . $this->href .'" title="' . $label . '">' . $label . '</a>';
    }
}
