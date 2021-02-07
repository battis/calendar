<?php


namespace Battis\Calendar\Standards;

/**
 * @link https://tools.ietf.org/html/rfc5234 Augmented BNF for Syntax Specifications: ABNF
 */
interface ABNF
{
    const
        ALPHA = '[a-zA-Z]',
        DIGIT = '\\d',
        HEXDIG = '[0-9a-fA-F]';
}
