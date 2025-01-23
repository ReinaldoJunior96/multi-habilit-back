<?php

/**
 * Configuração para o HTML Purifier no Laravel.
 *
 * Este arquivo define as configurações do Purifier, incluindo os padrões de sanitização,
 * as tags e atributos permitidos, bem como customizações adicionais.
 *
 * @link http://htmlpurifier.org/live/configdoc/plain.html
 */

return [
    // Codificação padrão
    'encoding' => 'UTF-8',

    // Finalizar as configurações automaticamente
    'finalize' => true,

    // Ignorar valores que não sejam strings
    'ignoreNonStrings' => false,

    // Caminho para o cache
    'cachePath' => storage_path('app/purifier'),

    // Permissões do arquivo de cache
    'cacheFileMode' => 0755,

    // Configurações principais
    'settings' => [
        // Configurações padrão para o Purifier
        'default' => [
            'HTML.Doctype' => 'HTML 4.01 Transitional',
            'HTML.Allowed' => 'div,b,strong,i,em,u,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]',
            'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
            'AutoFormat.AutoParagraph' => true,
            'AutoFormat.RemoveEmpty' => true,
        ],

        // Configurações específicas para testes
        'test' => [
            'Attr.EnableID' => true,
        ],

        // Configuração para suporte a YouTube e Vimeo
        'youtube' => [
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/)%',
        ],

        // Definições customizadas para elementos HTML5
        'custom_definition' => [
            'id' => 'html5-definitions',
            'rev' => 1,
            'debug' => false,
            'elements' => [
                ['section', 'Block', 'Flow', 'Common'],
                ['nav', 'Block', 'Flow', 'Common'],
                ['article', 'Block', 'Flow', 'Common'],
                ['aside', 'Block', 'Flow', 'Common'],
                ['header', 'Block', 'Flow', 'Common'],
                ['footer', 'Block', 'Flow', 'Common'],
                ['address', 'Block', 'Flow', 'Common'],
                ['hgroup', 'Block', 'Required: h1 | h2 | h3 | h4 | h5 | h6', 'Common'],
                ['figure', 'Block', 'Optional: (figcaption, Flow) | (Flow, figcaption) | Flow', 'Common'],
                ['figcaption', 'Inline', 'Flow', 'Common'],
                ['video', 'Block', 'Optional: (source, Flow) | (Flow, source) | Flow', 'Common', [
                    'src' => 'URI',
                    'type' => 'Text',
                    'width' => 'Length',
                    'height' => 'Length',
                    'poster' => 'URI',
                    'preload' => 'Enum#auto,metadata,none',
                    'controls' => 'Bool',
                ]],
                ['source', 'Block', 'Flow', 'Common', [
                    'src' => 'URI',
                    'type' => 'Text',
                ]],
                ['s', 'Inline', 'Inline', 'Common'],
                ['var', 'Inline', 'Inline', 'Common'],
                ['sub', 'Inline', 'Inline', 'Common'],
                ['sup', 'Inline', 'Inline', 'Common'],
                ['mark', 'Inline', 'Inline', 'Common'],
                ['wbr', 'Inline', 'Empty', 'Core'],
                ['ins', 'Block', 'Flow', 'Common', ['cite' => 'URI', 'datetime' => 'CDATA']],
                ['del', 'Block', 'Flow', 'Common', ['cite' => 'URI', 'datetime' => 'CDATA']],
            ],
            'attributes' => [
                ['iframe', 'allowfullscreen', 'Bool'],
                ['table', 'height', 'Text'],
                ['td', 'border', 'Text'],
                ['th', 'border', 'Text'],
                ['tr', 'width', 'Text'],
                ['tr', 'height', 'Text'],
                ['tr', 'border', 'Text'],
            ],
        ],

        // Atributos customizados
        'custom_attributes' => [
            ['a', 'target', 'Enum#_blank,_self,_target,_top'],
        ],

        // Elementos customizados
        'custom_elements' => [
            ['u', 'Inline', 'Inline', 'Common'],
        ],
    ],
];
