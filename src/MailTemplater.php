<?php

namespace Modules\Opx\MailTemplater;

use Core\Facades\Site;
use Core\Foundation\Module\BaseModule;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class MailTemplater extends BaseModule
{
    /** @var string  Module name */
    protected $name = 'opx_mail_templater';

    /** @var string  Module path */
    protected $path = __DIR__;

    /**
     * Make mail template.
     *
     * @param  string|array $content
     * @param  string $template
     *
     * @return  string
     */
    public function make($content, $template = 'default'): string
    {
        if (is_array($content)) {
            $content = implode('', $content);
        }

        $html = $this->view($template)->with(['content' => $content]);

        $css = $this->getStyles();

        if ($css) {
            return $this->compileInlineCss($html, $css);
        }

        return $html;
    }

    /**
     * Get content of style file.
     *
     * @return  string|null
     */
    protected function getStyles(): ?string
    {
        $config = $this->config(Site::profile());

        $fileName = $config['styles'] ? $this->path('Assets' . DIRECTORY_SEPARATOR . $config['styles']) : null;

        if ($fileName === null || !file_exists($fileName)) {
            return null;
        }

        return file_get_contents($fileName);
    }

    /**
     * Compile inline styles.
     *
     * @param  string $html
     * @param  string $css
     *
     * @return  string
     */
    protected function compileInlineCss($html, $css): string
    {
        $compiler = new CssToInlineStyles();

        return $compiler->convert($html, $css);
    }

    /**
     * Make paragraph.
     *
     * @param  string|array $text
     * @param  null|string|array $classes
     *
     * @return  string
     */
    public function paragraph($text, $classes = null): string
    {
        if(is_array($text)) {
            $res = '';
            foreach ($text as $class => $span) {
                if(!is_numeric($class)) {
                    $res .= "<span class=\"{$class}\">{$span}</span> ";
                } else {
                    $res .= "<span>{$span}</span> ";
                }
            }

            $text = trim($res);
        }

        return "<p class=\"{$this->mergeClasses('paragraph', $classes)}\">{$text}</p>";
    }

    /**
     * Make header
     *
     * @param  string $text
     * @param  int $level
     * @param  null|string|array $classes
     *
     * @return  string
     */
    public function title($text, $level = 1, $classes = null):string
    {
        return "<h{$level} class=\"{$this->mergeClasses('title', $classes)}\">{$text}</h{$level}>";
    }

    /**
     * Make anchor.
     *
     * @param  string $text
     * @param  string $link
     * @param  bool $newWindow
     * @param  null|string|array $classes
     *
     * @return string
     */
    public function anchor($text, $link, $newWindow = true, $classes = null):string
    {
        return "<a href=\"{$link}\" class=\"{$this->mergeClasses('anchor', $classes)}\"".($newWindow ? ' target="_blank"' : '').">{$text}</a>";
    }

    /**
     * Merge classes.
     *
     * @param  string $class
     * @param  string|array|null $classes
     *
     * @return  string
     */
    protected function mergeClasses($class, $classes): string
    {
        if(is_string($classes)) {
            $class .= ' '.$classes;
        }

        if (is_array($classes)) {
            $class .= ' ' . implode(' ', $classes);
        }

        return $class;
    }

    /**
     * Make table.
     *
     * @param  array|null $headers
     * @param  array $table
     *
     * @return  string
     */
    public function table(array $table, array $headers = []): string
    {
        $result = '<table class="table">';

        if($headers !== []) {
            $result .= '<tr class="table__row">';
            foreach ($headers as $class => $col) {
                $classes = is_numeric($class) ? 'table__header' : $this->mergeClasses('table__header', $class);
                $result .= "<th class=\"{$classes}\">{$col}</th>";
            }
            $result .= '</tr>';
        }

        foreach ($table as $row) {
            $result .= '<tr class="table__row">';
            foreach ($row as $class => $col) {
                $classes = is_numeric($class) ? 'table__col' : $this->mergeClasses('table__col', $class);
                $result .= "<td class=\"{$classes}\">{$col}</td>";
            }
            $result .= '</tr>';
        }

        $result .= '</table>';

        return $result;
    }
}
