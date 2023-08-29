<?php

namespace Spatie\FlareClient;

use Spatie\Backtrace\Frame as SpatieFrame;

class Frame
{
    public static function fromSpatieFrame(
        SpatieFrame $frame
    ) {
        return new self($frame);
    }

    protected SpatieFrame $frame;

    public function __construct(
         $frame
    ) {
        $this->frame = $frame;
    }

    public function toArray(): array
    {
        return [
            'file' => $this->frame->file,
            'line_number' => $this->frame->lineNumber,
            'method' => $this->frame->method,
            'class' => $this->frame->class,
            'code_snippet' => $this->frame->getSnippet(30),
            'arguments' => $this->frame->arguments,
            'application_frame' => $this->frame->applicationFrame,
        ];
    }
}
